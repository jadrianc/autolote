<?php

use function Matrix\add;

defined('BASEPATH') or exit('No direct script access allowed');

class Asignaciones extends CI_Controller
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
        $this->tableName = '';
        $this->primaryKey = '';
    }

    public function index()
    {
        
            $data['title'] = 'Asignaciones'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];

            $this->load->view('templates/header', $data);
            $this->load->view('asignaciones/index', $data);
            $this->load->view('templates/footer', $data);
        
    }


    public function getAllSolicitudes(){
        
        $data = $this->models->getAllSolicitudes();
        $arr = array('success' => false, 'data' => '');
        if ($data) {
            $arr = array('data' => $data);
        }
        echo json_encode($arr);
    }

    public function store(){

        $status = false;
            if ($this->input->post()) {

                $id_solicitud = xss_clean(strtoupper($this->input->post('id_solicitud')));
                $id_vehiculo = xss_clean(strtoupper($this->input->post('id_vehiculo')));
                $id_usuario =  xss_clean($this->input->post('vendedor'));
                

                $newRecord = array(
                    'id_solicitud' => $id_solicitud,
                    'id_usuario' => $id_usuario,
                    
                    );
                $estado = array(
                    'id_solicitud' => $id_solicitud,
                    'estado' => "Asignado"
                );
            
                $this->form_validation->set_rules('id_solicitud', 'id_solicitud', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('vendedor', 'vendedor', 'trim|required|max_length[10]');
             
            
                if ($this->form_validation->run() == true) {
                    
                    $this->models->create($newRecord, "asignacion");
                    $this->models->update($estado, "solicitudes", "id_solicitud");
                    $status = true;
                   
                }else {
                    echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
                }
            }
            echo json_encode(array("status" => $status , 'data' => $newRecord));
    }

    public function getById($id)
    {
        
            $data = $this->models->getVendedor($id);
            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $arr = array('success' => true, 'data' => $data);
            }
            echo json_encode($arr);
       
    }

    public function update(){
        $status = false;
        $id_asignacion = xss_clean(strtoupper($this->input->post('id_asignacion')));
        $id_vendedor = xss_clean(strtoupper($this->input->post('vendedor')));

        $data = array(
            "id_asignacion" => $id_asignacion,
            "id_usuario" => $id_vendedor
        );

        $this->form_validation->set_rules('id_asignacion', 'id_asignacion', 'trim|required|max_length[10]');
        $this->form_validation->set_rules('vendedor', 'vendedor', 'trim|required|max_length[10]');

        if ($this->form_validation->run() == true) {
                        
            $this->models->update($data, "asignacion", "id_asignacion");
            $status = true;
                
                 
        }
    echo json_encode(array("status" => $status , 'data' => $data));
    }

}