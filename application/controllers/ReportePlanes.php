<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportePlanes extends CI_Controller
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
        
            $data['title'] = 'Control Vehicular'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['ID_ROL'] = $userInfo->ID_ROL;
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/planes', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function getBitacoraTalonarios(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){
        
            $oni = xss_clean(strtoupper($this->input->post('oni')));
            $nombreCompleto = xss_clean(strtoupper($this->input->post('nombre')));

            $this->form_validation->set_rules('oni', 'oni', 'trim|max_length[20]');
            $this->form_validation->set_rules('nombre', 'nombre', 'trim|max_length[100]');
            if ($this->form_validation->run() == true) {

                    if($nombreCompleto){

                        $nombre = explode(" ", $nombreCompleto);
                        $nombres = $nombre[0]. " ".$nombre[1];
                        $apellidos = $nombre[2]." ".$nombre[3];

                        $talonariosByName = $this->ReportesModel->getBitacoraTalonariosNombre($nombres, $apellidos);
                        $num = 1;

                        foreach ($talonariosByName as $key => $value) {
                            $value->NUM = $num;
                            $value->NOMBRECOMPLETO = $value->APEPER.", ".$value->NOMPER;
                            if($value->TOT_IMPUESTAS == 25) $value->ULTIMAESQUELA = "FINALIZADA";
                            if($value->TOT_IMPUESTAS == 0) $value->ULTIMAESQUELA = "NINGUNA";
                            if($value->TOT_IMPUESTAS > 0 && $value->TOT_IMPUESTAS < 25) $value->ULTIMAESQUELA = $value->TOT_IMPUESTAS;
                            $value->PENDIENTES = 25 - $value->TOT_IMPUESTAS;
                            $value->TALONARIO = $value->SERIE_INICIAL." - ".$value->SERIE_FINAL;
                            $num++;
                        }
                    //print_r($talonariosByName);
                    $arr = array('data' => $talonariosByName);
                    echo json_encode($arr);

                     }

                     else{
                    $talonariosByOni = $this->ReportesModel->getBitacoraTalonariosOni($oni);
                    $num = 1;

                    foreach ($talonariosByOni as $key => $value) {
                        $value->NUM = $num;
                        $value->NOMBRECOMPLETO = $value->APEPER.", ".$value->NOMPER;
                        if($value->TOT_IMPUESTAS == 25) $value->ULTIMAESQUELA = "FINALIZADA";
                        if($value->TOT_IMPUESTAS == 0) $value->ULTIMAESQUELA = "NINGUNA";
                        if($value->TOT_IMPUESTAS > 0 && $value->TOT_IMPUESTAS < 25) $value->ULTIMAESQUELA = $value->TOT_IMPUESTAS;
                        $value->PENDIENTES = 25 - $value->TOT_IMPUESTAS;
                        $value->TALONARIO = $value->SERIE_INICIAL." - ".$value->SERIE_FINAL;
                        $num++;
                     }
                    //print_r($talonariosByName);
                    $arr = array('data' => $talonariosByOni);
                    echo json_encode($arr);
                    }
            }else {
                echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function crearBoleta($serieInicial, $serieFinal){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){
        
            $esquelas = $this->ReportesModel->getEsquelasBySerie($serieInicial, $serieFinal); 
            //print_r($esquelas);
            $oniUser = $this->validateuser_library->ONIByUser($this->username);
            $Nomunidad = $this->validateuser_library->returnCcosto($this->username);

            $datos = array(
                'ONIUSER' => $oniUser,
                'NOMBRE' => $this->username,
                'UNIDAD' => $Nomunidad
            );

            $this->load->library('PDF_Boleta');
            $pdf = new PDF_Boleta();
            $pdf->data($datos);
            
            $pdf->AddPage('L', 'Letter', 0);
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,35,55,30,25,25,25,25,25,30,45));
            $pdf->SetAligns(array('C','C','L','L','L','L','R','L','L','R','L'));
            $correlativo = 1;
            $altoEncab = 13;
            $sety = 40;
            $pdf->RowHeader(array(utf8_decode("N°"), "SERIE", "NOMBRE DEL INFRACTOR", "PLACA", "COD", "LUGAR INFRACCION", "FECHA", "CLASE Y NUM LICENCIA", "ONI RECIBE"));
            $pdf->SetY(38);
            foreach ($esquelas as $value) {

                if($value->NOMBRES == "CONDUCTOR AUSENTE"){
                    $nombre = "CONDUCTOR AUSENTE";
                }else{
                    $nombre = $value->NOMBRES.' '.$value->APELLIDOS;
                }
                $pdf->SetX(8);
                
                $pdf->Row(array($correlativo++, $value->NUM_SERIE, utf8_decode($nombre), $value->NUM_PLACA, $value->ID_UNIDAD_TTO." TTO", utf8_decode($value->DIRECCION), $value->FECHA_ESQUELA, $value->CLASE_VEHICULO." ".$value->NUM_LICENCIA, $value->ONI_IMPONE),0);
                $pdf->SetX(8);
                /* $pdf->MultiCell(8,$altoEncab,$correlativo,1,'C');
                $pdf->SetXY(16, $sety);
                $pdf->MultiCell(20,$altoEncab,$value->NUM_SERIE,1,'C');
                $pdf->SetXY(36, $sety);
                $pdf->MultiCell(20,$altoEncab,$value->ID_UNIDAD_TTO." TTO",1,'C');
                $pdf->SetXY(56, $sety);
                $pdf->MultiCell(20,$altoEncab,$value->NUM_PLACA,1,'C');
                $pdf->SetXY(76, $sety);
                $pdf->MultiCell(60,$altoEncab,utf8_decode($nombre),1,'C');
                $pdf->SetXY(136, $sety);
                $pdf->MultiCell(60,$altoEncab,utf8_decode($value->DIRECCION),1,'C');
                $pdf->SetXY(196, $sety);
                $pdf->MultiCell(25,$altoEncab,$value->FECHA_ESQUELA,1,'C');
                $pdf->SetXY(221, $sety);
                $pdf->MultiCell(25,$altoEncab,$value->CLASE_VEHICULO."\n".$value->NUM_LICENCIA,1,'C');
                $pdf->SetXY(246, $sety);
                $pdf->MultiCell(20,$altoEncab,$value->ONI_IMPONE,1,'C');
                

                $sety += 13;
                $pdf->SetY($sety);
                $pdf->SetX(8);
                $correlativo++;

                if($sety == 195){
                    $pdf->AddPage('L', 'Letter');
                    $sety = 35;
                    $pdf->SetY($sety);
                    $pdf->SetX(8);
                }
                */
            }


            $pdfString = $pdf->Output("ReporteConDecomisos"."_".date('d/m/Y').".pdf", "S");
            $pdfBase64 = base64_encode($pdfString);
            echo 'data:application/pdf;base64,' . $pdfBase64; 
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function boletaExcel($serieInicial, $serieFinal){
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1))) { 
        
            $esquelas = $this->ReportesModel->getEsquelasBySerie($serieInicial, $serieFinal); 
            $oniUser = $this->validateuser_library->ONIByUser($this->username);
            $fileName = "Boleta de Control";
            $Nomunidad = $this->validateuser_library->returnCcosto($this->username);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('F1', 'BOLETA DE CONTROL ESQUELAS DE INFORMACION IMPUESTAS POR CADA ELEMENTO. USO EXCLUSIVO DEL ELEMENTO POLICIAL');
            $sheet->setCellValue('B2', 'NOMBRE: '.$this->username);
            $sheet->setCellValue('D2', 'ONI: '. $oniUser);
            $sheet->setCellValue('F2', 'UNIDAD: '.$Nomunidad);

            $sheet->setCellValue('A3', 'N°');
            $sheet->setCellValue('B3', 'SERIE');
            $sheet->setCellValue('C3', 'NOMBRE DEL INFRACTOR');
            $sheet->setCellValue('D3', 'PLACA ');
            $sheet->setCellValue('E3', 'COD');
            $sheet->setCellValue('F3', 'LUGAR DE LA INGRACCION');
            $sheet->setCellValue('G3', 'FECHA');
            $sheet->setCellValue('H3', 'CLASE Y NUM DE LICENCIA');
            $sheet->setCellValue('I3', 'ONI RECIBE');
            $rows = 4;
            $num = 1;
            
            foreach ($esquelas as $value) {
                if($value->NOMBRES == "CONDUCTOR AUSENTE"){
                    $nombre = "CONDUCTOR AUSENTE";
                }else{
                    $nombre = $value->NOMBRES.' '.$value->APELLIDOS;
                }
                $sheet->setCellValue('A' . $rows, trim($num));
                $sheet->setCellValue('B' . $rows, trim($value->NUM_SERIE));
                $sheet->setCellValue('C' . $rows, $nombre);
                $sheet->setCellValue('D' . $rows, trim($value->NUM_PLACA));
                $sheet->setCellValue('E' . $rows, trim($value->ID_UNIDAD_TTO." TTO"));                    
                $sheet->setCellValue('F' . $rows, trim(utf8_decode($value->DIRECCION)));
                $sheet->setCellValue('G' . $rows, trim($value->FECHA_ESQUELA));
                $sheet->setCellValue('H' . $rows, trim($value->CLASE_VEHICULO." ".$value->NUM_LICENCIA));
                $sheet->setCellValue('I' . $rows, trim($value->ONI_IMPONE));
                $rows++;
                $num++;
            }



            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"');
            $writer->save('php://output');

        
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

}

?>