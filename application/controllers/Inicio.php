<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Inicio extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$_SESSION['usuario'] || $_SESSION['environment'] != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->load->model('LoginUserLog_model');
        $this->load->library('authorization_token');
        $this->load->helper('url_helper');
        $this->load->library('timejwt_library');
        $this->load->library('validateuser_library');
        $this->load->model('Usuarios_model');
       
    }

    public function index()
    {
            

            $data['title'] = 'Inicio'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];
            
         
          

            $user = $this->session->userdata('username');
            $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
           
                $this->load->helper('url');
                $this->load->view('templates/header', $data);
                $this->load->view('home', $data);
                $this->load->view('templates/footer', $data);
            
        
    }

    public function KeepLogin()
    {
        $is_valid_token = $this->authorization_token->validateTokenPost();
        if (!empty($is_valid_token) && $this->session->userdata('username')) {
            if(!$is_valid_token['status'] === true)
            {
                $user = $this->Usuarios_model->getByUserName($this->session->userdata('username'));
                if($token = $this->buildToken($user))
                {
                    echo json_encode(array('status' => 201, 'response' => 'Session Actualizada'));
                }
            } else {
                echo json_encode(array('status' => 200, 'response' => 'Session Valida'));
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function Logout()
    {
        
        $this->session->sess_destroy();
        $_SESSION['usuario'] = null;
        $_SESSION['environment'] == null;
        redirect('login');
    }

    private function CleanSession()
    {
        $data = $this->session->all_userdata();
        $user = $this->Usuarios_model->getByUserName($this->session->userdata('username'));
        $this->LoginUserLog_model->create(array('ID_USUARIO' => $user->ID_USUARIO, 
        'FECHA_LOGOUT' => date('d-M-y'), 'HORA_LOGOUT' => date('H:i:s'), 'LAST_IP' => $this->input->ip_address()));
        foreach ($data as $row) {
            $this->session->unset_userdata($row);
            $this->session->sess_destroy();
        }
    }


    public function getTimeValid()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,6))) {
            echo json_encode($this->timejwt_library->differenceTime($this->CI->config->item('jwt_expire_time'),
            $this->session->userdata('time_login')));
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
              redirect('unauthorized/');
        }
    }

    private function buildToken($user)
    {
        $this->CleanSession();
        $tokenData['id'] = rand();
        $tokenData['user_name'] = $user->NOMBRE_USUARIO;
        $tokenData['time'] = time();
        $user_token = $this->authorization_token->generateToken($tokenData);
        $this->session->sess_expiration = $this->CI->config->item('jwt_expire_time');
        $this->session->set_userdata('username', $user->NOMBRE_USUARIO);
        $this->session->set_userdata('token', $user_token);
        return $user_token;
    }

   

}
