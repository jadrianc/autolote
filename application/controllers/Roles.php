<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Roles extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$_SESSION['usuario'] || $_SESSION['environment'] != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->username = $_SESSION['usuario'];
        $this->load->model('Roles_model');
        $this->load->helper('url_helper');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numerico.');
        $this->tableName = 'TTO_T_ROLES';
    }

    public function index()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));

       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            
            $sessionTimeout = $this->timejwt_library->differenceTime(
            $this->CI->config->item('jwt_expire_time'),
            $is_valid_token['data']->time); 

            $data['title'] = 'Roles de Usuario'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('roles/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function getSelect2()
    {
        
            $searchTerm = strtoupper($this->input->post('searchTerm'));
            $response = $this->Roles_model->getSelect2($searchTerm);
            echo json_encode($response);
       
    }

    public function getAll()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $data = $this->Roles_model->getAll();
            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $arr = array('data' => $data);
            }
            echo json_encode($arr);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getById($id)
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $data = $this->Roles_model->getById($id);
            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $arr = array('success' => true, 'data' => $data);
            }
            echo json_encode($arr);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function store()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $status = false;
            if ($this->input->post()) {
                $nombre = xss_clean(strtoupper($this->input->post('nombre')));
                $descripcion = xss_clean(strtoupper($this->input->post('descripcion')));
        
                $newRecord = array('NOMBRE_ROL' => $nombre ,'DESCRIPCION' => $descripcion, 'CREATE_AT' => $this->username);
        
                $this->form_validation->set_rules('nombre', 'Nombre Rol', 'trim|required|max_length[20]');
                $this->form_validation->set_rules('descripcion', 'Descripcion', 'trim|max_length[40]');
        
                if ($this->form_validation->run() == true) {
                    if (!$this->Roles_model->getByRolName($newRecord['NOMBRE_ROL'])) {
                        $this->Roles_model->create($newRecord);
                        $status = true;
                        $newRecord = $this->Roles_model->getByRolName($newRecord['NOMBRE_ROL']);

                        
                    } else {
                        $status = 'duplicate';
                    }
                } else {
                    $newRecord['NOMBRE_ROL'] = $nombre;
                    $newRecord['DESCRIPCION'] = $descripcion;
                }
            }
            echo json_encode(array("status" => $status , 'data' => $newRecord));
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function update()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $status = false;
            if ($this->input->post()) {
                $id_rol = xss_clean($this->input->post('id_rol'));
                $nombre = xss_clean(strtoupper($this->input->post('nombre')));
                $descripcion = xss_clean(strtoupper($this->input->post('descripcion')));
        
                $data = array('ID_ROL' => $id_rol,
                'NOMBRE_ROL' => $nombre ,'DESCRIPCION' => $descripcion, 
                'UPDATE_AT' => $this->username,
                'UPDATE_TIME' => date('d-M-y h:i:s A'),
                'UPDATE_AT' => $this->username);
        
                $this->form_validation->set_rules('nombre', 'Nombre Rol', 'trim|required|max_length[20]');
                $this->form_validation->set_rules('descripcion', 'Descripcion', 'trim|max_length[40]');
        
                if ($this->form_validation->run() == true) {
                    $validate = $this->Roles_model->getById($id_rol);
                    if ($validate) {
                       
                        $oldRecord = $validate;
                        unset($oldRecord->CREATE_AT);
                        unset($oldRecord->CREATE_TIME);
                        $diference = $this->audit_library->diffInData($oldRecord, $data);
                       
                        $existencia =$this->Roles_model->getById($id_rol);
                        $this->Roles_model->update($data);
                        foreach  ($data as $clave => $valor) {
                            if($data[$clave]!=$existencia->$clave){
                                $this->auditoria($existencia->ID_ROL,'ACTUALIZAR',$clave,$existencia->$clave,$data[$clave]);
                            }                        
                        } 

                        
                        $status = true;

                    } else {
                        $status = 'not-found';
                    }
                } else {
                    $data['NOMBRE_ROL'] = $nombre;
                    $data['DESCRIPCION'] = $descripcion;
                }
            }
            echo json_encode(array("status" => $status , 'data' => $data));
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function delete($id)
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $data = $this->Roles_model->getById($id);
            if ($data) {
                
                $this->Roles_model->delete($id);
                echo json_encode(array("status" => true));
            } else {
                echo json_encode(array("status" => false));
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    private function auditoria($id,$operacion,$campo,$vAntiguo,$vNuevo){
        
    }
}
