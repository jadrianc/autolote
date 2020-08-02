<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Esquelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->username = $this->session->userdata['username'];
        $this->load->model('TransitoModel');
        $this->load->model('Auditoria_model');
        $this->load->model('Personal_model');
        $this->load->model('Usuarios_model');
        $this->load->helper('file');
        $this->load->helper('url_helper');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->form_validation->set_message('required', '%s es obligatorio.');
        $this->form_validation->set_message('numeric', '%s debe ser numerico.');
        $this->form_validation->set_message('max_length', '%s: el maximo de caracteres es %s');
        $this->load->library('authorization_token');
        $this->load->library('timejwt_library');
        $this->load->library('audit_library');
        $this->load->library('validateuser_library');
        $this->load->library('upload');
        $this->tableName = 'TTO_TE_ESQUELAS';
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
        
            $data['title'] = 'Esquela de Infracción'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['ID_ROL'] = $userInfo->ID_ROL;
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('esquelas/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function store() 
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $status = false;
            $impuestas = xss_clean($this->input->post('disponibilidad'));
            $serie = xss_clean($this->input->post('serie'));
            $licencia = xss_clean($this->input->post('licencia'));
            $apellidos = xss_clean($this->input->post('apellidos'));
            $documento = xss_clean($this->input->post('documento'));//
            $nombre = xss_clean($this->input->post('nombre'));
            $departamento = xss_clean($this->input->post('departamento'));//
            $num_placa = xss_clean($this->input->post('num_placa'));
            $placa = xss_clean($this->input->post('placa'));
            $manual = xss_clean($this->input->post('manual'));
            $licmanual = xss_clean($this->input->post('licmanual'));
            $id_placa = xss_clean($this->input->post('id_placa'));
            $clase = xss_clean($this->input->post('clase'));
            //$claseN = xss_clean($this->input->post('claseN'));
            $marca = xss_clean($this->input->post('marca'));
            $modelo = xss_clean($this->input->post('modelo'));
            $color = xss_clean($this->input->post('color'));
            $ruta = xss_clean($this->input->post('ruta'));
            $fechaadqui = xss_clean($this->input->post('fechaadqui'));
            $hora_falta = xss_clean($this->input->post('hora_falta'));
            $codigo_falta = xss_clean($this->input->post('falta'));
            $lugar_falta = xss_clean($this->input->post('lugar_falta'));
            $observaciones_falta = xss_clean($this->input->post('observaciones_falta'));
            $observaciones_aut = xss_clean($this->input->post('observaciones_aut'));
            $oni_asignado = xss_clean($this->input->post('oni_asignado'));
            $dependencia = xss_clean($this->input->post('dependencia'));
            $plan = xss_clean($this->input->post('plan'));
            $observaciones = xss_clean($this->input->post('observaciones'));
            $vehiculo = xss_clean($this->input->post('vehiculo'));
            $tarjeta = xss_clean($this->input->post('tarjeta'));
            $licencia_cond = xss_clean($this->input->post('licencia_cond'));
            $placas1 = xss_clean($this->input->post('placas1'));
            $placas2 = xss_clean($this->input->post('placas2'));
            $poliza = xss_clean($this->input->post('poliza'));
            $permiso_linea = xss_clean($this->input->post('permiso_linea'));

            $this->form_validation->set_rules('observaciones_aut', 'observaciones_aut', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('departamento', 'departamento', 'trim|required|max_length[2]');
            $this->form_validation->set_rules('disponibilidad', 'disponibilidad', 'trim|max_length[2]');
            $this->form_validation->set_rules('serie', 'serie', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('licencia', 'licencia', 'trim|required|max_length[17]');
            $this->form_validation->set_rules('apellidos', 'apellidos', 'trim|required|max_length[80]');
            $this->form_validation->set_rules('documento', 'documento', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('nombre', 'nombre', 'trim|required|max_length[80]');
            $this->form_validation->set_rules('departamento', 'departamento', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('num_placa', 'num_placa', 'trim|required|max_length[15]');
            $this->form_validation->set_rules('placa', 'placa', 'trim|max_length[25]');
            $this->form_validation->set_rules('clase', 'clase', 'trim|max_length[30]');
            $this->form_validation->set_rules('marca', 'marca', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('modelo', 'modelo', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('color', 'color', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('ruta', 'ruta', 'trim|max_length[10]');
            $this->form_validation->set_rules('fechaadqui', 'fechaadqui', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('hora_falta', 'hora_falta', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('falta', 'falta', 'trim|required|max_length[8]');
            $this->form_validation->set_rules('lugar_falta', 'lugar_falta', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('observaciones_falta', 'observaciones_falta', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('oni_asignado', 'oni_asignado', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('plan', 'plan', 'trim|required|max_length[6]');
            $this->form_validation->set_rules('vehiculo', 'vehiculo', 'trim|max_length[2]');
            $this->form_validation->set_rules('tarjeta', 'tarjeta', 'trim|max_length[2]');
            $this->form_validation->set_rules('licencia_cond', 'licencia_cond', 'trim|max_length[2]');
            $this->form_validation->set_rules('placas1', 'placas1', 'trim|max_length[2]');
            $this->form_validation->set_rules('placas2', 'placas2', 'trim|max_length[2]');
            $this->form_validation->set_rules('poliza', 'poliza', 'trim|max_length[2]');
            $this->form_validation->set_rules('permiso_linea', 'permiso_linea', 'trim|max_length[2]');

            $unidadTransito = $this->Personal_model->datosPersona($oni_asignado);
           // $unidad = $this->Usuarios_model->getDataByOni($oni_asignado);
           
                $placa_id = $this->TransitoModel->getId("TTO_CE_TIPOPLACAS", "ID_FILA", $placa);
               // print_r($placa_id);
                $placa = $placa_id->DESCRIPCION;
                $clase_veh = $this->TransitoModel->getId("TTO_CE_CLASEVEH", "ID_FILA", $clase);
                $clase = $clase_veh->DESCRIPCION;

                if($manual == "manual"){
                    $hit_placa = 1;
                
                }else{
                    $hit_placa = 0;
                
                }

                if($licmanual == "licmanual"){
                    
                    $hit_licencia = 1;
                }else{
                
                    $hit_licencia = 0;
                }
          
            $fechaIngreso = $this->convertDateOracle(date('d/M/y'));
            $unidad = $this->validateuser_library->returnIdUnidadTTO($this->username);
         
            
            $data = array(
                
                'NUM_LICENCIA' => $licencia,
                'APELLIDOS' => $apellidos,
                'NUM_SERIE' => $serie,
                'FECHA_INGRESO' => $fechaIngreso,
                'ID_CLASELIC' => $documento,
                'NOMBRES' => $nombre,
                'ID_DEPARTAMENTO' => $departamento,
                'NUM_PLACA' => $num_placa,
                'ID_TIPOPLACA' => $placa_id->ID_FILA,
                "TIPO_PLACA" => $placa,
                'CLASE_VEHICULO' => $clase,
                'FECHA_ESQUELA' => $this->convertDateOracle($fechaadqui),
                'MARCA' => $marca,
                'MODELO' => $modelo,
                'COLOR' => $color,
                'RUTA' => $ruta,
                'DIRECCION' => $lugar_falta,
                'HORA_ESQUELA' => $hora_falta,
                'ID_FALTA' => $codigo_falta,
                'ID_UNIDAD_TTO' => $unidad,
                'OBSERVACION' => $observaciones_falta,
                'OBSERVACION_AUT' => $observaciones_aut,
                'ONI_IMPONE' => $oni_asignado,
                'ID_UNIDAD_PERSONA' => $unidadTransito->INUNIORG,
                'ID_PLAN' => $plan,
                'ESTADO' => 'PROCESADA',
                'DECOM_VEHICULO' => $vehiculo ? 1 : null,
                'DECOM_TARJETA' => $tarjeta ? 1 : null,
                'DECOM_LICENCIA' => $licencia_cond ? 1 : null,
                'DECOM_1_PLACA' => $placas1 ? 1 : null,
                'DECOM_2_PLACA' => $placas2 ? 1 : null,
                'DECOM_POLIZA' => $poliza ? 1 : null,
                'DECOM_PERMISO_L' => $permiso_linea ? 1 : null,
                'HIT_PLACA' => $hit_placa,
                'HIT_LICENCIA' => $hit_licencia,
                'USER_ADD' => $this->username
            );
           
            $horaMod = date('H:i:s');
            if ($this->form_validation->run() == true) {

                    
                    //$this->upload_file->do_upload('documentos/esquelas', 'img|jpg|jpeg|png', 100, 1024, 768);
                    $archivo = $this->subirArchivo('documentos/esquelas', 'gif|jpg|png|jpeg', 5000, $data['NUM_SERIE'], false);
                     
                    if($archivo){
                        $data['FILE_IMG'] = 1;
                    }else{
                        $data['FILE_IMG'] = 0;
                    }
                    
                    //print_r($data_file);
                    //$this->load->view('upload_success', $data);
                    $this->TransitoModel->create($this->tableName,$data);
                    $impuestas += 1;
                    if($impuestas == 25){
                        $estado = "FINALIZADA";
                    }else{
                        $estado = "REASIGNADO";
                    }

                    

                    $this->TransitoModel->updateNumeroImpuestas($estado, $impuestas, "TTO_TE_TALONARIOS", $data["NUM_SERIE"]);
                    
                    $id = $this->TransitoModel->getId($this->tableName, "NUM_SERIE", $data["NUM_SERIE"]);
                    $data["ID_FILA"] = $id->ID_FILA;
                    $status = true;
                    $datoReg = $this->TransitoModel->getId($this->tableName, "NUM_SERIE", $data['NUM_SERIE']);
                    $this->auditoria($datoReg->ID_FILA,'CREAR','TODOS','NO APLICA','NO APLICA'); 

                    echo json_encode(array("status" => $status , 'data' => $data));
                  
                
            }
            else {
                echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
            }
          
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    } 

    public function update()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1))) {
            
            

            $status = false;
            $id = xss_clean($this->input->post('id_fila'));
            $impuestas = xss_clean($this->input->post('disponibilidad'));
            $serie = xss_clean($this->input->post('serie'));
            $licencia = xss_clean($this->input->post('licencia'));
            $apellidos = xss_clean($this->input->post('apellidos'));
            $documento = xss_clean($this->input->post('documento'));//
            $nombre = xss_clean($this->input->post('nombre'));
            $departamento = xss_clean($this->input->post('departamento'));//
            $num_placa = xss_clean($this->input->post('num_placa'));
            $placa = xss_clean($this->input->post('placa'));
            $manual = xss_clean($this->input->post('manual'));
            $licmanual = xss_clean($this->input->post('licmanual'));
            $id_placa = xss_clean($this->input->post('id_placa'));
            $clase = xss_clean($this->input->post('clase'));
            
            $marca = xss_clean($this->input->post('marca'));
            $modelo = xss_clean($this->input->post('modelo'));
            $color = xss_clean($this->input->post('color'));
            $ruta = xss_clean($this->input->post('ruta'));
            $fechaadqui = xss_clean($this->input->post('fechaadqui'));
            $hora_falta = xss_clean($this->input->post('hora_falta'));
            $codigo_falta = xss_clean($this->input->post('falta'));
            $lugar_falta = xss_clean($this->input->post('lugar_falta'));
            $observaciones_falta = xss_clean($this->input->post('observaciones_falta'));
            $observaciones_aut = xss_clean($this->input->post('observaciones_aut'));
            $oni_asignado = xss_clean($this->input->post('oni_asignado'));
            $dependencia = xss_clean($this->input->post('dependencia'));
            $plan = xss_clean($this->input->post('plan'));
            $observaciones = xss_clean($this->input->post('observaciones'));
            $vehiculo = xss_clean($this->input->post('vehiculo'));
            $tarjeta = xss_clean($this->input->post('tarjeta'));
            $licencia_cond = xss_clean($this->input->post('licencia_cond'));
            $placas1 = xss_clean($this->input->post('placas1'));
            $placas2 = xss_clean($this->input->post('placas2'));
            $poliza = xss_clean($this->input->post('poliza'));
            $permiso_linea = xss_clean($this->input->post('permiso_linea'));

            $this->form_validation->set_rules('observaciones_aut', 'observaciones_aut', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('departamento', 'departamento', 'trim|required|max_length[2]');
            $this->form_validation->set_rules('disponibilidad', 'disponibilidad', 'trim|required|max_length[2]');
            $this->form_validation->set_rules('serie', 'serie', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('licencia', 'licencia', 'trim|required|max_length[17]');
            $this->form_validation->set_rules('apellidos', 'apellidos', 'trim|required|max_length[80]');
            $this->form_validation->set_rules('documento', 'documento', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('nombre', 'nombre', 'trim|required|max_length[80]');
            $this->form_validation->set_rules('departamento', 'departamento', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('num_placa', 'num_placa', 'trim|required|max_length[15]');
            $this->form_validation->set_rules('placa', 'placa', 'trim|max_length[25]');
            $this->form_validation->set_rules('clase', 'clase', 'trim|max_length[30]');
            $this->form_validation->set_rules('marca', 'marca', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('modelo', 'modelo', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('color', 'color', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('ruta', 'ruta', 'trim|max_length[10]');
            $this->form_validation->set_rules('fechaadqui', 'fechaadqui', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('hora_falta', 'hora_falta', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('falta', 'falta', 'trim|required|max_length[8]');
            $this->form_validation->set_rules('lugar_falta', 'lugar_falta', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('observaciones_falta', 'observaciones_falta', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('oni_asignado', 'oni_asignado', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('plan', 'plan', 'trim|required|max_length[6]');
            $this->form_validation->set_rules('vehiculo', 'vehiculo', 'trim|max_length[2]');
            $this->form_validation->set_rules('tarjeta', 'tarjeta', 'trim|max_length[2]');
            $this->form_validation->set_rules('licencia_cond', 'licencia_cond', 'trim|max_length[2]');
            $this->form_validation->set_rules('placas1', 'placas1', 'trim|max_length[2]');
            $this->form_validation->set_rules('placas2', 'placas2', 'trim|max_length[2]');
            $this->form_validation->set_rules('poliza', 'poliza', 'trim|max_length[2]');
            $this->form_validation->set_rules('permiso_linea', 'permiso_linea', 'trim|max_length[2]');

            $unidadTransito = $this->Personal_model->datosPersona($oni_asignado);
           // $unidad = $this->Usuarios_model->getDataByOni($oni_asignado);
           
           
           if(is_numeric($placa)){
                $placa_id = $this->TransitoModel->getId("TTO_CE_TIPOPLACAS", "ID_FILA", $placa);
                $placaDesc = $placa_id->DESCRIPCION;
           }else{
               $plac = $this->TransitoModel->getId("TTO_CE_TIPOPLACAS", "DESCRIPCION", $placa);
               $placaDesc = $placa;
               $placa = $plac->ID_FILA;
           }
          
           
           if(is_numeric($clase)){
                $clase_veh = $this->TransitoModel->getId("TTO_CE_CLASEVEH", "ID_FILA", $clase);
                $clase_vehiculo = $clase_veh->DESCRIPCION;
           }else{
               $clase_vehiculo = $clase;
           }
           
           //$clase = $clase_veh->DESCRIPCION;

           $placaExist = $this->TransitoModel->getByPlaca($placa);
           if($placaExist){
           $hit_placa = 0;
           
           }
          else{
           $hit_placa = 1;
           
          }
          if($licmanual == "licmanual"){
                    
            $hit_licencia = 1;
        }else{
        
            $hit_licencia = 0;
        }
            $fechaIngreso = $this->convertDateOracle(date('d/M/y'));
            $unidad = $this->validateuser_library->returnIdUnidadTTO($this->username);
         
            $data = array(
                'ID_FILA' => $id,
                'NUM_LICENCIA' => $licencia, 
                'APELLIDOS' => $apellidos,
                'NUM_SERIE' => $serie,
                'FECHA_INGRESO' => $fechaIngreso,
                'ID_CLASELIC' => $documento, //id clase licencia
                'NOMBRES' => $nombre,
                'ID_DEPARTAMENTO' => $departamento,
                'NUM_PLACA' => $num_placa, //numero de placa
                'ID_TIPOPLACA' => $placa, // id tipo placa 
                "TIPO_PLACA" => $placaDesc,  //tipo de placa string
                'CLASE_VEHICULO' => $clase_vehiculo, //descripcion de la clase vehiculo
                'FECHA_ESQUELA' => $this->convertDateOracle($fechaadqui),
                'MARCA' => $marca,
                'MODELO' => $modelo,
                'COLOR' => $color,
                'RUTA' => $ruta,
                'DIRECCION' => $lugar_falta,
                'HORA_ESQUELA' => $hora_falta,
                'ID_FALTA' => $codigo_falta,
                'ID_UNIDAD_TTO' => $unidad,
                'OBSERVACION' => $observaciones_falta,
                'OBSERVACION_AUT' => $observaciones_aut,
                'ONI_IMPONE' => $oni_asignado,
                'ID_UNIDAD_PERSONA' => $unidadTransito->INUNIORG,
                'ID_PLAN' => $plan,
                'ESTADO' => 'PROCESADA',
                'DECOM_VEHICULO' => $vehiculo ? 1 : null,
                'DECOM_TARJETA' => $tarjeta ? 1 : null,
                'DECOM_LICENCIA' => $licencia_cond ? 1 : null,
                'DECOM_1_PLACA' => $placas1 ? 1 : null,
                'DECOM_2_PLACA' => $placas2 ? 1 : null,
                'DECOM_POLIZA' => $poliza ? 1 : null,
                'DECOM_PERMISO_L' => $permiso_linea ? 1 : null,
                'HIT_PLACA' => $hit_placa,
                'HIT_LICENCIA' => $hit_licencia
            );

           
           // print_r($data);
            //die;
            $fechaMod = $this->convertDateOracle(date('d/M/y'));
            $horaMod = date('H:i:s');

            if ($this->form_validation->run() == true) {
                $archivos = get_filenames('documentos/esquelas');
             
                if($archivos){
                    foreach($archivos as $nombres){
                        $nom = explode('.', $nombres);
                        if($serie === $nom[0]){
                            $nombreArchivo = $nombres;
                        break;
                        }else{
                            $nombreArchivo = "";
                        }
                    }
                unlink('documentos/esquelas/'.$nombreArchivo);
                
            }
                $archivo = $this->subirArchivo('documentos/esquelas', 'gif|jpg|png|jpeg', 5000, $serie, TRUE);

                if($archivo){
                    $data['FILE_IMG'] = 1;
                }else{
                    $data['FILE_IMG'] = 0;
                }

                    $existencia = $this->TransitoModel->getById($this->tableName, $data['ID_FILA'], "ID_FILA");
                    if($existencia){
                        $data['ID_FILA']  =  $existencia->ID_FILA; 
                       // $data['FECHA_MOD'] = $fechaMod;                   
                        $this->TransitoModel->update($this->tableName,$data,$this->primaryKey);
                        foreach  ($data as $clave => $valor) {
                            if($data[$clave] != $existencia->$clave){
                                $this->auditoria($existencia->ID_FILA,'ACTUALIZAR',$clave,$existencia->$clave,$data[$clave]);
                            }                        
                        }                    
                        $status = true;
                        echo json_encode(array("status" => $status , 'data' => $data));
                    }
                
                
            }else{
                echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
            }
        }
        else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
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

    public function buscar() 
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,5,6))) {
            $userRol =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $unidadTransito =  $this->validateuser_library->returnCcosto($is_valid_token['data']->user_name);
            $numero_serie = xss_clean($this->input->post('buscarSerie'));
            $data = $this->TransitoModel->getEsquelaBySerie($numero_serie);

            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $persona = $this->TransitoModel->getAsigTalonarios(strtoupper($data->ONI_IMPONE), $numero_serie, "busqueda");
                //DOCUMENTO ES TIPO DE LICENCIA
                $documento = $this->TransitoModel->getById('TTO_CE_TIPOSLIC', $data->ID_CLASELIC, 'ID_FILA');
                $departamento = $this->TransitoModel->getById('CATALOGOSPNC.C_DEPARTAMENTOS', $data->ID_DEPARTAMENTO, 'CODEP');
                //$clase = $this->TransitoModel->getById('TTO_CE_CLASEVEH', $data->ID_CLASEVEH, 'ID_FILA');
                $tipo_placa = $this->TransitoModel->getById('TTO_CE_TIPOPLACAS', $data->ID_TIPOPLACA, 'ID_FILA');
                $falta = $this->TransitoModel->getById('TTO_CE_FALTAS', $data->ID_FALTA, 'ID_FILA');
                $plan = $this->TransitoModel->getById('TTO_CE_PLANES', $data->ID_PLAN, 'ID_FILA');
                //$persona = $this->TransitoModel->datosPersona(strtoupper($data->ONI_ASIGNACION));

                

                $data->ESQUELAS_IMPUESTAS = $persona[0]['impuestas'];
                $data->NOMBRE = $persona[0]['nombre']." ".$persona[0]['apellidos'];
                $data->UBICACION = $persona[0]['nomunidad'];
                $data->FECHA_ASIGNACION = $persona[0]['fecha'];
                $data->DOCUMENTO = !empty($documento->DESCRIPCION) ? $documento->DESCRIPCION: null;
                $data->DEPARTAMENTO = !empty($departamento->DESDEP) ? $departamento->DESDEP: null;
                $data->CLASE = !empty($clase->DESCRIPCION) ? $clase->DESCRIPCION: null;
                $data->TIPO_PLACA = !empty($tipo_placa->DESCRIPCION) ? $tipo_placa->DESCRIPCION: null;
                $data->FALTA = !empty($falta->DESCRIPCION) ? $falta->DESCRIPCION: null;
                $data->RUBRO = !empty($falta->RUBRO) ? $falta->RUBRO: null;
                $data->CLASIFICACION = !empty($falta->CLASIFICACION) ? $falta->CLASIFICACION: null;
                $data->VALOR = !empty($falta->VALOR) ? $falta->VALOR: null;
                $data->PLAN = !empty($plan->DESCRIPCION) ? $plan->DESCRIPCION: null;
                $data->UNIDAD_TRANSITO = $unidadTransito;
                $archivos = get_filenames('documentos/esquelas');
                if($archivos){
                    foreach($archivos as $nombres){
                        $nom = explode('.', $nombres);
                        if($numero_serie === $nom[0]){
                            $nombreArchivo = $nombres;
                        break;
                        }else{
                            $nombreArchivo = "";
                        }
                    }
                }
                    
               
                $arr = array('success' => true, 'data' => $data, 'archivos' => isset($nombreArchivo) ? $nombreArchivo  : "");
            }
            if($userRol != 'validacion1'){               
                    $arr = array('success' => false, 'data' => '');                
            }
            echo json_encode($arr);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function delete($filaId)
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name,$roles = array(1))) {
            $status = false;
            $esquelaSeleccionada = $this->TransitoModel->getById($this->tableName,$filaId, $this->primaryKey);
            $talonario = $this->TransitoModel->getTalonario($esquelaSeleccionada->NUM_SERIE);
            //print_r($talonario[0]->TOT_IMPUESTAS);
            $esquelasRestantes = $talonario[0]->TOT_IMPUESTAS - 1;
            $this->TransitoModel->updateNumeroImpuestas($esquelasRestantes, 'TTO_TE_TALONARIOS', $esquelaSeleccionada->NUM_SERIE);
            if ($esquelaSeleccionada) {
                $archivos = get_filenames('documentos/esquelas');
             
                if($archivos){
                    foreach($archivos as $nombres){
                        $nom = explode('.', $nombres);
                        if($esquelaSeleccionada->NUM_SERIE === $nom[0]){
                            $nombreArchivo = $nombres;
                        break;
                        }else{
                            $nombreArchivo = false;
                        }
                    }
                    if($nombreArchivo){
                        chmod('documentos/esquelas/'.$nombreArchivo, 0755); 
                        $permisos = fileperms('documentos/esquelas');
                        unlink('documentos/esquelas/'.$nombreArchivo);
                    }
                    
                }
                    
                $arraySeleccionado = (array) $esquelaSeleccionada;
                $this->TransitoModel->create('TTO_TE_ESQUELAS_ELIMINADOS', $arraySeleccionado);
                $this->TransitoModel->delete($this->tableName,$filaId,$this->primaryKey);
                $this->auditoria($filaId,'BORRAR','TODOS','NO APLICA','NO APLICA');
                $status = true;
            }
            echo json_encode(array('status' => $status));
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
            $response = $this->Armas_model->getSelectAll($searchTerm,  $this->primaryKey, 'NOM_ESTADO', 'ARM_C_ESTADOS');
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


    public function getSelect2Documentos()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,6))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $response = $this->TransitoModel->getSelect2Documento($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getSelect2Departamentos()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,6))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $response = $this->TransitoModel->getSelect2Departamento($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getByPlaca()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,3))) {
            $status = false;
            $arr = array('success' => $status, 'data' => '');
            
            if ($this->input->post()) {
                $placa = $this->input->post('placa');
         
            
                $data = $this->TransitoModel->getByPlaca(strtoupper($placa));
                //print_r($data[0]['tipo_placa']);
                
                if ($data) {
                    $id_placa = $this->TransitoModel->getId("TTO_CE_TIPOPLACAS", "DESCRIPCION", $data[0]['tipo_placa']);
                    $id_clase = $this->TransitoModel->getId("TTO_CE_CLASEVEH", "DESCRIPCION", $data[0]['clase']);
                    $data[0]['id_placa'] = $id_placa->ID_FILA;
                    $data[0]['id_clase'] = $id_clase->ID_FILA;
                    $status = true;
                    $arr = array('success' => $status, 'data' => $data);
                }else{
                    $arr = array('success' => 'no valida', 'data' => false);
                }
            }
            echo json_encode($arr);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getSelect2Plan()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,6))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $response = $this->TransitoModel->getSelect2Plan($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getSelect2Falta()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,6))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $response = $this->TransitoModel->getSelect2Falta($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getAsigTalonarios(){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,3,4,5,6))) {
            $status = false;
            $arr = array('success' => $status, 'data' => '');
            if ($this->input->post()) {
                $oni = $this->input->post('oni');
                $serie = $this->input->post('serie');

                $this->form_validation->set_rules('oni', 'oni', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('serie', 'Serie', 'trim|required|max_length[20]');

                if ($this->form_validation->run() == true) {
                    $data = $this->TransitoModel->getAsigTalonarios(strtoupper($oni), $serie, "ingreso");
                    if ($data != false) {
                        if($data == "no corresponde"){
                            echo json_encode(array("status" => "no corresponde", 'data' => false));
                        }else{
                            $status = true;
                            $arr = array('success' => $status, 'data' => $data);
                            echo json_encode($arr);
                        }
                        
                    }else{
                        echo json_encode(array("status" => "repetido", 'data' => false));
                    }
                }else{
                    echo json_encode(array("status" =>'form-not-valid', 'messages' => validation_errors()));
                }

                
            }
            
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getSelect2Clase()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2,3))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $response = $this->TransitoModel->getSelect2Clase($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function getSelect2Placa()
    {
        $is_valid_token = $this->authorization_token->validateToken();
       if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name, $roles = array(1,2,3))){
            $searchTerm = xss_clean(strtoupper($this->input->post('searchTerm')));
            $response = $this->TransitoModel->getSelect2Placa($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    public function subirArchivo($directorio, $formatos, $max_size, $nombre_file, $actualizar){
        $config['upload_path'] = $directorio;
        $config['allowed_types'] = $formatos;
        $config['max_size'] = $max_size;
        $config['file_name'] = $nombre_file;
        $config['overwrite'] = $actualizar;

        $this->upload->initialize($config);
        $this->load->library('upload', $config);

        return $this->upload->do_upload('file');
       
}
}
