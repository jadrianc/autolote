<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends CI_Controller
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
        
 
        
            $data['title'] = 'Clientes'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];

            $this->load->view('templates/header', $data);
            $this->load->view('clientes/index', $data);
            $this->load->view('templates/footer', $data);
        
    }

    public function getSelect2()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true){
            $searchTerm = strtoupper($this->input->post('searchTerm'));
            $response = $this->Usuarios_model->getSelect2($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getAll()
    {
            $tableName = "clientes";
            $data = $this->models->getAll($tableName);
            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $arr = array('data' => $data);
            }
            echo json_encode($arr);
        
    }

    public function getById($id)
    {
        
            $data = $this->models->getById($id, $this->tableName, $this->primaryKey);
            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $arr = array('success' => true, 'data' => $data);
            }
            echo json_encode($arr);
       
    }

    public function store()
    {
        
            $status = false;
            if ($this->input->post()) {
                $nombre = xss_clean(strtoupper($this->input->post('nombre')));
                $apellido =  xss_clean($this->input->post('apellido'));
                $dui = xss_clean($this->input->post('dui'));
                $telefono = xss_clean($this->input->post('telefono'));
                $direccion = xss_clean($this->input->post('direccion'));
                $email = xss_clean($this->input->post('correo'));

                $newRecord = array(
                    'nombres' => $nombre,
                    'apellidos' => $apellido,
                    'dui' => $dui, 
                    'telefono' => $telefono,
                    'correo' => $direccion,
                    'direccion' => $email  
                    );
            
                $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('apellido', 'apellido', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('dui', 'dui', 'required|max_length[10]');
                $this->form_validation->set_rules('telefono', 'telefono', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('direccion', 'direccion', 'required|max_length[100]');
                $this->form_validation->set_rules('correo', 'correo', 'trim|required|max_length[40]');
            
                if ($this->form_validation->run() == true) {
                    
                    $this->models->create($newRecord, "clientes");
                    $status = true;
                   
                }else {
                    echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
                }
            }
            echo json_encode(array("status" => $status , 'data' => $newRecord));
       
    }

    public function update()
    {
        
            $status = false;
            if ($this->input->post()) {
                $id_cliente = xss_clean(strtoupper($this->input->post('id_cliente')));
                $nombre = xss_clean(strtoupper($this->input->post('nombre')));
                $apellido =  xss_clean($this->input->post('apellido'));
                $dui = xss_clean($this->input->post('dui'));
                $telefono = xss_clean($this->input->post('telefono'));
                $direccion = xss_clean($this->input->post('direccion'));
                $email = xss_clean($this->input->post('correo'));

                $data = array(
                    'id_cliente' => $id_cliente,
                    'nombres' => $nombre,
                    'apellidos' => $apellido,
                    'dui' => $dui, 
                    'telefono' => $telefono,
                    'correo' => $email,
                    'direccion' => $direccion  
                );
                
                $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('apellido', 'apellido', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('dui', 'dui', 'required|max_length[10]');
                $this->form_validation->set_rules('telefono', 'telefono', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('direccion', 'direccion', 'required|max_length[100]');
                $this->form_validation->set_rules('correo', 'correo', 'trim|required|max_length[40]');

                if ($this->form_validation->run() == true) {
                        
                    $this->models->update($data, $this->tableName, $this->primaryKey);
                    $status = true;
                        
                }
                              
            }
            echo json_encode(array("status" => $status , 'data' => $data));
        
    }


    public function delete($id)
    {
            $data = $this->models->getById($id, $this->tableName, $this->primaryKey);
            if ($data) {
                $this->models->delete($id, $this->tableName, $this->primaryKey);
                echo json_encode(array("status" => true));
            } else {
                echo json_encode(array("status" => false));
            }
        
    }

}
