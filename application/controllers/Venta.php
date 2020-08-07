<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Venta extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$_SESSION['usuario'] || $_SESSION['environment'] != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->username = $_SESSION['usuario'];
        $this->load->model('models');
        $this->load->helper('url_helper');
        $this->load->helper('date');
        $this->load->helper('hashedPassword_helper');
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numérico.');
        $this->tableName = 'clientes';
        $this->primaryKey = 'id_cliente';
    }

    public function index()
    {
        
 
        
            $data['title'] = 'Realizar Ventas'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];

            $this->load->view('templates/header', $data);
            $this->load->view('venta/index', $data);
            $this->load->view('templates/footer', $data);
        
    }

}