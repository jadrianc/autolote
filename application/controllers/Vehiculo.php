<?php

use function Matrix\add;

defined('BASEPATH') or exit('No direct script access allowed');

class Vehiculo extends CI_Controller
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
        $this->tableName = 'vehiculos';
        $this->primaryKey = 'id_vehiculo';
    }

    public function index()
    {
        
 
        
            $data['title'] = 'Vehiculos'; // Capitalize the first letter
            $data['username'] = $_SESSION['usuario'];

            $this->load->view('templates/header', $data);
            $this->load->view('vehiculo/index', $data);
            $this->load->view('templates/footer', $data);
        
    }

    public function getSelect2Marca()
    {
        
            $searchTerm = strtoupper($this->input->post('searchTerm'));
            $response = $this->models->getSelect2Marca($searchTerm);
            echo json_encode($response);
        
    }

    public function getSelect2Modelo()
    {
        
            $searchTerm = strtoupper($this->input->post('searchTerm'));
            $response = $this->models->getSelect2Modelo($searchTerm);
            echo json_encode($response);
        
    }

    public function getAllVehiculos()
    {
           
            $data = $this->models->getAllVehiculos($this->tableName);
            $arr = array('success' => false, 'data' => '');
            if ($data) {
                $arr = array('data' => $data);
            }
            echo json_encode($arr);
        
    }

    public function getAllVehiculosCliente()
    {
           
            $data = $this->models->getAllVehiculosCliente($this->tableName);
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

    public function getVehById($id)
    {
        
            $data = $this->models->getVehById($id, $this->tableName, $this->primaryKey);
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
                $id_marca = xss_clean(strtoupper($this->input->post('marca')));
                $id_modelo =  xss_clean($this->input->post('modelo'));
                $año = xss_clean($this->input->post('año'));
                $precio = xss_clean($this->input->post('precio'));
                $nombreContacto = xss_clean($this->input->post('nombreContacto'));
                $telefono = xss_clean($this->input->post('telefono'));
                $direccion = xss_clean($this->input->post('direccion'));
                $observaciones = xss_clean($this->input->post('observaciones'));
                //print_r($_FILES);
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                $nomDirectorio = substr(str_shuffle($permitted_chars), 0, 10);
                $index = 0;
                $dirs = [];
                $directorios = [];
                foreach($_FILES["pro-image"]['tmp_name'] as $key => $tmp_name)
                    {
                        //Validamos que el archivo exista
                        if($_FILES["pro-image"]["name"][$key]) {
                            $filename = $_FILES["pro-image"]["name"][$key]; //Obtenemos el nombre original del archivo
                            $source = $_FILES["pro-image"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                            
                            $directorio = 'documentos/'.$nomDirectorio; //Declaramos un  variable con la ruta donde guardaremos los archivos
                            
                            //Validamos si la ruta de destino existe, en caso de no existir la creamos
                            if(!file_exists($directorio)){
                                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                            }
                            
                            $dir=opendir($directorio); //Abrimos el directorio de destino
                            $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                            
                            //Movemos y validamos que el archivo se haya cargado correctamente
                            //El primer campo es el origen y el segundo el destino
                            if(move_uploaded_file($source, $target_path)) {
                                
                                array_push($directorios, $target_path);	
                                
                                } else {	
                                
                            }
                            closedir($dir); //Cerramos el directorio de destino
                        }
                    }
                    
                $newRecord = array(
                    'id_marca' => $id_marca,
                    'id_modelo' => $id_modelo,
                    'año' => $año, 
                    'precio' => $precio,
                    'nombre_contacto' => $nombreContacto,
                    'telefono_contacto' => $telefono,
                    'direccion_contacto' => $direccion,
                    'observaciones' => $observaciones,
                    'foto1' => empty($directorios[0]) ? "" : $directorios[0],
                    'foto2' => empty($directorios[1]) ? "" : $directorios[1],
                    'foto3' => empty($directorios[2]) ? ""  : $directorios[2],
                    'foto4' => empty($directorios[3]) ? "" : $directorios[3],
                    'estado' => "Disponible"
                );
            
                $this->form_validation->set_rules('marca', 'id_marca', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('modelo', 'id_modelo', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('año', 'año', 'required|max_length[4]');
                $this->form_validation->set_rules('precio', 'precio', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('nombreContacto', 'nombreContacto', 'required|max_length[70]');
                $this->form_validation->set_rules('telefono', 'telefono', 'trim|required|max_length[10]');
                $this->form_validation->set_rules('direccion', 'direccion', 'required|max_length[150]');
                $this->form_validation->set_rules('observaciones', 'observaciones', 'trim|required|max_length[255]');
            
            
                if ($this->form_validation->run() == true) {
                    
                    $this->models->create($newRecord, "vehiculos");
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
            $id_vehiculo = xss_clean(strtoupper($this->input->post('id_vehiculo')));
            $id_marca = xss_clean(strtoupper($this->input->post('marca')));
            $id_modelo =  xss_clean($this->input->post('modelo'));
            $año = xss_clean($this->input->post('año'));
            $precio = xss_clean($this->input->post('precio'));
            $nombreContacto = xss_clean($this->input->post('nombreContacto'));
            $telefono = xss_clean($this->input->post('telefono'));
            $direccion = xss_clean($this->input->post('direccion'));
            $observaciones = xss_clean($this->input->post('observaciones'));
            $estado = xss_clean($this->input->post('estadoV'));
            
            
            $data = array(
                'id_vehiculo' => $id_vehiculo,
                'id_marca' => $id_marca,
                'id_modelo' => $id_modelo,
                'año' => $año, 
                'precio' => $precio,
                'nombre_contacto' => $nombreContacto,
                'telefono_contacto' => $telefono,
                'direccion_contacto' => $direccion,
                'observaciones' => $observaciones,
                'estado' => $estado
            );
        
            $this->form_validation->set_rules('marca', 'id_marca', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('modelo', 'id_modelo', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('año', 'año', 'required|max_length[4]');
            $this->form_validation->set_rules('precio', 'precio', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('nombreContacto', 'nombreContacto', 'required|max_length[70]');
            $this->form_validation->set_rules('telefono', 'telefono', 'trim|required|max_length[10]');
            $this->form_validation->set_rules('direccion', 'direccion', 'required|max_length[150]');
            $this->form_validation->set_rules('observaciones', 'observaciones', 'trim|required|max_length[255]');

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
