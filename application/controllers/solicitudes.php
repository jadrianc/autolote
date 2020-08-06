<?php

use function Matrix\add;

defined('BASEPATH') or exit('No direct script access allowed');

class Solicitudes extends CI_Controller
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
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numérico.');
        $this->tableName = 'vehiculos';
        $this->primaryKey = 'id_vehiculo';
    }

    public function index()
    {
        
 
        
            $data['title'] = 'Vehiculos'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];

            $this->load->view('templates/header', $data);
            $this->load->view('vehiculo/index', $data);
            $this->load->view('templates/footer', $data);
        
    }

    public function store()
    {
        
            $status = false;
            if ($this->input->post()) {

                $id_vehiculo = xss_clean(strtoupper($this->input->post('id_vehiculo')));
                $nombre = xss_clean(strtoupper($this->input->post('nombre')));
                $apellido =  xss_clean($this->input->post('apellido'));
                $telefono = xss_clean($this->input->post('telefono'));
                $email = xss_clean($this->input->post('correo'));
                $comentario = xss_clean($this->input->post('comentario'));

                $newRecord = array(
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'telefono' => $telefono,
                    'correo' => $email,
                    'id_vehiculo' => $id_vehiculo,
                    'comentarios' => $comentario  
                    );
            
                $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('apellido', 'apellido', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('telefono', 'telefono', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('correo', 'correo', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('comentario', 'comentario', 'trim|required|max_length[255]');
            
                if ($this->form_validation->run() == true) {
                    
                    $this->models->create($newRecord, "solicitudes");
                    $status = true;
                   
                }else {
                    echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
                }
            }
            echo json_encode(array("status" => $status , 'data' => $newRecord));
       
    }

}