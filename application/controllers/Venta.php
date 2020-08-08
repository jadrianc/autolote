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
        $this->tableName = 'vehiculos';
        $this->primaryKey = 'id_vehiculo';
    }

    public function index()
    {
        
 
        
            $data['title'] = 'Realizar Ventas'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];

            $this->load->view('templates/header', $data);
            $this->load->view('venta/index', $data);
            $this->load->view('templates/footer', $data);
        
    }

    public function getAll()
    {
            $tableName = "asignacion";
            $data = $this->models->getAsignaciones($tableName);
            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $arr = array('data' => $data);
            }
            echo json_encode($arr);
        
    }

    public function update()
    {
        
            $status = false;
            if ($this->input->post()) {
                $estadoVehiculo = xss_clean(strtoupper($this->input->post('estadoVehiculo')));
                $id_vehiculo = xss_clean(strtoupper($this->input->post('id_vehiculo')));
                

                $data = array(
                    'estado' => $estadoVehiculo,
                    'id_vehiculo' => $id_vehiculo 
                );
                
                $this->form_validation->set_rules('id_vehiculo', 'id_vehiculo', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('estadoVehiculo', 'estadoVehiculo', 'trim|required|max_length[50]');
                

                if ($this->form_validation->run() == true) {
                        
                    $this->models->update($data, $this->tableName, $this->primaryKey);
                    $status = true;
                        
                }
                              
            }
            echo json_encode(array("status" => $status , 'data' => $data));
        
    }

}