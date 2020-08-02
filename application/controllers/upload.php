<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Upload extends CI_Controller
{
    public function __construct()
    { 
        parent::__construct();
        $this->load->model('CentrosCostos_model');
        $this->load->model('MovimientosActivos_model');
        $this->load->model('Actas_model');
        $this->load->model('Auditoria_model');
        $this->load->model('ActivosFijos_model');
        $this->load->helper('url_helper');
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {
            redirect('login');
        }
        $this->username = $this->session->userdata['username'];
        $this->CI =& get_instance();
        $this->load->library('authorization_token');
        $this->load->library('timejwt_library');
        $this->load->library('audit_library');
        $this->load->library('validateuser_library');
        $this->tableName = 'T_MOVIMIENTOS';
    }

    #SUBE LOS ARCHIVOS ADJUNTOS DE ASIGNACIONES, DEVOLUCIONES Y TRASLADOS 
    public function UploadDocumentosAsignacion()
    {
        try {
            $is_valid_token = $this->authorization_token->validateToken();
            if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $status = false;
            
            $filaid = xss_clean($this->input->post('numDoc'));
            $carpeta = 'documentos';
            $str = $_FILES['image']['name'];
            $explode = explode(".", $str);
            $extencion = array_pop($explode);    
            $nombreDoc = $carpeta.'/'.$filaid.'.'.$extencion;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'],$nombreDoc )) {
                $this->ActivosFijos_model->updateAsignacionPersonal(
                    array(
                    'FILAID' => $filaid,
                    'RUTA_DOC' => $filaid
                    ));
                $status = true;
            }
            #AUDITORIA PARA INSERTO EN T_ASGINACION_PERSONAL
            $oniUSer= strtoupper($this->validateuser_library->ONIByUser($this->session->userdata('username')));
            $this->Auditoria_model->create(
                $this->audit_library->auditArray(
                    'APPLICATION/DOCUMENTOS',
                    $filaid,
                    'SUBIR',
                    $oniUSer,
                    'TODOS',
                    'NO APLICA',
                    'NO APLICA',
                    $this->input->ip_address()
            ));
            echo json_encode(array("status" => $status));
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    #OBTIENE LOS ARCHIVOS SUBIDOS A UN DIRECOTRIO
    function obtenerListadoDeArchivos($url){
        $directorio = "application/documentos/docAsignaciones";
        if (file_exists($directorio)) {
            $directorio = "application/documentos/docAsignaciones";
        }
        else{
            $directorio = "application/documentos/default";
        }
        $data = array();
        if(substr($directorio, -1) != "/") $directorio .= "/";      
        // Creamos un puntero al directorio y obtenemos el listado de archivos
        $dir = @dir($directorio);
        $archivo = $dir->read();
        while($archivo != false) {
            // Obviamos los archivos ocultos
            if($archivo[0] == ".") continue;
            if(is_dir($directorio . $archivo)) {
                $data[] = array(
                  "Nombre" => $archivo . "/",
                  "Tamaño" => 0,
                  "Modificado" => date ("Y-m-d H:i:s.",filemtime($directorio . $archivo)),
                  "Documento" => $url,
                  "view" => "<button type='button' class='btn btn-danger ml-3 btn-erase' id='btnErase'><i class='fas fa-trash'></i></button>"
                );
            } else if (is_readable($directorio . $archivo)) {
                $tamanio = (filesize($directorio . $archivo))/1024;
                $unidad = 'Kb';
                if($tamanio>1024){
                    $tamanio = $tamanio/1024;
                    $unidad = 'Mb';
                }
                $tamanioFinal= number_format($tamanio,2,'.','');
                $data[] = array(
                  "Nombre" => $archivo,
                  "Tamaño" => $tamanioFinal.''.$unidad,
                  "Modificado" => date ("Y-m-d H:i:s.",filemtime($directorio . $archivo)),
                  "Documento" => $url,
                  "view" => "<button type='button' class='btn btn-danger ml-3 btn-erase' id='btnErase'><i class='fas fa-trash'></i></button>"
                );
            }
        }
        $dir->close();
        echo json_encode($data);
    }


    #BORRA LOS ARCHIVOS ADJUNTOS DE ASIGNACIONES, DEVOLUCIONES Y TRASLADOS 
    public function UploadDeleteAsignacion($archivo, $dir)
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $status = false;
            $file = "documentos/".$archivo;
            if (is_readable($file) && unlink($file)) {
                $this->ActivosFijos_model->updateAsignacionPersonal(
                    array(
                    'FILAID' => $dir,
                    'RUTA_DOC' => ''
                    ));
                $status = true;
            } else {
                $status = false;
            }
            echo json_encode($status);
        }
    }

    public function BuscarArchivos($id){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,3,4,5))) {
            
            $nombreArchivo = $this->ActivosFijos_model->getNombreArchivo($id);
                echo json_encode($nombreArchivo);
           
            
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
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
            "Tamaño" => round(filesize($directorio.$ficheros[$index])/1024, 0) . " KB",
            "Modificado" => date("F d Y H:i:s.", filemtime($directorio.$ficheros[$index])),
            "Documento" => $id,
            "view" => "<button type='button' class='btn btn-danger ml-3 btn-erase' id='btnErase'><i class='fas fa-trash'></i></button><a type='button' href='$ruta/documentos/$ficheros[$index]' target='_blank' class='btn btn-info ml-3 btnPdfs' id='btnPdfs'><i class='fas fa-file-pdf'></i></a>"
          );
          echo json_encode($data);
    }

    function abrirDocumentoPDF($nombreArchivo){
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,3,4,5))) {
        
            redirect(base_url().'application/documentos/docAsignaciones/'.$nombreArchivo);
            
        }else{
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }
    
}
?>