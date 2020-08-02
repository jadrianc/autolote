<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CentrosCostos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CentrosCostos_model');
        $this->load->model('Auditoria_model');
        $this->load->model('CTDependencias_model');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {

            redirect('login');
        }
        $this->username = $this->session->userdata['username'];
        $this->CI =& get_instance();
        $this->load->library('authorization_token');
        $this->load->library('timejwt_library');
        $this->load->library('audit_library');
        $this->load->library('validateuser_library');
        $this->tableName = 'C_CCOSTOAF';
    }

    public function index()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $sessionTimeout = $this->timejwt_library->differenceTime(
            $this->CI->config->item('jwt_expire_time'),
            $is_valid_token['data']->time);   

            $data['title'] = 'Centros de Costos'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('centrosdecosto/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function getSelect2()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2,3,4,5,6))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $response = $this->CentrosCostos_model->getSelect2($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getFilterSelect2()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2,3,4,5,6))){
             $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            
             $user = $this->session->userdata('username');
             $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
            
             if($userInfo->ID_ROL == 4 || $userInfo->ID_ROL == 5){
                $filtro = $userInfo->CCOSTO;
                $response = $this->CentrosCostos_model->getFilterSelect2($searchTerm,$filtro);
             }
             else {
                $response = $this->CentrosCostos_model->getSelect2($searchTerm);
             }
             
             echo json_encode($response);
         } else {
             $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
             echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
         }
    }

    public function getSelect2Exclude()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2,3,4,6))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $exclude = xss_clean($this->input->post('exclude'));
            $response = $this->CentrosCostos_model->getSelect2Exclude($searchTerm, $exclude);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    
    public function getSelect2CCostosDescargo()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,6))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $response = $this->CentrosCostos_model->getSelect2CCostosDescargo($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getSelect2CTDependencias()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,6))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $response = $this->CTDependencias_model->getSelect2($searchTerm);
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
            $data = $this->CentrosCostos_model->getAll();
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

    public function getById()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $id = xss_clean($this->input->post('id'));
            $data = $this->CentrosCostos_model->getById($id);
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
            $newRecord = array(
                'CCOSTO' => xss_clean($this->input->post('id_ccosto')),
                'NOM_COS' => strtoupper(xss_clean($this->input->post('ccosto'))),
                'DESCRIPC' => strtoupper(xss_clean($this->input->post('descripcion'))),
                'CODEMP' => strtoupper(xss_clean($this->input->post('oni'))),
                'TELEFONO' => strtoupper(xss_clean($this->input->post('telefono'))),
                'COMENTARIO' => xss_clean($this->input->post('comentario')),
                'IDIMPERIUM' => xss_clean($this->input->post('id_dependencia')),
                'NACUERDO' => strtoupper(xss_clean($this->input->post('nacuerdo'))),
                'FECH_ACUERDO' =>$this->convertDateOracle(xss_clean($this->input->post('fech_acuerdo'))),
                'ESTADO' => 'A'
                );

        
            $this->form_validation->set_rules('id_ccosto', 'ID Centro de Costo', 'trim|required|numeric|max_length[10]');
            $this->form_validation->set_rules('ccosto', 'Centro de Costo', 'trim|required|max_length[60]');
            $this->form_validation->set_rules('descripcion', 'Descripcion Centro de Costo', 'trim|max_length[30]');
            $this->form_validation->set_rules('oni', 'ONI del Responsable del Centro de Costo', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('telefono', 'Telefono del Centro de Costo', 'trim|max_length[150]');
            $this->form_validation->set_rules('id_dependencia', 'ID Dependencia del Centro de Costo', 'trim|required|numeric|max_length[10]');

            if ($this->form_validation->run() == true) {
                $this->CentrosCostos_model->create($newRecord);
                $status = true;

                $this->Auditoria_model->create(
                        $this->audit_library->auditArray(
                            $this->tableName,
                            $this->input->post('id_centrocosto'),
                            'CREAR',
                            $this->username,
                            'TODOS',
                            'NO APLICA',
                            'NO APLICA',
                            $this->input->ip_address()
                        )
                    );
            } else {
                $data['CCOSTO'] = xss_clean($this->input->post('id_ccosto'));
                $data['NOM_COS'] = strtoupper(xss_clean($this->input->post('ccosto')));
                $data['DESCRIPC'] = strtoupper(xss_clean($this->input->post('descripcion')));
                $data['CODEMP'] = xss_clean($this->input->post('oni'));
                $data['TELEFONO'] = strtoupper(xss_clean($this->input->post('telefono')));
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
                $id_centrocosto = $this->input->post('id_ccosto');               
                $data = array(
                    'CCOSTO' => xss_clean($this->input->post('id_ccosto')),
                    'NOM_COS' => strtoupper(xss_clean($this->input->post('ccosto'))),
                    'DESCRIPC' => strtoupper(xss_clean($this->input->post('descripcion'))),
                    'CODEMP' => strtoupper(xss_clean($this->input->post('oni'))),
                    'TELEFONO' => strtoupper(xss_clean($this->input->post('telefono'))),
                    'COMENTARIO' => xss_clean($this->input->post('comentario')),
                    'IDIMPERIUM' => xss_clean($this->input->post('id_dependencia')),
                    'NACUERDO' => strtoupper(xss_clean($this->input->post('nacuerdo'))),
                    'FECH_ACUERDO' => $this->convertDateOracle($this->input->post('fech_acuerdo')),
                    'ESTADO' => xss_clean($this->input->post('estado'))
                    );
    
            
                $this->form_validation->set_rules('id_ccosto', 'ID Centro de Costo', 'trim|required|numeric|max_length[10]');
                $this->form_validation->set_rules('ccosto', 'Centro de Costo', 'trim|required|max_length[60]');
                $this->form_validation->set_rules('descripcion', 'Descripcion Centro de Costo', 'trim|max_length[30]');
                $this->form_validation->set_rules('oni', 'ONI del Responsable del Centro de Costo', 'trim|required|max_length[20]');
                $this->form_validation->set_rules('telefono', 'Telefono del Centro de Costo', 'trim|max_length[150]');
                $this->form_validation->set_rules('id_dependencia', 'ID Dependencia del Centro de Costo', 'trim|required|numeric|max_length[10]');
    
                if ($this->form_validation->run() == true) {
                    $oldRecord = $this->CentrosCostos_model->getByIdNotJoin($id_centrocosto);
                    $diference = $this->audit_library->diffInData($oldRecord, $data);
                
                    foreach ($diference as $key => $value) {
                        if(!isset($data[$key]))
                        {
                            continue;
                        }
                        $this->Auditoria_model->create(
                            $this->audit_library->auditArray(
                                $this->tableName,
                                $id_centrocosto,
                                'ACTUALIZAR',
                                $this->username,
                                $key,
                                $value,
                                $data[$key],
                                $this->input->ip_address()
                            )
                        );
                    }
                    $this->CentrosCostos_model->update($data);
                    $status = true;
                }
            }
            echo json_encode(array("status" => $status , 'data' => $data));
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function delete()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            $id = xss_clean($this->input->post('id'));
            $data = $this->CentrosCostos_model->getById($id);
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
                $this->CentrosCostos_model->delete($id);
                echo json_encode(array("status" => true));
            } else {
                echo json_encode(array("status" => false));
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    private function convertDateOracle($date)
    {
        $dateReplace = $date = str_replace('/', '-', $date);
        $dateTransform = date('d-M-y', strtotime($dateReplace));
        list($day, $month, $year)=explode('-', $dateTransform);
        $monthUpper =  strtoupper($month);
        return $day.'-'.$monthUpper.'-'.$year;
    }
}
