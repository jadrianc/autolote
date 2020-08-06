<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PageClient extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$_SESSION['usuario'] || $_SESSION['environment'] != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->username = $_SESSION['usuario'];
        $this->load->model('Usuarios_model');
        $this->load->helper('url_helper');
        $this->load->helper('date');
        $this->load->helper('hashedPassword_helper');
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numérico.');
        $this->tableName = 'usuarios';
    }

    public function index()
    {
             
            $data['title'] = 'Catalogo | MA Import'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];

            
            $this->load->view('pageClient/index', $data);
            
    }

}