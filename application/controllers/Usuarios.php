<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends CI_Controller
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
             
            $data['title'] = 'Usuarios'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];

            $this->load->view('templates/header', $data);
            $this->load->view('usuarios/index', $data);
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
        
            $data = $this->Usuarios_model->getAll();
            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $arr = array('data' => $data);
            }
            echo json_encode($arr);
        
    }

    public function getById($id)
    {
        
            $data = $this->Usuarios_model->getById($id);
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
                $pass =  xss_clean($this->input->post('pass'));
                $codper = xss_clean($this->input->post('codigoUsuario'));
                $id_rol = xss_clean($this->input->post('id_rol'));
              

                $newRecord = array(
                    'nombre' => $nombre ,
                    'pass' => $pass,
                    'codigo' => $codper, 
                    'id_rol' => $id_rol, 
                    );
            
                $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('pass', 'Password', 'trim|required|max_length[200]');
                $this->form_validation->set_rules('codigoUsuario', 'codigo', 'required|max_length[10]');
                $this->form_validation->set_rules('id_rol', 'Rol de Usuario', 'trim|required|max_length[10]');
                
            
                if ($this->form_validation->run() == true) {
                    if (!$this->Usuarios_model->getByUserName($newRecord['nombre'])) {
                        $this->Usuarios_model->create($newRecord);
                        $status = true;
                    } else {
                        $status = 'duplicate';
                    }
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
                $id_usuario = xss_clean($this->input->post('id_usuario'));
                $nombre = xss_clean($this->input->post('nombre'));
                $id_rol = xss_clean($this->input->post('id_rol'));
                $codigo = xss_clean($this->input->post('codigoUsuario'));
                $pass = xss_clean($this->input->post('pass'));
                
                $data = array(
                    'id_usuario' => $id_usuario, 
                    'nombre' => $nombre, 
                    'id_rol' => $id_rol,
                    'codigo' => $codigo, 
                    'pass' => $pass
                    
                );
                
                $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('pass', 'Password', 'trim|required|max_length[200]');
                $this->form_validation->set_rules('codigoUsuario', 'codigo', 'required|max_length[10]');
                $this->form_validation->set_rules('id_rol', 'Rol de Usuario', 'trim|required|max_length[10]');

                if ($this->form_validation->run() == true) {
                        
                    $this->Usuarios_model->update($data);
                    $status = true;
                        
                }
                              
            }
            echo json_encode(array("status" => $status , 'data' => $data));
        
    }




    public function delete($id)
    {
            $data = $this->Usuarios_model->getById($id);
            if ($data) {
                $this->Usuarios_model->delete($id);
                echo json_encode(array("status" => true));
            } else {
                echo json_encode(array("status" => false));
            }
        
    }

}
