<?php
defined('BASEPATH') or exit('No direct script access allowed');
class reasignacionTalonarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->username = $this->session->userdata['username'];
        
        $this->load->model('Auditoria_model');
        $this->load->model('TransitoModel');
        $this->load->model('Personal_model');
        $this->load->model('CentrosCostos_model');
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
        $this->tableName = 'TTO_TE_TALONARIOS';
        $this->primaryKey = 'ID_FILA';
    }

    public function index()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2))) {
            
            $sessionTimeout = $this->timejwt_library->differenceTime(
            $this->CI->config->item('jwt_expire_time'),
            $is_valid_token['data']->time);
             
            $user = $this->session->userdata('username');
            $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
            $userLogin = $this->Personal_model->getNombreById(strtoupper($userInfo->CODPER));   
            
            $data['oniUsuario'] = $userInfo->CODPER;
            $data['nombreUsuario'] = json_encode($userLogin[0]['nombre']);
            $data['cargoUsuario'] = json_encode($userLogin[0]['cargo']);     
            $data['title'] = 'Reasignacion de Talonarios'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['ID_ROL'] = $userInfo->ID_ROL;
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('reasignacionTalonarios/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function store() 
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2))) {
            $status = false;
           
            
            $data = json_decode(xss_clean($this->input->post('array')));
            $today = $this->convertDateOracle(date('d/M/y'));
            $time = date('H:i:s');
            foreach ($data->data as $x) {
            
                
                    $datos = array(
                        'SERIE_INICIAL' => $x[1],
                        'SERIE_FINAL' => $x[2],
                        'ESTADO' => $x[4],
                        'FECHA_ENTREGA' => $today,
                        'HORA_ENTREGA' => $time,
                        'ONI_ENTREGA' => $data->oniUsuario,
                        'ONI_RECIBE' => $data->oniAutorizado
                    );

                    $this->TransitoModel->create($this->tableName,$datos);
                    $id = $this->TransitoModel->getIdTalonario();
                    $this->Auditoria_model->create(
                        $this->audit_library->auditArray(
                            $this->tableName,
                            $id[0]->IDTALONARIO,
                            'CREAR',
                            $this->username,
                            'TODOS',
                            'NO APLICA',
                            'NO APLICA',
                            $this->input->ip_address()
                        )
                    );
                
            }
            //print_r($data->oniAutorizado);
           // print_r($data->nombreAutorizado);
            
           $status = true;
           echo json_encode(array("status" => $status , 'data' => $data));
            
        
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    } 

    public function update()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2))) {
            $status = false;
            $serie = xss_clean($this->input->post('serie'));
            $id_marca = xss_clean($this->input->post('id_marca'));
            $id_modelo = xss_clean($this->input->post('id_modelo'));
            $id_calibre = xss_clean($this->input->post('id_calibre'));
            $id_clase = xss_clean($this->input->post('id_clase'));
            $id_tipo = xss_clean($this->input->post('id_tipo'));
            $descripcion = xss_clean($this->input->post('descripcion'));
            $balistica = xss_clean($this->input->post('balistica'));
            $id_tadqui = xss_clean($this->input->post('id_tadqui'));
            $fechaadqui = xss_clean($this->input->post('fechaadqui'));
            $numerofactura = xss_clean($this->input->post('numerofactura'));
            $numeropoliza = xss_clean($this->input->post('numeropoliza'));
            $packi = xss_clean($this->input->post('packi'));
            $correlativo = xss_clean($this->input->post('correlativo'));
            $valor = xss_clean($this->input->post('valor'));
            $id_proveedor = xss_clean($this->input->post('id_proveedor'));
            $id_procedencia = xss_clean($this->input->post('id_procedencia'));
            $id_fabricante = xss_clean($this->input->post('id_fabricante'));
            $id_pais = xss_clean($this->input->post('id_pais'));
            $observaciones = xss_clean($this->input->post('observaciones'));
            $observaciones2 = xss_clean($this->input->post('observaciones2'));
            $id_estado = xss_clean($this->input->post('id_estado'));
            $caf = xss_clean($this->input->post('caf'));

            $this->form_validation->set_rules('serie', 'Serie', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('balistica', 'Balistica', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('caf', 'caf', 'trim|required|max_length[20]');

            $data = array(
                'ID_FILA' => '',
                'SERIE' => $serie,
                'ID_CLASE' => $id_clase,
                'ID_TIPO' => $id_tipo,
                'ID_MARCA' => $id_marca,
                'ID_MODELO' => $id_modelo,
                'DESCRIPCION' => $descripcion,
                'ID_TADQ' => $id_tadqui,
                'BALISTICA' => $balistica,
                'FECHA_ADQ' => $this->convertDateOracle($fechaadqui),
                'NUM_FACTURA' => $numerofactura,
                'NUM_POLIZA' => $numeropoliza,
                'PACKIN_LIST' => $packi,
                'CORRELATIVO' => $correlativo,
                'PRECIO' => $valor,
                'ID_PROVEEDOR' => $id_proveedor,
                'ID_PROCEDENCIA' => $id_procedencia,
                'ID_FABRICANTE' => $id_fabricante,
                'ID_PAIS' => $id_pais,
                'OBSERVACION' => $observaciones,
                'OBSERVACION2' => $observaciones2,
                'CAF' => $caf,
                'ID_ESTADO' => $id_estado,
                'FECHA_MOD' => '',
                'USER_MOD' => $this->username,
                'ID_CALIBRE' => $id_calibre
            );
            $fechaMod = $this->convertDateOracle(date('d/M/y'));
            $horaMod = date('H:i:s');

            if ($this->form_validation->run() == true) {
                $existencia = $this->Armas_model->getArmas($data['SERIE'],$data['CAF']);
                if($existencia){
                    $data['ID_FILA']  =  $existencia->ID_FILA; 
                    $data['FECHA_MOD'] = $fechaMod;                   
                    $this->Armas_model->update($this->tableName,$data,$this->primaryKey);
                    foreach  ($data as $clave => $valor) {
                        if($data[$clave]!=$existencia->$clave){
                            $this->auditoria($existencia->ID_FILA,'ACTUALIZAR',$clave,$existencia->$clave,$data[$clave]);
                        }                        
                    }                    
                    $status = true;
                    echo json_encode(array("status" => $status , 'data' => $data));
                }
            }
        }
        else {
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

    public function buscar() 
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2))) {
            $userRol =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $userCCosto =  $this->validateuser_library->returnCcosto($is_valid_token['data']->user_name);
            
            $data = $this->Armas_model->getArmasBySerie(               
                xss_clean($this->input->post('buscarSerie'))
            );

            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $arr = array('success' => true, 'data' => $data);

                $marca = $this->Armas_model->getById('ARM_C_MARCAS', $data->ID_MARCA, 'ID_FILA');
                $modelo = $this->Armas_model->getById('ARM_C_MODELOS', $data->ID_MODELO, 'ID_FILA');
                $calibre = $this->Armas_model->getById('ARM_C_CALIBRE', $data->ID_CALIBRE, 'ID_FILA');
                $clases = $this->Armas_model->getById('ARM_C_CLASES', $data->ID_CLASE, 'ID_FILA');
                $tipo = $this->Armas_model->getById('ARM_C_TIPOS', $data->ID_TIPO, 'ID_FILA');
                $adqui = $this->Armas_model->getById('ARM_C_TADQUI', $data->ID_TADQ, 'ID_FILA');
                $proveedor = $this->Armas_model->getById('ARM_C_PROVEEDOR', $data->ID_PROVEEDOR, 'ID_FILA');
                $procedencia = $this->Armas_model->getById('ARM_C_PROCEDENCIA', $data->ID_PROCEDENCIA, 'ID_FILA');
                $fabricante = $this->Armas_model->getById('ARM_C_FABRICANTE', $data->ID_FABRICANTE, 'ID_FILA');
                $pais = $this->Armas_model->getById('ARM_C_PAIS', $data->ID_PAIS, 'ID_FILA');
                $estado = $this->Armas_model->getById('ARM_C_ESTADOS', $data->ID_ESTADO, 'ID_FILA');
                $ccosto = $this->Armas_model->getById('ARM_C_CCOSTO', $data->ID_CCOSTO, 'ID_FILA');
                $persona = $this->Personal_model->datosPersona(strtoupper($data->ONI_ASIGNACION));

                $data->MARCA = !empty($marca->NOM_MARCA) ? $marca->NOM_MARCA: null;
                $data->MODELO = !empty($modelo->NOM_MODELO) ? $modelo->NOM_MODELO: null;
                $data->CALIBRE = !empty($calibre->NOM_CALIBRE) ? $calibre->NOM_CALIBRE: null;
                $data->CLASE = !empty($clases->NOM_CLASE) ? $clases->NOM_CLASE: null;
                $data->TIPO = !empty($tipo->NOM_TIPO) ? $tipo->NOM_TIPO: null;
                $data->ADQUI = !empty($adqui->NOM_TADQUI) ? $adqui->NOM_TADQUI: null;
                $data->VALOR = number_format($data->PRECIO, 2, '.', ',');
                $data->PROVEEDOR = !empty($proveedor->NOM_PROVEEDOR) ? $proveedor->NOM_PROVEEDOR: null;
                $data->PROCEDENCIA = !empty($procedencia->NOM_PROCEDENCIA) ? $procedencia->NOM_PROCEDENCIA: null;
                $data->FABRICANTE = !empty($fabricante->NOM_FABRICANTE) ? $fabricante->NOM_FABRICANTE: null;
                $data->PAIS = !empty($pais->NOM_PAIS) ? $pais->NOM_PAIS: null;
                $data->ESTADO = !empty($estado->NOM_ESTADO) ? $estado->NOM_ESTADO : null;
                $data->CCOSTO = !empty($ccosto->NOM_CC) ? $ccosto->NOM_CC : null;
                $data->PERSONA = !empty($persona->NOMPER) ? $persona->NOMPER.' '.$persona->APEPER : null;
                $data->UNIDAD = !empty($persona->NOMPER) ? $persona->NOMUNIDAD: null;
            }
            if($userRol == 'validacion4' && $userCCosto != $data->CCOSTO){               
                    $arr = array('success' => false, 'data' => '');                
            }
            echo json_encode($arr);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function delete($filaId)
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name,$roles = array(1))) {
            $status = false;
            $armaSeleccionada = $this->Armas_model->getById($this->tableName,$filaId, $this->primaryKey);
            if ($armaSeleccionada) {
                $arraySeleccionado = (array) $armaSeleccionada;
                $this->Armas_model->create('ARM_T_ARMAS_ELIMINADOS',$arraySeleccionado,$this->primaryKey);
                $this->Armas_model->delete($this->tableName,$filaId,$this->primaryKey);
                $this->auditoria($filaId,'BORRAR','TODOS','NO APLICA','NO APLICA');
                $status = true;
            }
            echo json_encode(array('status' => $status));
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getSelectAll()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){
            $searchTerm = strtoupper($this->input->post('searchTerm'));
            $response = $this->Armas_model->getSelectAll($searchTerm,  $this->primaryKey, 'NOM_ESTADO', 'ARM_C_ESTADOS');
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    private function auditoria($id,$operacion,$campo,$vAntiguo,$vNuevo){
        $this->Auditoria_model->create(
            $this->audit_library->auditArray(
                $this->tableName,
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

    public function getHistorial()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){            
            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));
            $serie = xss_clean($this->input->post('serie'));
    
            $query = $this->Armas_model->getByIdRegistros('ARM_T_ASIGNACION',$serie,'SERIE_ASIGNADA' );
            $recordsTotal = $query->num_rows();
            if ($recordsTotal) {
                foreach ($query->result() as $r) {
                    if($r->ESTADO=='1'){
                        $estado = 'ASIGNADO';
                    }
                    elseif($r->ESTADO=='2'){
                        $estado = 'CAMBIO';
                    }else{
                        $estado = 'INDEFINIDO';
                    }
                    
                    $data[] = array(
                            "FECHA" => $r->FECHA_ASIGNA,
                            "ONI_ENTREGA" => $r->ONI_JEFE_BODEGA,
                            "ONI" => $r->ONI_ASIGNACION,
                            "ESTADO" => $estado
                        );
                }

                $result = array(
                        "draw" => $draw,
                        "recordsTotal" => $query->num_rows(),
                        "recordsFiltered" => $query->num_rows(),
                        "data" => $data
                   );
            } else {
                $result = array(
                        "draw" => 0,
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => array()
                   );                   
            }

            echo json_encode($result);
            exit();
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function CrearReporteTalonarioPdf(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){ 
            $oniUser = $this->validateuser_library->ONIByUser($this->username);
            $data = json_decode(xss_clean($this->input->post('array')));
            $correlativo = 0;
          
                    $this->load->library('Pdf_AsignacionTalonarios');
                    $pdf = new Pdf_AsignacionTalonarios();
                    //$pdf->SetAutoPageBreak(true, 8);
                    $pdf->data($data);
                    $pdf->AliasNbPages();
                   
                    $pdf->AddPage('P', 'Letter');
                    $pdf->AliasNbPages();
                    $pdf->SetWidths(array(10,35,55,30,25,25,25,25,25,30,45));
                    $pdf->SetAligns(array('C','C','L','L','L','L','R','L','L','R','L'));
                // print_r($data->data[0][0]); 
                
                
                
              
                $sety = 65;
                $contador = 0;
                $numfilas = 0;
                $setx = 15;
                
                foreach ($data->data as $x) {
                   
                   $ancho = 10;
                   $contador++;
                   $numfilas++;

                   if($numfilas == 61){
                       $pdf->AddPage('P', 'Letter');
                    
                       $sety = 60;
                        //$contador = 0;
                        $numfilas = 1;
                        $setx = 15;
                   }
                   if($contador == 3){
                       $sety += 5;
                       $contador = 1;
                       //$pdf->SetX($setx);
                       $pdf->SetY($sety);
                   }
                   for($i = 0; $i < 3; $i++){
                    if($contador == 1){
                        if($i == 0){
                            $pdf->SetX(15);
                            $ancho = 10;
                        }
                        if($i == 1){
                            $pdf->SetX(15+10);
                            $ancho = 40;
                        }
                        if($i == 2){
                            $pdf->SetX(25+40);
                            $ancho = 40;
                        }
                        
                    }else{
                        if($i == 0){
                            $pdf->SetX(105);
                            $ancho = 10;
                        }
                        if($i == 1){
                            $pdf->SetX(105+10);
                            $ancho = 40;
                        }
                        if($i == 2){
                            $pdf->SetX(105+10+40);
                            $ancho = 40;
                        }
                    } 
                    $pdf->Cell($ancho,5,$x[$i],1,0,'C');
                     
                    
                    
                     
                   }


                   // print_r($x[0]);
                   // print_r($x[1]);
                }
                $pdf->SetFont('Arial', 'U', 9);
                
                $pdf->Text(15, 240, 'F. ____________________________');
                $pdf->Text(15, 245, 'NOMBRE: '.$data->nombreUsuario);
                $pdf->Text(15, 250, 'CARGO: '.$data->cargoUsuario.' ONI: '.$data->oniUsuario);
                $pdf->Text(15, 255, 'ENCARGADO DE SECCION DE ESQUELAS');
                $pdf->Text(15, 260, 'DEPARTAMENTO DE CONTROL VEHICULAR');
                $pdf->Text(15, 265, 'ENTREGA CONFORME.');

                $pdf->SetFont('Arial', 'U', 9);
                
                $pdf->Text(112, 240, 'F. ____________________________');
                $pdf->Text(112, 245, 'NOMBRE: '.$data->nombreAutorizado);
                $pdf->Text(112, 250, 'CARGO: '.$data->cargoAutorizado.' ONI: '.$data->oniAutorizado);
                $pdf->Text(112, 255, $data->cargoAutorizado);
                $pdf->Text(112, 260, $data->depuesto);
                $pdf->Text(112, 265, 'RECIBE CONFORME.');
                //print_r($data->nombreAutorizado);
                    $pdfString = $pdf->Output("Pdf_AsignacionTalonarios"."_".date('d/m/Y').".pdf", "S");
                    $pdfBase64 = base64_encode($pdfString);
                    echo 'data:application/pdf;base64,' . $pdfBase64;  
            }
            
        
    }

    public function comprobar($id)
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
        $oni = strtoupper($id);
        $result = $this->TransitoModel->comprobarAutorizacionTalonario($oni, 'TTO_CE_ONIAUT');
        echo json_encode($result);
        }
    }

    public function validarAsignacion($cantidadAsig, $serieInicial){
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){

        $serieFinal = $serieInicial + ($cantidadAsig * 25);
        $result = $this->TransitoModel->validarAsignacion($serieFinal,  $serieInicial);
        echo json_encode($result);
        }
    }

    public function getTalonariosByOni($oni){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2))){
            $userRol =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $rol = false;
            if($userRol == "validacion1"){
                $rol = true;
            }
            $data = $this->TransitoModel->getTalonariosByOni(strtoupper($oni), $rol);
            $arr = array('data' => $data);
            echo json_encode($arr);

        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function reasignar() {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2))){
    
            $status = false;
            $id = xss_clean($this->input->post('idTalonario'));
            $oni = xss_clean($this->input->post('oni_asignado'));
            $observaciones = xss_clean($this->input->post('observaciones'));

            $this->form_validation->set_rules('oni_asignado', 'oni_asignado', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('observaciones', 'observaciones', 'trim|max_length[80]');
            $id_ubicacion = $this->Personal_model->datosPersona($oni);
            if ($this->form_validation->run() == true) {

                $fecha = $this->convertDateOracle(date('d/M/y'));
                $hora = date('H:i:s');
                $data = array(
                    'ESTADO' => "REASIGNADO",
                    'FECHA_REASIGNACION' => $fecha,
                    'HORA_REASIGNACION' => $hora,
                    'ONI_RESPONSABLE' => $oni,
                    'OBSERVACION_E' => $observaciones,
                    'ID_UBICACION' => $id_ubicacion->INUNIORG
                );

                $valido = $this->TransitoModel->validarReasignacion($oni);

                if($valido[0]->NUM > 2){
                    $status = false;

                    echo json_encode(array("status" => $status, 'data' => ''));
                }else{
                    $existencia = $this->TransitoModel->getById($this->tableName, $id, $this->primaryKey);
                    $this->TransitoModel->reasignar($this->tableName,$data,$id);
                            foreach  ($data as $clave => $valor) {
                                if($data[$clave]!=$existencia->$clave){
                                    $this->auditoria($existencia->ID_FILA,'REASIGNACION',$clave,$existencia->$clave,$data[$clave]);
                                }                        
                            } 
                        $status = true;

                        echo json_encode(array("status" => $status , 'data' => $data));
                

                    }

            }else {
                
                echo json_encode(array("status" => 401, 'data' => 'INVALID_DATA'));
            }


        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function revertirReasignacion($id){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2))){

            $status = false;
            $data = array(
                'ESTADO' => "ASIGNADO",
                'FECHA_REASIGNACION' => "",
                'HORA_REASIGNACION' => "",
                'ONI_RESPONSABLE' => "",
                'OBSERVACION_E' => "",
                'ID_UBICACION' => ""
            );

            $existencia = $this->TransitoModel->getById($this->tableName, $id, $this->primaryKey);
            $this->TransitoModel->reasignar($this->tableName,$data,$id);
            foreach  ($data as $clave => $valor) {
                if($data[$clave]!=$existencia->$clave){
                    $this->auditoria($existencia->ID_FILA,'REVERTIR REASIGNACION',$clave,$existencia->$clave,$data[$clave]);
                }                        
            } 
            $status = true;

                echo json_encode(array("status" => $status , 'data' => $data));

        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function descargoTalonario(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2))){

            $observaciones = xss_clean($this->input->post('observacionesDesc'));
            $id = xss_clean($this->input->post('idTalonarioDesc'));

            $this->form_validation->set_rules('observacionesDesc', 'observacionesDesc', 'trim|max_length[80]');
            $this->form_validation->set_rules('idTalonarioDesc', 'idTalonarioDesc', 'trim|max_length[10]');
            if ($this->form_validation->run() == true) {
                $fechaDescargo = $this->convertDateOracle(date('d/M/y'));

                $data = array(
                    "ESTADO" => "DESCARGADO",
                    "OBSERVACION_D" => $observaciones,
                    "FECHA_DESCARGO" => $fechaDescargo
                );

                $existencia = $this->TransitoModel->getById($this->tableName, $id, $this->primaryKey);
                $this->TransitoModel->reasignar($this->tableName,$data,$id);
                foreach  ($data as $clave => $valor) {
                    if($data[$clave]!=$existencia->$clave){
                        $this->auditoria($existencia->ID_FILA,'DESCARGO_TALONARIO',$clave,$existencia->$clave,$data[$clave]);
                    }                        
            } 
            $status = true;

                echo json_encode(array("status" => $status , 'data' => $data));

            }else {
            
                echo json_encode(array("status" => 401, 'data' => 'INVALID_DATA'));
            }
            
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

}
