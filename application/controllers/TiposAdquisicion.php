<?php
defined('BASEPATH') or exit('No direct script access allowed');
class TiposAdquisicion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->username = $this->session->userdata['username'];
        $this->load->model('TiposAdquisicion_model');
        $this->load->model('Auditoria_model');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numerico.');
        $this->load->library('authorization_token');
        $this->load->library('timejwt_library');
        $this->load->library('audit_library');
        $this->load->library('validateuser_library');
        $this->tableName = 'C_TADQUISI';
    }

    public function index()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));

       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $sessionTimeout = $this->timejwt_library->differenceTime(
            $this->CI->config->item('jwt_expire_time'),
            $is_valid_token['data']->time);  

            $data['title'] = 'Tipos de Adquisicion'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('tiposadquisicion/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function getSelect2()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2,3,4,6))){
            $searchTerm = strtoupper($this->input->post('searchTerm'));
            $response = $this->TiposAdquisicion_model->getSelect2($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getAll()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $data = $this->TiposAdquisicion_model->getAll();
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
            $data = $this->TiposAdquisicion_model->getById($id);
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
                $id_tipo_adquisicion = xss_clean($this->input->post('id_tipo_adquisicion'));
                $tipo_adquisicion = xss_clean(strtoupper($this->input->post('tipo_adquisicion')));
        
                $newRecord = array('TADQUISI' => $id_tipo_adquisicion ,'NOMADQUISI' => $tipo_adquisicion);
        
                $this->form_validation->set_rules('id_tipo_adquisicion', 'Codigo Adquisicion', 'trim|required|numeric|max_length[5]');
                $this->form_validation->set_rules('tipo_adquisicion', 'Tipo de Adquisicion', 'trim|required|max_length[60]');
        
                if ($this->form_validation->run() == true) {
                    $id = $this->TiposAdquisicion_model->create($newRecord);
                    $status = true;
                    $newRecord = $this->TiposAdquisicion_model->getById($id);
                
                    $this->Auditoria_model->create(
                        $this->audit_library->auditArray(
                            $this->tableName,
                            $id_tipo_adquisicion,
                            'CREAR',
                            $this->username,
                            'TODOS',
                            'NO APLICA',
                            'NO APLICA',
                            $this->input->ip_address()
                        )
                    );
                
                } else {
                    $data['TADQUISI'] = $id_tipo_adquisicion;
                    $data['NOMADQUISI'] = $tipo_adquisicion;
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
                $id_tipo_adquisicion = xss_clean($this->input->post('id_tipo_adquisicion'));
                $tipo_adquisicion = xss_clean(strtoupper($this->input->post('tipo_adquisicion')));
        
                $data = array('TADQUISI' => $id_tipo_adquisicion ,'NOMADQUISI' => $tipo_adquisicion);
        
                $this->form_validation->set_rules('id_tipo_adquisicion', 'Codigo Adquisicion', 'trim|required|numeric|max_length[5]');
                $this->form_validation->set_rules('tipo_adquisicion', 'Tipo de Adquisicion', 'trim|required|max_length[60]');
        
                if ($this->form_validation->run() == true) {
                    $oldRecord = $this->TiposAdquisicion_model->getById($id_tipo_adquisicion);
                    $diference = $this->audit_library->diffInData($oldRecord, $data);

                    foreach ($diference as $key => $value) {
                        if(!isset($data[$key]))
                        {
                            continue;
                        }
                        $this->Auditoria_model->create(
                            $this->audit_library->auditArray(
                                $this->tableName,
                                $id_tipo_adquisicion,
                                'ACTUALIZAR',
                                $this->username,
                                $key,
                                $value,
                                $data[$key],
                                $this->input->ip_address()
                            )
                        );
                    }

                    $this->TiposAdquisicion_model->update($data);
                    $status = true;

                } else {
                    $data['TADQUISI'] = $id_tipo_adquisicion;
                    $data['NOMADQUISI'] = $tipo_adquisicion;
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
            $data = $this->TiposAdquisicion_model->getById($id);
            if ($data) {
                $this->Auditoria_model->create(
                    $this->audit_library->auditArray(
                        $this->tableName,
                        $id,
                        'BORRAR',
                        $this->username,
                        "TODOS",
                        "NO APLICA",
                        "NO APLICA",
                        $this->input->ip_address()
                    )
                );
                $this->TiposAdquisicion_model->delete($id);
                echo json_encode(array("status" => true));
            } else {
                echo json_encode(array("status" => false));
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }
}
