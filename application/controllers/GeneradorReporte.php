<?php
defined('BASEPATH') or exit('No direct script access allowed');
class GeneradorReporte extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->username = $this->session->userdata['username'];
        $this->load->model('TransitoModel');
        $this->load->model('Auditoria_model');
        $this->load->model('Personal_model');
        $this->load->model('Usuarios_model');
        $this->load->model('ReportesModel');
        $this->load->helper('file');
        $this->load->helper('url_helper');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numerico.');
        $this->form_validation->set_message('max_length', '%s: el maximo de caracteres es %s');
        $this->load->library('authorization_token');
        $this->load->library('timejwt_library');
        $this->load->library('audit_library');
        $this->load->library('validateuser_library');
        $this->load->library('upload');
        $this->tableName = 'TTO_TE_ESQUELAS';
        $this->primaryKey = 'ID_FILA';
    }

    public function index()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1))) {
            
            $sessionTimeout = $this->timejwt_library->differenceTime(
            $this->CI->config->item('jwt_expire_time'),
            $is_valid_token['data']->time);

            $user = $this->session->userdata('username');
            $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
        
            $data['title'] = 'Generador de Reportes'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['ID_ROL'] = $userInfo->ID_ROL;
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/generadorReportes', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function crear(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){ 

            $oniUser = $this->validateuser_library->ONIByUser($this->username);
            $unidad = $this->validateuser_library->returnIdUnidadTTO($this->username);

            $fechaadqui = xss_clean($this->input->post('fechaadqui'));
            $departamento = xss_clean($this->input->post('departamento'));
            $dirigido = strtoupper(xss_clean($this->input->post('dirigido')));
            $numOficio = strtoupper(xss_clean($this->input->post('numOficio')));
            $cargo = strtoupper(xss_clean($this->input->post('cargo')));
            $remite = strtoupper(xss_clean($this->input->post('remite')));
            $cargoRemite = strtoupper(xss_clean($this->input->post('cargoRemite')));
            $fechaDesde = xss_clean($this->input->post('fechaDesde'));
            $fechaHasta = xss_clean($this->input->post('fechaHasta'));
            $tipoFecha = xss_clean($this->input->post('tipoFecha'));
            
            $this->form_validation->set_rules('fechaadqui', 'fechaadqui', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('numOficio', 'numOficio', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('departamento', 'departamento', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('dirigido', 'dirigido', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('cargo', 'cargo', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('remite', 'remite', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('cargoRemite', 'cargoRemite', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('fechaDesde', 'fechaDesde', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('fechaHasta', 'fechaHasta', 'trim|required|max_length[20]');
          
            if ($this->form_validation->run() == true) {
                $fecha1 = $this->convertDateOracle($fechaDesde);
                $fecha2 = $this->convertDateOracle($fechaHasta);
                $totEsquelas = $this->ReportesModel->getNumEsquelas($fecha1, $fecha2, $unidad, $this->tableName, $tipoFecha);
                $remitidas = $this->ReportesModel->getEsquelasRemitidas($fecha1, $fecha2, $unidad, $this->tableName, $tipoFecha);
                if($totEsquelas){
                //print_r($totEsquelas);
                $ids = [];
                $num_d_tarjeta = 0;
                $num_d_lic = 0;
                $num_d_vehiculo = 0;
                $num_d_1plca = 0;
                $num_d_2plca = 0;
                $num_d_permiso = 0;
                $num_d_poliza = 0;
                $num_esquelas = 0;
                
                foreach ($totEsquelas as $key => $value) {
                
                    //print_r($value->ID_FILA);

                    array_push($ids, $value->ID_FILA);
                    if($value->NUM_DECOMISO_TARJETA) $num_d_tarjeta++;
                    if($value->NUM_DECOMISO_LICENCIA) $num_d_lic++;
                    if($value->NUM_DECOMISO_VEHICULO) $num_d_vehiculo++;
                    if($value->NUM_DECOMISO_1PLACA) $num_d_1plca++;
                    if($value->NUM_DECOMISO_2PLACA) $num_d_2plca++;
                    if($value->NUM_DECOMISO_PERMISO) $num_d_permiso++;
                    if($value->NUM_DECOMISO_POLIZA) $num_d_poliza++;
                    $num_esquelas++;

                    
                }
               
                $data = array(
                    'NUM_OFICIO' => $numOficio,
                    'ID_UNIDAD_TTO' => $unidad,
                    'FECHA_REMISION' => $this->convertDateOracle($fechaadqui),
                    'TOT_ESQUELAS' => $num_esquelas,
                    'TOT_D_TARJETA' => $num_d_tarjeta,
                    'TOT_D_LICENCIA' => $num_d_lic,
                    'TOT_D_1_PLACA' => $num_d_1plca,
                    'TOT_D_2_PLACA' => $num_d_2plca,
                    'TOT_D_POLIZA' => $num_d_poliza,
                    'TOT_D_PERMISO' => $num_d_permiso,
                    'TOT_D_VEHICULO' => $num_d_vehiculo,
                    'PERSONA_DESTINO' => $dirigido,
                    'CARGO_DESTINO' => $cargo,
                    'PERSONA_REMITENTE' => $remite,
                    'CARGO_REMITENTE' => $cargoRemite
                );

                $this->ReportesModel->store("TTO_TE_REMISION", $data);
                
                 
                $Nomunidad = $this->validateuser_library->returnCcosto($this->username);
                $departamento = $this->TransitoModel->getById('CATALOGOSPNC.C_DEPARTAMENTOS', $departamento, "CODEP");

                $datosPdfOficio = array(
                'USUARIO' => $this->username,
                'UNIDAD' => $Nomunidad,
                'NUM_OFICIO' => $numOficio,
                'CARGO' => $cargo,
                'NOM_SER' => $dirigido,
                'NUM_ESQUELAS' => $num_esquelas,
                'TOT_ESQUELAS' => $num_esquelas,
                'TOT_D_TARJETA' => $num_d_tarjeta,
                'TOT_D_LICENCIA' => $num_d_lic,
                'TOT_D_1_PLACA' => $num_d_1plca,
                'TOT_D_2_PLACA' => $num_d_2plca,
                'TOT_D_POLIZA' => $num_d_poliza,
                'TOT_D_PERMISO' => $num_d_permiso,
                'TOT_D_VEHICULO' => $num_d_vehiculo,
                'REMITE' => $remite,
                'CARGO_REMITE' => $cargoRemite,
                'ONIUSER' => $oniUser
            );            
                    
                    $this->load->library('PDF_Remision');
                    $pdf = new PDF_Remision();
                    $pdf->data($datosPdfOficio);
                    //$pdf->SetOniUser('12344', 'adrian');
                    $pdf->AddPage('P', 'Letter', 0);
                    $pdf->AliasNbPages();
                    $pdf->SetWidths(array(10,35,55,30,25,25,25,25,25,30,45));
                    $pdf->SetAligns(array('C','C','L','L','L','L','R','L','L','R','L'));
                            
                    $pdfString = $pdf->Output("Certificacion_arma"."_".date('d/m/Y').".pdf", "S");
                    $pdfBase64 = base64_encode($pdfString);
                    echo 'data:application/pdf;base64,' . $pdfBase64;
    
               // echo json_encode(array("status" => true, 'messages' => 'ok'));
                }else{
                    echo json_encode(array("status" => false, 'messages' => ''));
                }    
           } else {
                echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
            }

        


        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }
   

    

    public function getReporteSinDecomiso(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){ 

            $oniUser = $this->validateuser_library->ONIByUser($this->username);
            $unidad = $this->validateuser_library->returnIdUnidadTTO($this->username);

            $fechaadqui = xss_clean($this->input->post('fechaadqui'));
            $departamento = xss_clean($this->input->post('departamento'));
            $dirigido = strtoupper(xss_clean($this->input->post('dirigido')));
            $numOficio = strtoupper(xss_clean($this->input->post('numOficio')));
            $cargo = strtoupper(xss_clean($this->input->post('cargo')));
            $remite = strtoupper(xss_clean($this->input->post('remite')));
            $cargoRemite = strtoupper(xss_clean($this->input->post('cargoRemite')));
            $fechaDesde = xss_clean($this->input->post('fechaDesde'));
            $fechaHasta = xss_clean($this->input->post('fechaHasta'));
            $tipoFecha = xss_clean($this->input->post('tipoFecha'));
            
            $this->form_validation->set_rules('fechaadqui', 'fechaadqui', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('numOficio', 'numOficio', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('departamento', 'departamento', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('dirigido', 'dirigido', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('cargo', 'cargo', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('remite', 'remite', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('cargoRemite', 'cargoRemite', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('fechaDesde', 'fechaDesde', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('fechaHasta', 'fechaHasta', 'trim|required|max_length[20]');
          
            if ($this->form_validation->run() == true) {
                $fecha1 = $this->convertDateOracle($fechaDesde);
                $fecha2 = $this->convertDateOracle($fechaHasta);
                
                $remitidas = $this->ReportesModel->getEsquelasRemitidasDeco($fecha1, $fecha2, $unidad, $this->tableName, $tipoFecha);
               
            
      
                $Nomunidad = $this->validateuser_library->returnCcosto($this->username);
                $departamento = $this->TransitoModel->getById('CATALOGOSPNC.C_DEPARTAMENTOS', $departamento, "CODEP");

                $datosPdfSinDecomiso = array(
                'USUARIO' => $this->username,
                'UNIDAD' => $Nomunidad,
                'NUM_OFICIO' => $numOficio,
                'CARGO' => $cargo,
                'NOM_SER' => $dirigido,
                'REMITE' => $remite,
                'CARGO_REMITE' => $cargoRemite,
                'DESDE' => $fecha1,
                'HASTA' => $fecha2,
                'ONIUSER' => $oniUser
            );            
                    
                    $this->load->library('PDF_Rep_SinDecomisos');
                    $pdf = new PDF_Rep_SinDecomisos();
                    $pdf->data($datosPdfSinDecomiso);
                    //$pdf->SetOniUser('12344', 'adrian');
                    $pdf->AddPage('L', 'Letter', 0);
                    $pdf->AliasNbPages();
                    $pdf->SetWidths(array(10,35,55,30,25,25,25,25,25,30,45));
                    $pdf->SetAligns(array('C','C','L','L','L','L','R','L','L','R','L'));
                    
                    $correlativo = 1;
                    $sety = 35;
                    $pdf->SetY($sety);
                    $pdf->SetX(8);
                    $altoEncab = 5;
                    $decomisos = "";
                    foreach ($remitidas as $value) {
                       
                       if($value->NOMBRES == "CONDUCTOR AUSENTE"){
                        $nombre = "CONDUCTOR AUSENTE";
                        }else{
                            $nombre = $value->NOMBRES.' '.$value->APELLIDOS;
                        }
                        if($value->DECOM_TARJETA) $decomisos = "TC ";
                        if($value->DECOM_LICENCIA) $decomisos .= "LIC ";
                        if($value->DECOM_1_PLACA) $decomisos .= "1PLA ";
                        if($value->DECOM_2_PLACA) $decomisos .= "2PLA ";
                        if($value->DECOM_PERMISO_L) $decomisos .= "PER ";
                        if($value->DECOM_POLIZA) $decomisos .= "POL ";

                        if($decomisos == ""){

                        $pdf->Cell(8,$altoEncab,$correlativo,1,0,'C');
                        $pdf->Cell(13,$altoEncab,$value->ID_FILA,1,0,'C');
                        $pdf->Cell(19,$altoEncab,$value->NUM_SERIE,1,0,'C');
                        $pdf->Cell(30,$altoEncab,$value->NUM_LICENCIA,1,0,'C');
                        $pdf->Cell(63,$altoEncab,utf8_decode($nombre),1,0,'C');
                        $pdf->Cell(22,$altoEncab,$value->NUM_PLACA,1,0,'C');
                        $pdf->Cell(30,$altoEncab,$value->CLASE_VEHICULO,1,0,'C');
                        $pdf->Cell(13,$altoEncab,$value->RUTA,1,0,'C');
                        $pdf->Cell(15,$altoEncab,$value->NUM_FALTA,1,0,'C');
                        $pdf->Cell(20,$altoEncab,$value->FECHA_ESQUELA,1,0,'C');
                        $pdf->Cell(15,$altoEncab,$value->HORA_ESQUELA,1,0,'C');
                        $pdf->Cell(15,$altoEncab,$value->ONI_IMPONE,1,0,'C');
                        $sety += 5;
                        
                        $pdf->SetY($sety);
                        $pdf->SetX(8);
                        $correlativo++;

                        if($sety == 195){
                            $pdf->AddPage('L', 'Letter');
                            $sety = 35;
                            $pdf->SetY($sety);
                            $pdf->SetX(8);
                        }

                        
                    }
                    $decomisos = "";
                    }
                    
                    $pdfString = $pdf->Output("ReporteSinDecomisos"."_".date('d/m/Y').".pdf", "S");
                    $pdfBase64 = base64_encode($pdfString);
                    echo 'data:application/pdf;base64,' . $pdfBase64;         
               // echo json_encode(array("status" => true, 'messages' => 'ok'));
                
           } else {
                echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getReporteConDecomiso(){
        
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){ 

            $oniUser = $this->validateuser_library->ONIByUser($this->username);
            $unidad = $this->validateuser_library->returnIdUnidadTTO($this->username);

            $fechaadqui = xss_clean($this->input->post('fechaadqui'));
            $departamento = xss_clean($this->input->post('departamento'));
            $dirigido = strtoupper(xss_clean($this->input->post('dirigido')));
            $numOficio = strtoupper(xss_clean($this->input->post('numOficio')));
            $cargo = strtoupper(xss_clean($this->input->post('cargo')));
            $remite = strtoupper(xss_clean($this->input->post('remite')));
            $cargoRemite = strtoupper(xss_clean($this->input->post('cargoRemite')));
            $fechaDesde = xss_clean($this->input->post('fechaDesde'));
            $fechaHasta = xss_clean($this->input->post('fechaHasta'));
            $tipoFecha = xss_clean($this->input->post('tipoFecha'));
            
            $this->form_validation->set_rules('fechaadqui', 'fechaadqui', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('numOficio', 'numOficio', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('departamento', 'departamento', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('dirigido', 'dirigido', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('cargo', 'cargo', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('remite', 'remite', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('cargoRemite', 'cargoRemite', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('fechaDesde', 'fechaDesde', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('fechaHasta', 'fechaHasta', 'trim|required|max_length[20]');
          
            if ($this->form_validation->run() == true) {
                $fecha1 = $this->convertDateOracle($fechaDesde);
                $fecha2 = $this->convertDateOracle($fechaHasta);
                $totEsquelas = $this->ReportesModel->getNumEsquelas($fecha1, $fecha2, $unidad, $this->tableName, $tipoFecha);
                $remitidasDeco = $this->ReportesModel->getEsquelasRemitidasDeco($fecha1, $fecha2, $unidad, $this->tableName, $tipoFecha);
               // print_r($remitidasDeco);
               // die;
              
                $Nomunidad = $this->validateuser_library->returnCcosto($this->username);
                
                $ids = [];
                $num_d_tarjeta = 0;
                $num_d_lic = 0;
                $num_d_vehiculo = 0;
                $num_d_1plca = 0;
                $num_d_2plca = 0;
                $num_d_permiso = 0;
                $num_d_poliza = 0;
                $num_esquelas = 0;
                
                foreach ($totEsquelas as $key => $value) {
                
                    //print_r($value->ID_FILA);

                    array_push($ids, $value->ID_FILA);
                    if($value->NUM_DECOMISO_TARJETA) $num_d_tarjeta++;
                    if($value->NUM_DECOMISO_LICENCIA) $num_d_lic++;
                    if($value->NUM_DECOMISO_VEHICULO) $num_d_vehiculo++;
                    if($value->NUM_DECOMISO_1PLACA) $num_d_1plca++;
                    if($value->NUM_DECOMISO_2PLACA) $num_d_2plca++;
                    if($value->NUM_DECOMISO_PERMISO) $num_d_permiso++;
                    if($value->NUM_DECOMISO_POLIZA) $num_d_poliza++;
                    $num_esquelas++;

                    
                }

                $idRemision = $this->ReportesModel->getRemision();
                $fechaRem = $this->convertDateOracle(date('d/M/y'));
                $this->auditoria('TTO_TE_REMISION', $idRemision[0]->NUM_REM,'CREAR','TODOS','NO APLICA','NO APLICA'); 
               // print_r($idRemision[0]->NUM_REM);
               // print_r($fechaRem);
               // die;
                $dataUpdate = array(

                    'ID_REMISION' => $idRemision[0]->NUM_REM,
                    'ESTADO' => 'REMITIDA',
                    'FECHA_REM' => $fechaRem
                );

                for($x = 0; $x < $num_esquelas; $x++){

                    $idEsquela = $ids[$x];
                    $existencia = $this->TransitoModel->getById($this->tableName, $idEsquela, "ID_FILA");
                    if($existencia){
                         
                       $this->ReportesModel->updateEsquelasPorRemision($dataUpdate, $this->tableName, $idEsquela);
                        foreach  ($dataUpdate as $clave => $valor) {
                            if($dataUpdate[$clave] != $existencia->$clave){
                                $this->auditoria($this->tableName, $existencia->ID_FILA,'REMISION',$clave,$existencia->$clave,$dataUpdate[$clave]);
                            }                        
                        }                    
                        
                       
                    }
                }

                
                $datosPdfDecomiso = array(
                
                'NUM_OFICIO' => $numOficio,
                'USUARIO' => $this->username,
                'UNIDAD' => $Nomunidad,
                'DESDE' => $fecha1,
                'HASTA' => $fecha2,
                'ONIUSER' => $oniUser
                
            );            
                    
                    $this->load->library('PDF_Rep_Decomisos');
                    $pdf = new PDF_Rep_Decomisos();
                    $pdf->data($datosPdfDecomiso);
                    //$pdf->SetOniUser('12344', 'adrian');
                    $pdf->AddPage('L', 'Letter', 0);
                    $pdf->AliasNbPages();
                    $pdf->SetWidths(array(10,35,55,30,25,25,25,25,25,30,45));
                    $pdf->SetAligns(array('C','C','L','L','L','L','R','L','L','R','L'));

                    $correlativo = 1;
                    $sety = 35;
                    $pdf->SetY($sety);
                    $pdf->SetX(8);
                    $altoEncab = 5;
                    $decomisos = "";
                    foreach ($remitidasDeco as $value) {
                        // $pdf->Row(array($correlativo++, $value->ID_FILA, $value->NUM_SERIE, $value->NUM_LICENCIA, ($value->NOMBRES.' '.$value->APELLIDOS), $value->NUM_PLACA, $value->CLASE_VEHICULO, $value->RUTA, $value->ID_FALTA, $value->FECHA_ESQUELA, $value->HORA_ESQUELA, $value->ONI_IMPONE),0);
                        if($value->NOMBRES == "CONDUCTOR AUSENTE"){
                            $nombre = "CONDUCTOR AUSENTE";
                        }else{
                            $nombre = $value->NOMBRES.' '.$value->APELLIDOS;
                        }

                        if($value->DECOM_TARJETA) $decomisos = "TC ";
                        if($value->DECOM_LICENCIA) $decomisos .= "LIC ";
                        if($value->DECOM_1_PLACA) $decomisos .= "1PLA ";
                        if($value->DECOM_2_PLACA) $decomisos .= "2PLA ";
                        if($value->DECOM_PERMISO_L) $decomisos .= "PER ";
                        if($value->DECOM_POLIZA) $decomisos .= "POL ";
                        // $pdf->Text(50, 180, 'VEHICULO: '.$num_d_vehiculo);
                        if($decomisos){
                        $pdf->Cell(8,$altoEncab,$correlativo,1,0,'C');
                        $pdf->Cell(35,$altoEncab,$decomisos,1,0,'C');
                        $pdf->Cell(35,$altoEncab,$value->NUM_PLACA,1,0,'C');
                        $pdf->Cell(70,$altoEncab,utf8_decode($nombre),1,0,'C');
                        $pdf->Cell(30,$altoEncab,$value->NUM_FALTA,1,0,'C');
                        $pdf->Cell(30,$altoEncab,$value->NUM_SERIE,1,0,'C');
                        $pdf->Cell(30,$altoEncab,$value->FECHA_ESQUELA,1,0,'C');
                        $pdf->Cell(30,$altoEncab,$value->ONI_IMPONE,1,0,'C');
                         $sety += 5;
                         
                         $pdf->SetY($sety);
                         $pdf->SetX(8);
                         $correlativo++;
 
                         if($sety == 195){
                             $pdf->AddPage('L', 'Letter');
                             $sety = 35;
                             $pdf->SetY($sety);
                             $pdf->SetX(8);
                         }
                         $decomisos = "";
                        }
                     }   
                     
                     $pdf->SetFont('Arial', 'B', 9);
                     if($num_d_tarjeta > 0)$pdf->Text(50, 150, utf8_decode('TARJETAS DE CIRCULACIÓN: ').$num_d_tarjeta);
                     if($num_d_lic > 0) $pdf->Text(50, 155, 'LICENCIAS DE CONDUCIR: '.$num_d_lic);
                     if($num_d_1plca > 0) $pdf->Text(50, 160, 'PLACAS IMPARES: '.$num_d_1plca);
                     if($num_d_2plca > 0) $pdf->Text(50, 165, 'PLACAS PARES: '.$num_d_2plca);
                     if($num_d_poliza > 0) $pdf->Text(50, 170, 'POLIZA: '.$num_d_poliza);
                     if($num_d_permiso > 0) $pdf->Text(50, 175, 'PERMISO: '.$num_d_permiso);
                    // $pdf->Text(50, 180, 'VEHICULO: '.$num_d_vehiculo);
                     $pdf->Text(50, 180, 'TOTAL DE DECOMISOS: '.$num_esquelas);

                    $pdfString = $pdf->Output("ReporteConDecomisos"."_".date('d/m/Y').".pdf", "S");
                    $pdfBase64 = base64_encode($pdfString);
                    echo 'data:application/pdf;base64,' . $pdfBase64;       
                    
                    
               // echo json_encode(array("status" => true, 'messages' => 'ok'));
                
           } else {
                echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    private function convertDateOracle($date)
    {
        if (empty($date)) {
            return null;
        }
        $dateReplace = $date = str_replace('/', '-', $date);
        $dateTransform = date('d-M-y', strtotime($dateReplace));
        list($day, $month, $year)=explode('-', $dateTransform);
        $monthUpper =  strtoupper($month);
        return $day.'-'.$monthUpper.'-'.$year;
    }

    private function auditoria($tabla, $id,$operacion,$campo,$vAntiguo,$vNuevo){
        $this->Auditoria_model->create(
            $this->audit_library->auditArray(
                $tabla,
                $id,
                $operacion,
                $this->username,
                $campo,
                $vAntiguo,
                $vNuevo,
                $this->input->ip_address()
            )
        );
    }

    public function getSimulacion(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){ 
            $unidad = $this->validateuser_library->returnIdUnidadTTO($this->username);
            $fechaDesde = xss_clean($this->input->post('fechaDesdesim'));
            $fechaHasta = xss_clean($this->input->post('fechaHastasim'));
            $tipoFecha = xss_clean($this->input->post('tipoFecha'));
            
            $this->form_validation->set_rules('fechaDesdesim', 'fechaDesdesim', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('fechaHastasim', 'fechaHastasim', 'trim|required|max_length[20]');

            if ($this->form_validation->run() == true) {
                $fecha1 = $this->convertDateOracle($fechaDesde);
                $fecha2 = $this->convertDateOracle($fechaHasta);
                $data = $this->ReportesModel->getReporteSimulacion($fecha1, $fecha2, $unidad, $this->tableName, $tipoFecha, 'PROCESADA');
                $decomisos = '';
                for($x = 0; $x < count($data); $x++){
                    if($data[$x]->DECOM_TARJETA) $decomisos = '- Tarjeta ';
                    if($data[$x]->DECOM_LICENCIA) $decomisos .= '- Licencia';
                    if($data[$x]->DECOM_VEHICULO) $decomisos .= '- Vehiculo';
                    if($data[$x]->DECOM_1_PLACA) $decomisos .= '- Placa impar';
                    if($data[$x]->DECOM_2_PLACA) $decomisos .= '- Placa par';
                    if($data[$x]->DECOM_PERMISO_L) $decomisos .= '- Permiso';
                    if($data[$x]->DECOM_POLIZA) $decomisos .= '- Poliza';
                    $data[$x]->DECOMISOS = $decomisos;
                    $decomisos = "";
                }
               //print_r($data);
                //$data->CONTAR = 12;
                if ($data) {
                    $arr = array('data' => $data);
                } else{
                    $arr = array('data' => false);
                }               
                
                echo json_encode($arr);
            }

        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
            
    }

    public function getNumEsquelas(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){ 
            $fechaDesde = xss_clean($this->input->post('fechaDesdesim'));
            $fechaHasta = xss_clean($this->input->post('fechaHastasim'));
            $unidad = $this->validateuser_library->returnIdUnidadTTO($this->username);
            $tipoFecha = xss_clean($this->input->post('tipoFecha'));
            $fecha1 = $this->convertDateOracle($fechaDesde);
            $fecha2 = $this->convertDateOracle($fechaHasta);
            $data = $this->ReportesModel->getReporteSimulacion($fecha1, $fecha2, $unidad, $this->tableName, $tipoFecha, 'PROCESADA');

            $total = 0;
            $conDecomiso = 0;
            $sinDecomiso = 0;
            for($x = 0; $x < count($data); $x++){
                 $total++;

                if($data[$x]->DECOM_TARJETA || $data[$x]->DECOM_LICENCIA || $data[$x]->DECOM_VEHICULO || $data[$x]->DECOM_1_PLACA || $data[$x]->DECOM_2_PLACA || $data[$x]->DECOM_PERMISO_L || $data[$x]->DECOM_POLIZA) { $conDecomiso++; } else { $sinDecomiso++;}
            }

            $datos = array(
                'total' => $total,
                'sin_decomiso' => $sinDecomiso,
                'con_decomiso' => $conDecomiso
            );

            echo json_encode($datos);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getOficios(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){ 
        
            $fecha = xss_clean($this->input->post('fecha'));
            $tipoBusqueda = xss_clean($this->input->post('tipoFecha'));
            $this->form_validation->set_rules('fecha', 'fecha', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('tipoFecha', 'tipoFecha', 'trim|required|max_length[20]');
            $unidad = $this->validateuser_library->returnIdUnidadTTO($this->username);
            $fecha1 = $this->convertDateOracle($fecha);
            if ($this->form_validation->run() == true) {
                $oficio = $this->ReportesModel->getOficio($fecha1, $tipoBusqueda, $unidad);

                if ($oficio) {
                    $arr = array('data' => $oficio);
                } else{
                    $arr = array('data' => false);
                }

                echo json_encode($oficio);
            }else {
                echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function crearOficio($numOficio){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){ 
        
            $oficio = $this->ReportesModel->getOficioById($numOficio);
            $oniUser = $this->validateuser_library->ONIByUser($this->username);
            //print_r($oficio);
           //die;
            $data = array(
                'USUARIO' => $oficio->USER_ADD,
                'NUM_OFICIO' => $oficio->NUM_OFICIO,
                'NOM_SER' => $oficio->PERSONA_DESTINO,
                'CARGO' => $oficio->CARGO_DESTINO,
                'NUM_ESQUELAS' => $oficio->TOT_ESQUELAS,
                'UNIDAD' => $oficio->NOMBRE,
                'TOT_D_TARJETA' => $oficio->TOT_D_TARJETA,
                'TOT_D_LICENCIA' => $oficio->TOT_D_LICENCIA,
                'TOT_D_1_PLACA' => $oficio->TOT_D_1_PLACA,
                'TOT_D_2_PLACA' => $oficio->TOT_D_2_PLACA,
                'TOT_D_POLIZA' => $oficio->TOT_D_POLIZA,
                'TOT_D_VEHICULO' => $oficio->TOT_D_VEHICULO,
                'TOT_D_PERMISO' => $oficio->TOT_D_PERMISO,
                'REMITE' => $oficio->PERSONA_REMITENTE,
                'CARGO_REMITE' => $oficio->CARGO_REMITENTE,
                'FECHA' => $oficio->FECHA_REMISION,
                'ONIUSER' =>  $oniUser
            );

            $this->load->library('PDF_Remision');
            $pdf = new PDF_Remision();
            $pdf->data($data);
            //$pdf->SetOniUser('12344', 'adrian');
            $pdf->AddPage('P', 'Letter', 0);
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,35,55,30,25,25,25,25,25,30,45));
            $pdf->SetAligns(array('C','C','L','L','L','L','R','L','L','R','L'));
                    
            $pdfString = $pdf->Output("Certificacion_arma"."_".date('d/m/Y').".pdf", "S");
            $pdfBase64 = base64_encode($pdfString);

            echo 'data:application/pdf;base64,' . $pdfBase64;
        
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    

}