<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (isset($_SESSION['usuario']) && $_SESSION['environment'] == ENVIRONMENT) {

            redirect('inicio');
        }
        $this->CI =& get_instance();
        $this->load->library('session');
        $this->load->model('Usuarios_model');
        $this->load->model('LoginUserLog_model');
        $this->load->helper('url_helper');
        $this->load->helper('date');
        $this->load->helper('hashedPassword_helper');
        $this->load->helper('getIP_helper');
        $this->load->library('form_validation');
        $this->load->library('authorization_token');
        $this->load->library('validateuser_library');
        $this->load->library('audit_library');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numerico.');
        $this->form_validation->set_message('max_length', '%s excede el numero de caracteres permitidos.');
    }

    public function index()
    {
        $data = array(
            'reseteo' => FALSE
        );
        $this->load->view('login', $data);
    }

    public function loginUser()
    {
        $usuario = xss_clean(strtoupper($this->input->post('username', true)));
        $password = xss_clean($this->input->post('password', true));

        $this->form_validation->set_rules('username', 'UserName', 'trim|required|max_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[90]');
        
        if ($this->form_validation->run() === TRUE) {

            if ($user = $this->Usuarios_model->getByUserName($usuario)) {
                if ($password == $user->pass) {

                        $data = array(
                            "user" => $usuario

                        );
                   
                        $this->session->set_userdata($usuario);
                        $this->session->userdata('username'); 
                        $_SESSION['usuario'] = $usuario;
                        $_SESSION['environment'] = ENVIRONMENT;
                        $this->session->set_flashdata('welcomeSesion', 'Bienvenido '.$user->nombre); 
                        redirect('inicio/');
                    
                 

                } else {
                    $data = array(
                        'error_message' => validation_errors(),
                        'reseteo' => FALSE
                    );
                    $this->load->view('login', $data);
                }
            }    
        }

    }
    
}


?>

