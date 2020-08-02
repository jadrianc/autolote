<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Inspecciones extends CI_Controller
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
        $this->load->model('InspeccionesModel');
        $this->load->model('Auditoria_model');
        $this->load->model('Personal_model');
        $this->load->model('Usuarios_model');
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
        $this->tableName = 'TTO_TA_ACCIDENTES';
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
            $data['oni'] = $this->validateuser_library->ONIByUser($is_valid_token['data']->user_name);
            $data['codeUnidad'] = $this->validateuser_library->returnPrefijoAcc($is_valid_token['data']->user_name);
            $data['title'] = 'Inspecciones'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['ID_ROL'] = $userInfo->ID_ROL;
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('inspecciones/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function storeVehiculo(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2))) {
        
            $status = false;
            $num_placa = xss_clean($this->input->post('num_placa'));
            $marca = xss_clean($this->input->post('marca'));
            $modelo = xss_clean($this->input->post('modelo'));
            $año = xss_clean($this->input->post('año'));
            $poliza = xss_clean($this->input->post('poliza'));
            $color = xss_clean($this->input->post('color'));//
            $claseVeh = xss_clean($this->input->post('claseVeh'));
            $estado = xss_clean($this->input->post('estado'));//
            $rumbo = xss_clean($this->input->post('rumbo'));
            $email = xss_clean($this->input->post('email'));
            $seguroAuto = xss_clean($this->input->post('seguroAuto'));
            $aseguradoraAuto = xss_clean($this->input->post('aseguradoraAuto'));
            $propietarioAuto = xss_clean($this->input->post('propietarioAuto'));
            $telefono = xss_clean($this->input->post('telefono'));
            $direccion = xss_clean($this->input->post('direccion'));
            $daños = xss_clean($this->input->post('daños'));
            $idConductor = xss_clean($this->input->post('idConductor'));
            $lic = xss_clean($this->input->post('lic'));
            $licencia = xss_clean($this->input->post('licencia'));
            $nombreConductor = xss_clean($this->input->post('nombreConductor'));//
            $direccionConductor = xss_clean($this->input->post('direccionConductor'));
            $telefonoConductor = xss_clean($this->input->post('telefonoConductor'));//
            $edadConductor = xss_clean($this->input->post('edadConductor'));
            $dui = xss_clean($this->input->post('dui'));
            $nit = xss_clean($this->input->post('nit'));
            $pasaporte = xss_clean($this->input->post('pasaporte'));
            $otroDoc = xss_clean($this->input->post('otroDoc'));
            $correoConductor = xss_clean($this->input->post('correoConductor'));
            $cinturon = xss_clean($this->input->post('cinturon'));
            $version = xss_clean($this->input->post('version'));
            $resultado = xss_clean($this->input->post('resultado'));
            $estadoConductor = xss_clean($this->input->post('estadoConductor'));//
            $saludConductor = xss_clean($this->input->post('saludConductor'));
            $medioTraslado = xss_clean($this->input->post('medioTraslado'));//
            $trasladoPor = xss_clean($this->input->post('trasladoPor'));
            $numeroEquipo = xss_clean($this->input->post('numeroEquipo'));
            $causaMuerte = xss_clean($this->input->post('causaMuerte'));
            $incapacidad = xss_clean($this->input->post('incapacidad'));
            $fiscal = xss_clean($this->input->post('fiscal'));
            $forense = xss_clean($this->input->post('forense'));
            $comentarioSalud = xss_clean($this->input->post('comentarioSalud'));
            $empresa = xss_clean($this->input->post('empresa'));
            $trabaja = xss_clean($this->input->post('trabaja'));
            $direccionEmpresa = xss_clean($this->input->post('direccionEmpresa'));
            $telefonoEmpresa = xss_clean($this->input->post('telefonoEmpresa'));//
            $ruta = xss_clean($this->input->post('ruta'));
            $codigoRuta = xss_clean($this->input->post('codigoRuta'));//
            $permisoVMT = xss_clean($this->input->post('permisoVMT'));
            $permisoLinea = xss_clean($this->input->post('permisoLinea'));
            $nEquipo = xss_clean($this->input->post('nEquipo'));
            $unidadPolicial = xss_clean($this->input->post('unidadPolicial'));
            $categoria = xss_clean($this->input->post('categoria'));
            $oniPolicial = xss_clean($this->input->post('oniPolicial'));
            $numPermiso = xss_clean($this->input->post('numPermiso'));
            $tipoPermiso = xss_clean($this->input->post('tipoPermiso'));
            $unidadPermiso = xss_clean($this->input->post('unidadPermiso'));
            $detenido = xss_clean($this->input->post('detenido'));
            $delito = xss_clean($this->input->post('delito'));//
            $na = xss_clean($this->input->post('na'));
            $alcohol = xss_clean($this->input->post('alcohol'));//
            $droga = xss_clean($this->input->post('droga'));
            $medicamento = xss_clean($this->input->post('medicamento'));
            $otra = xss_clean($this->input->post('otra'));
            $procentajeAlcohol = xss_clean($this->input->post('procentajeAlcohol'));
            $acta = xss_clean($this->input->post('acta'));
            $medicamentoPrescrito = xss_clean($this->input->post('medicamentoPrescrito'));
            $esquelaImpuesta = xss_clean($this->input->post('esquelaImpuesta'));
            $vehDecomisado = xss_clean($this->input->post('vehDecomisado'));//
            $placaDecomisada = xss_clean($this->input->post('placaDecomisada'));
            $vehIncautado = xss_clean($this->input->post('vehIncautado'));
            $parqueo = xss_clean($this->input->post('parqueo'));
            $grua = xss_clean($this->input->post('grua'));
            
            //Tabla vehiculos
            //IDACC, CONDICION, CODINS, PROACT, DVEH...

            //tabla acceidente
            //tipoat
            $this->form_validation->set_rules('lic', 'lic', 'trim|required|max_length[3]');
            $this->form_validation->set_rules('num_placa', 'num_placa', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('claseVeh', 'claseVeh', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('ruta', 'ruta', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('nEquipo', 'nEquipo', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('unidadPolicial', 'unidadPolicial', 'trim|required|max_length[80]');
            $this->form_validation->set_rules('grua', 'grua', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('parqueo', 'parqueo', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('placaDecomisada', 'placaDecomisada', 'trim|required|max_length[5]');
            $this->form_validation->set_rules('num_placa', 'num_placa', 'trim|required|max_length[15]');
            $this->form_validation->set_rules('placa', 'placa', 'trim|max_length[25]');
            $this->form_validation->set_rules('marca', 'marca', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('color', 'color', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('modelo', 'modelo', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('direccionConductor', 'direccionConductor', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('poliza', 'poliza', 'trim|max_length[20]');
            $this->form_validation->set_rules('marca', 'marca', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('rumbo', 'rumbo', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('seguroAuto', 'seguroAuto', 'trim|required|max_length[2]');
            $this->form_validation->set_rules('daños', 'daños', 'trim|required|max_length[500]');
            $this->form_validation->set_rules('aseguradoraAuto', 'aseguradoraAuto', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('año', 'año', 'trim|required|max_length[500]');
            $data = array(
                
            );
            
        
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function storeAvance(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2))) {
            
            $unidad = xss_clean($this->input->post('unidad'));
            $fechaCodigo = xss_clean($this->input->post('fechaCodigo'));
            $correlativo = xss_clean($this->input->post('correlativo'));
            $oniUser = xss_clean($this->input->post('oniUser'));
            $fechaIngreso = $this->convertDateOracle(date('d/M/y'));
           
            $data = array(
                'CODINS' => "0000",
                'ONINOV' => $oniUser,
                'FECHA' => $fechaIngreso,
                'UNIDAD' => $unidad
            );
            
            $this->TransitoModel->create("TTO_TA_ACCIDENTES", $data);
            
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function buscarAvances(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2))) {
            $status = false;
            $direccion = xss_clean($this->input->post('direccion'));
            $codigo = xss_clean($this->input->post('codigo'));
            $fecha = xss_clean($this->input->post('fecha'));

            $this->form_validation->set_rules('direccion', 'direccion', 'trim|max_length[100]');
            $this->form_validation->set_rules('codigo', 'codigo', 'trim|max_length[20]');
            $this->form_validation->set_rules('fecha', 'fecha', 'trim|max_length[30]');

            if ($this->form_validation->run() == true) {

                
                if($data = $this->InspeccionesModel->buscarAvances($direccion, $codigo, $fecha)){
                    $status = true;
                    $arr = array('success' => $status, 'data' => $data); 
                }
                
                           
            
            
            }
            echo json_encode($arr);
        
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

}