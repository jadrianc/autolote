<?php
defined('BASEPATH') or exit('No direct script access allowed');
class AutTalonarios extends CI_Controller
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
        $this->tableName = 'TTO_CE_ONIAUT';
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
        
            $data['title'] = 'Autorizacion de Talonarios'; 
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['ID_ROL'] = $userInfo->ID_ROL;
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('autTalonarios/index', $data);
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
            $data = $this->TransitoModel->getAllJoin($this->tableName, 'TTO_C_UNIDADES', 'ID_UNIDAD', 'ID_FILA', 'NOMBRE');
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
            $data = $this->TransitoModel->getRowById($this->tableName, 'TTO_C_UNIDADES', 'ID_UNIDAD', 'ID_FILA', 'NOMBRE', $id);
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
                //$id_marca = xss_clean($this->input->post('id_clase'));
                $oni = xss_clean(strtoupper($this->input->post('oni_asignado'))); 
                $id_unidad = xss_clean(strtoupper($this->input->post('id_unidad')));
                $cantidad = xss_clean(strtoupper($this->input->post('cantidad')));
                $fecha_autorizacion = xss_clean(strtoupper($this->input->post('fechatraslado')));
                $estado = xss_clean(strtoupper($this->input->post('estado'))); 
                $numDocumento = xss_clean(strtoupper($this->input->post('NumDocumento')));
                $referencia = xss_clean(strtoupper($this->input->post('referencia'))); 
                $observaciones = xss_clean(strtoupper($this->input->post('observaciones'))); 
               // $mi_archivo = xss_clean($this->input->post('file'));

                $newRecord = array(
                    'ONI' => $oni,
                    'ID_UNIDAD' => $id_unidad,
                    'CANTIDAD' => $cantidad,
                    'FECHA_AUT' => $this->convertDateOracle($fecha_autorizacion),
                    'ESTADO' => $estado,
                    'NO_DOCUMENTO' => $numDocumento,
                    'NO_REFERENCIA' => $referencia,
                    'OBSERVACION' => $observaciones
                );    
               
                $this->form_validation->set_rules('oni_asignado', 'oni_asignado', 'trim|required|max_length[10]');   
                
                
                
             
                    if ($this->form_validation->run() == true) {
                        $id = $this->TransitoModel->create($this->tableName,$newRecord);
                        $nuevoRegistro = $this->TransitoModel->getId($this->tableName,'ONI',$oni);
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
                        //$data['DESCRIPCION'] = $marca;
                    }

                    $id = $this->TransitoModel->getNumAutorizacion();
                    //print_r($id[0]->NUM_AUT);
                    $carpeta = 'documentos/autorizacion_talonarios';
                    $str = $_FILES['file']['name'];
                    $explode = explode(".", $str);
                    $extencion = array_pop($explode);    
                    $nombreDoc = $carpeta.'/'.$id[0]->NUM_AUT.'.'.$extencion;
                   
                    if (move_uploaded_file($_FILES['file']['tmp_name'],$nombreDoc )) {
                        $this->Auditoria_model->create(
                            $this->audit_library->auditArray(
                                'DOCUMENTOS',
                                $id[0]->NUM_AUT,
                                'UPLOAD_FILE',
                                $this->username,
                                'TODOS',
                                'NO APLICA',
                                'NO APLICA',
                                $this->input->ip_address()
                            )
                        );
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
                $id_clase = xss_clean($this->input->post('id_clase'));
                $oni = xss_clean(strtoupper($this->input->post('oni_asignado'))); 
                $id_unidad = xss_clean(strtoupper($this->input->post('id_unidad')));
                $cantidad = xss_clean(strtoupper($this->input->post('cantidad')));
                $fecha_autorizacion = xss_clean(strtoupper($this->input->post('fechatraslado')));
                $estado = xss_clean(strtoupper($this->input->post('estado'))); 
                $numDocumento = xss_clean(strtoupper($this->input->post('NumDocumento')));
                $referencia = xss_clean(strtoupper($this->input->post('referencia'))); 
                $observaciones = xss_clean(strtoupper($this->input->post('observaciones'))); 

                $data = array(
                    'ID_FILA' => $id_clase,
                    'ONI' => $oni,
                    'ID_UNIDAD' => $id_unidad,
                    'CANTIDAD' => $cantidad,
                    'FECHA_AUT' => $this->convertDateOracle($fecha_autorizacion),
                    'ESTADO' => $estado,
                    'NO_DOCUMENTO' => $numDocumento,
                    'NO_REFERENCIA' => $referencia,
                    'OBSERVACION' => $observaciones
                
                );  
            
               
                      
                    $existencia = $this->TransitoModel->getById($this->tableName, $id_clase, $this->primaryKey);
                    $this->TransitoModel->update($this->tableName,$data,'ID_FILA');
                    foreach  ($data as $clave => $valor) {
                        if($data[$clave]!=$existencia->$clave){
                            $this->auditoria($existencia->ID_FILA,'ACTUALIZAR',$clave,$existencia->$clave,$data[$clave]);
                        }                        
                    } 
                        $status = true;
                    if($_FILES['file']){
                        $carpeta = 'documentos';
                        $str = $_FILES['file']['name'];
                        $explode = explode(".", $str);
                        $extencion = array_pop($explode);    
                        $nombreDoc = $carpeta.'/'.$id_clase.'.'.$extencion;
                       
                        if (move_uploaded_file($_FILES['file']['tmp_name'],$nombreDoc )) {
                            $this->Auditoria_model->create(
                                $this->audit_library->auditArray(
                                    'DOCUMENTOS',
                                    $id_clase,
                                    'UPDATE_FILE',
                                    $this->username,
                                    'TODOS',
                                    'NO APLICA',
                                    'NO APLICA',
                                    $this->input->ip_address()
                                )
                            );
                        }    
                    
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

                    $file = "documentos/".$id.".pdf";
                    unlink($file);
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

    private function convertDateOracle($date)
    {
        if (empty($date)) {
            return null;
        }
        $dateReplace = $date = str_replace('/', '-', $date);
        $dateTransform = date('d-M-y', strtotime($dateReplace));
        list($day, $month, $year)=explode('-', $dateTransform);
        $monthUpper =  strtoupper($month);
        return $day.'-'.$monthUpper.'-'.$year;
    }

    public function obtenerArchivo($id){
        $directorio = 'documentos/';
        $ficheros = scandir($directorio);
        $nombres = array();
        for ($i=2; $i < count($ficheros)  ; $i++) { 
            $archivos = explode(".", $ficheros[$i]);
            $nombre = $archivos[0];
            array_push($nombres, $nombre);
        }
        $index = array_search($id,$nombres) + 2;
        $archivo = $directorio.$ficheros[$index]; 
        //echo json_encode($archivo);
        $dir = @dir($directorio);
        $file = $dir->read();
        $ruta = base_url();
        $data[] = array(
            "Nombre" => $ficheros[$index],
            "Documento" => $id
          );
          echo json_encode($data);
    }
}    
?>