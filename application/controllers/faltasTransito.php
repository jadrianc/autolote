<?php
defined('BASEPATH') or exit('No direct script access allowed');
class faltasTransito extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {
            redirect('login');
        }
        $this->CI =& get_instance();
        $this->username = $this->session->userdata['username'];
        $this->load->helper('url_helper');
        $this->load->model('TransitoModel');
        $this->load->model('Auditoria_model');
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numerico.');
        $this->form_validation->set_message('max_length', '%s: el maximo de caracteres es %s');
        $this->load->library('authorization_token');
        $this->load->library('timejwt_library');
        $this->load->library('audit_library');
        $this->load->library('validateuser_library');
        $this->tableName = 'TTO_CE_FALTAS';        
        $this->primaryKey = 'ID_FILA';
    }

    public function index()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1))) {
            
            $sessionTimeout = $this->timejwt_library->differenceTime(
            $this->CI->config->item('jwt_expire_time'),
            $is_valid_token['data']->time);

            $user = $this->session->userdata('username');
            $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
        
            $data['title'] = 'Catalogo Faltas de transito'; 
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['ID_ROL'] = $userInfo->ID_ROL;
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('catalogoTransito/faltas', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function getAll()
    {
       $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $data = $this->TransitoModel->getAll($this->tableName);
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
            $data = $this->TransitoModel->getById($this->tableName, $id, 'ID_FILA');
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
                //$id_marca = xss_clean($this->input->post('id_marca'));
                $num_falta = xss_clean(strtoupper($this->input->post('numero_falta'))); 
                $rubro = xss_clean(strtoupper($this->input->post('rubro'))); 
                $descripcion = xss_clean(strtoupper($this->input->post('descripcion'))); 
                $valor = xss_clean(strtoupper($this->input->post('valor'))); 
                $clasificacion = xss_clean(strtoupper($this->input->post('clasificacion'))); 
                   
                $newRecord = array(
                    'NUM_FALTA' => $num_falta,
                    'RUBRO' => $rubro,
                    'DESCRIPCION' => $descripcion,
                    'VALOR' => $valor,
                    'CLASIFICACION' => $clasificacion

                );    
               
                $this->form_validation->set_rules('numero_falta', 'numero_falta', 'trim|required|max_length[60]');   

                $reg = $this->TransitoModel->getId($this->tableName,'NUM_FALTA',$num_falta);
                if($reg==''){ 
                    if ($this->form_validation->run() == true) {
                        $id = $this->TransitoModel->create($this->tableName,$newRecord);
                        $nuevoRegistro = $this->TransitoModel->getId($this->tableName,'NUM_FALTA',$num_falta);
                        $status = true;
                        $this->Auditoria_model->create(
                            $this->audit_library->auditArray(
                                $this->tableName,
                                $nuevoRegistro->ID_FILA,
                                'CREAR',
                                $this->username,
                                'TODOS',
                                'NO APLICA',
                                'NO APLICA',
                                $this->input->ip_address()
                            )
                        );
                    } else {
                        //$data['ID_FILA'] = $id_marca;
                       // $data['NOM_MARCA'] = $marca;
                    }
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

                $id_falta = xss_clean($this->input->post('id_falta'));
                $num_falta = xss_clean(strtoupper($this->input->post('numero_falta'))); 
                $rubro = xss_clean(strtoupper($this->input->post('rubro'))); 
                $descripcion = xss_clean(strtoupper($this->input->post('descripcion'))); 
                $valor = xss_clean(strtoupper($this->input->post('valor'))); 
                $clasificacion = xss_clean(strtoupper($this->input->post('clasificacion'))); 

                $data = array(
                    'ID_FILA' => $id_falta,
                    'NUM_FALTA' => $num_falta,
                    'RUBRO' => $rubro,
                    'DESCRIPCION' => $descripcion,
                    'VALOR' => $valor,
                    'CLASIFICACION' => $clasificacion);
                
                $this->form_validation->set_rules('numero_falta', 'numero_falta', 'trim|required|max_length[60]');
            
                
                        $existencia = $this->TransitoModel->getById($this->tableName, $id_falta, $this->primaryKey);
                        $this->TransitoModel->update($this->tableName,$data,'ID_FILA');
                        foreach  ($data as $clave => $valor) {
                            if($data[$clave]!=$existencia->$clave){
                                $this->auditoria($existencia->ID_FILA,'ACTUALIZAR',$clave,$existencia->$clave,$data[$clave]);
                            }                        
                        } 
                        $status = true;
                    
                
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
        #$existencia = $this->Armas_model->getExistencias($this->tableName,$id,'ID_FILA');
            #if($existencia->CANT == '0'){
                $data = $this->TransitoModel->getById($this->tableName,$id,'ID_FILA');
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
                    $this->TransitoModel->delete($this->tableName,$id,'ID_FILA');
                    echo json_encode(array("status" => true));
                } else {
                    echo json_encode(array("status" => false));
                }/*
            }
            else{
                echo json_encode(array("status" => false));
            }*/
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getSelect2()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){
            $searchTerm = strtoupper($this->input->post('searchTerm'));
            $clase = $this->input->post('clase');
            $response = $this->Armas_model->getSelect2($searchTerm, $clase);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getSelectAll()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1))){
            $searchTerm = strtoupper($this->input->post('searchTerm'));
            $response = $this->Armas_model->getSelectAll($searchTerm,  $this->primaryKey, 'NOM_MARCA', $this->tableName);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    private function auditoria($id,$operacion,$campo,$vAntiguo,$vNuevo){
        $this->Auditoria_model->create(
            $this->audit_library->auditArray(
                $this->tableName,
                $id,
                $operacion,
                $this->username,
                $campo,
                $vAntiguo,
                $vNuevo,
                $this->input->ip_address()
            )
        );
    }
}    
?>