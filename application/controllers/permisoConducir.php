<?php
defined('BASEPATH') or exit('No direct script access allowed');
class permisoConducir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {

            redirect('login');
        }
        $this->username = $this->session->userdata['username'];
        $this->CI =& get_instance();
        $this->load->model('Auditoria_model');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numerico.');
        $this->load->library('authorization_token');
        $this->load->library('validateuser_library');
        $this->load->library('timejwt_library');
        $this->load->library('audit_library');
        $this->tableName = '';
    }

    public function index()
    {        
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $sessionTimeout = $this->timejwt_library->differenceTime(
            $this->CI->config->item('jwt_expire_time'),
            $is_valid_token['data']->time);  

            $data['title'] = ''.ucfirst('Pemiso para Conducir Vehiculos Policiales'); // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('permisoConducir/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function store (){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $imagenCodificada = file_get_contents("php://input"); //Obtener la imagen
                if(strlen($imagenCodificada) <= 0) exit("No se recibió ninguna imagen");
                //La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
                $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenCodificada));
                
                //Venía en base64 pero sólo la codificamos así para que viajara por la red, ahora la decodificamos y
                //todo el contenido lo guardamos en un archivo
                $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
                
                //Calcular un nombre único
                $nombreImagenGuardada = "documentos/foto_" . uniqid() . ".png";
                
                //Escribir el archivo
                file_put_contents($nombreImagenGuardada, $imagenDecodificada);
                
                //Terminar y regresar el nombre de la foto
                exit($nombreImagenGuardada);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }    
    }

    
}