<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

error_reporting(0);
class Reportes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->username = $this->session->userdata['username'];
        $this->load->model('Actas_model');
        $this->load->model('CentrosCostos_model');
        $this->load->model('Clases_model');
        $this->load->model('SubClases_model');
        $this->load->model('Estados_model');
        $this->load->model('ActivosFijos_model');
        $this->load->model('MovimientosActivos_model');
        $this->load->model('Personal_model');
        $this->load->helper('url_helper');
        $this->load->helper('date');
        $this->load->library('authorization_token');
        $this->load->library('validateuser_library');
        $this->load->library('timejwt_library');
    }    

    public function index()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));

        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $sessionTimeout = $this->timejwt_library->differenceTime(
                $this->CI->config->item('jwt_expire_time'),
                $is_valid_token['data']->time
            );
            $data['title'] = 'Reportes de Bienes por Centro de Costo'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function vistaReporteAsignacion()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $sessionTimeout = $this->timejwt_library->differenceTime(
                $this->CI->config->item('jwt_expire_time'),
                $is_valid_token['data']->time
            );

            $data['title'] = 'Reporte Asignación'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/asignacion', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function ReporteGeneral()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));

        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $sessionTimeout = $this->timejwt_library->differenceTime(
                $this->CI->config->item('jwt_expire_time'),
                $is_valid_token['data']->time
            );

            $data['title'] = 'Reportes de Bienes por Centro de Costo'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/index', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function ControlDeCalidad()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));

        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $sessionTimeout = $this->timejwt_library->differenceTime(
                $this->CI->config->item('jwt_expire_time'),
                $is_valid_token['data']->time
            );

            $data['title'] = 'Reporte de Control de Calidad'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['estados'] =  $this->Estados_model->getAll();
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/controlcalidad', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }


    public function getSelect2Motivos()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $searchTerm = strtoupper($this->input->post('searchTerm'));
            $response = $this->Actas_model->getSelect2($searchTerm);
            echo json_encode($response);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }
    
    public function GeneradorReportes()
    {
        $sessionTimeout = $this->timejwt_library->differenceTime(
            $this->CI->config->item('jwt_expire_time'),
            $this->session->userdata('time_login')
        );

        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));

        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $sessionTimeout = $this->timejwt_library->differenceTime(
                $this->CI->config->item('jwt_expire_time'),
                $is_valid_token['data']->time
            );

            $user = $this->session->userdata('username');
            $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
    
            $data['title'] = 'Generador de Reportes'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['ID_ROL'] = $userInfo->ID_ROL;
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/generador', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    #PDF DE LA ASIGNACIÓN DE BIENES
    public function reporteAsignacionP($ccosto, $filaid)
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,4))) {
            
            $cCostoSelected = $this->CentrosCostos_model->getById($ccosto);
            $activos = $this->ActivosFijos_model->getAsignacionPersonal($filaid);

            $this->load->library('pdf_asignacion');
            $pdf = $this->pdf_asignacion->getInstance();
            $documento = str_pad($filaid, 6, "0", STR_PAD_LEFT);
            $asigEncabezado = $this->ActivosFijos_model->getAsignacion($filaid);
            $tipoMov = $asigEncabezado->TIPO_MOV;

            $pdf->SetDocumento($documento); 
            $pdf->SetTipoDocumento($tipoMov); 
            $pdf->SetFecha($asigEncabezado->FECHA_ASIGNA); 
            $pdf->SetCCosto($cCostoSelected); 
            $pdf->SetUser($this->session->userdata('username'), strtoupper($this->validateuser_library->ONIByUser($this->session->userdata('username'))));
            
            $pdf->AddPage('L', 'Letter');
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,35,55,30,25,25,30,45));
            $pdf->SetAligns(array('C','C','L','L','L','L','R','L'));

            if ($activos->num_rows() > 0) {
                $correlativo = 1;
                $sumaValor = 0;
                foreach ($activos->result() as $x) {
                    $subClase = str_pad($x->SUBCLA, 3, "0", STR_PAD_LEFT);
                    $correlsc = str_pad($x->CORRELSC, 4, "0", STR_PAD_LEFT);
                    $valor = number_format($x->VALORAR, 2, '.', ',');
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array($correlativo++, ($x->CLASE.'-'.$subClase.'-'.$correlsc), $x->NOM_SUB,$x->NOM_MAR,$x->NOM_MOD,$x->SERIE,$valor,$x->OBSERVACIONES ),0);
                    $sumaValor = $sumaValor+$x->VALORAR;
                }
                $pdf->Cell(180,10,'TOTAL $',0,0,'R');
                $pdf->Cell(30,10,number_format($sumaValor, 2, '.', ','),0,1,'R');
                
                $oniJefe = $this->Personal_model->datosPersona(strtoupper($asigEncabezado->ONI_JEFE));
                $oniEncargado = $this->Personal_model->datosPersona(strtoupper($asigEncabezado->ONI_ENCARGADO));
                $oniAsignado = $this->Personal_model->datosPersona(strtoupper($asigEncabezado->ONI_ASIGNADO));

                $pdf->ln(15);
                if($tipoMov==='ASIGNACION'){
                    $pdf->Cell(90,4,'Firma:          ____________________________________',0,0,'L');
                    $pdf->Cell(90,4,'Firma:          ____________________________________',0,0,'L');
                    $pdf->Cell(30,4,'Firma:          ____________________________________',0,1,'L');

                    $pdf->Cell(90,4,'Nombre:         '.$oniJefe->NOMPER.' '.$oniJefe->APEPER,0,0,'L');
                    $pdf->Cell(90,4,'Nombre:         '.$oniEncargado->NOMPER.' '.$oniEncargado->APEPER,0,0,'L');
                    $pdf->Cell(30,4,'Nombre:         '.$oniAsignado->NOMPER.' '.$oniAsignado->APEPER,0,1,'L');

                    $pdf->Cell(90,4,'Cargo:           '.'JEFE DEL CENTRO DE COSTO',0,0,'L');
                    $pdf->Cell(90,4,'Cargo:           '.'ENCARGADO DE ACTIVO FIJO',0,0,'L');
                    $pdf->Cell(30,4,'Cargo:            '.$oniAsignado->DEPUESTO,0,1,'L');

                    $pdf->Cell(90,4,'ONI:              '.$asigEncabezado->ONI_JEFE,0,0,'L');
                    $pdf->Cell(90,4,'ONI:              '.$asigEncabezado->ONI_ENCARGADO,0,0,'L');
                    $pdf->Cell(90,4,'ONI:               '.$asigEncabezado->ONI_ASIGNADO,0,1,'L');

                    $pdf->Cell(90,4,'',0,0,'C');
                    $pdf->Cell(42,4,'ENTREGA',0,0,'C');
                    $pdf->Cell(43,4,'',0,0,'C');
                    $pdf->Cell(32,4,'RECIBE',0,1,'R');
                }
                else{
                    $pdf->Cell(90,4,'Firma:          ____________________________________',0,0,'L');
                    $pdf->Cell(30,4,'Firma:          ____________________________________',0,1,'L');

                    $pdf->Cell(90,4,'Nombre:         '.$oniEncargado->NOMPER.' '.$oniEncargado->APEPER,0,0,'L');
                    $pdf->Cell(30,4,'Nombre:         '.$oniAsignado->NOMPER.' '.$oniAsignado->APEPER,0,1,'L');

                    $pdf->Cell(90,4,'Cargo:           '.'ENCARGADO DE ACTIVO FIJO',0,0,'L');
                    $pdf->Cell(90,4,'Cargo:           '.$oniAsignado->DEPUESTO,0,1,'L');                    

                    $pdf->Cell(90,4,'ONI:              '.$asigEncabezado->ONI_ENCARGADO,0,0,'L');
                    $pdf->Cell(30,4,'ONI:              '.$asigEncabezado->ONI_ASIGNADO,0,1,'L');

                    $pdf->Cell(40,4,'RECIBE',0,0,'C');
                    $pdf->Cell(65,4,'',0,0,'C');
                    $pdf->Cell(110,4,'DEVUELVE',0,1,'L');
                }
            }
            $pdfString = $pdf->Output(trim($cCostoSelected->CCOSTO).' - '.trim($cCostoSelected->NOM_COS)."_".date('d/m/Y').".pdf", "S");
            $pdfBase64 = base64_encode($pdfString);
            echo 'data:application/pdf;base64,' . $pdfBase64;                 
        }
    }    

    #PDF DE TRASLADOS DE BIENES A CENTROS DE COSTOS
    public function reporteAsignacionPtraslado($ccosto, $filaid)
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,4))) {
            
            $cCostoSelected = $this->CentrosCostos_model->getById($ccosto);
            $activos = $this->ActivosFijos_model->getAsignacionPersonal($filaid);

            $this->load->library('pdf_asignacion_traslado');
            $pdf = $this->pdf_asignacion_traslado->getInstance();
            $documento = str_pad($filaid, 6, "0", STR_PAD_LEFT);
            $asigEncabezado = $this->ActivosFijos_model->getAsignacion($filaid);
            $tipoMov = $asigEncabezado->TIPO_MOV;

            $oniJefe = $this->Personal_model->datosPersona(strtoupper($asigEncabezado->ONI_JEFE));
            $oniEncargado = $this->Personal_model->datosPersona(strtoupper($asigEncabezado->ONI_ENCARGADO));
            $oniAsignado = $this->Personal_model->datosPersona(strtoupper($asigEncabezado->ONI_ASIGNADO));

            $pdf->SetDocumento($documento); 
            $pdf->SetTipoDocumento($tipoMov); 
            $pdf->SetCCosto($cCostoSelected); 
            $pdf->SetCCosto2($oniAsignado->NOMUNIDAD); 
            $pdf->SetUser($this->session->userdata('username'), strtoupper($this->validateuser_library->ONIByUser($this->session->userdata('username'))));
            
            $pdf->AddPage('L', 'Legal');
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,35,55,30,25,25,25,25,25,30,45));
            $pdf->SetAligns(array('C','C','L','L','L','L','L','L','L','R','L'));

            if ($activos->num_rows() > 0) {
                $correlativo = 1;
                $sumaValor = 0;
                foreach ($activos->result() as $x) {
                    $subClase = str_pad($x->SUBCLA, 3, "0", STR_PAD_LEFT);
                    $correlsc = str_pad($x->CORRELSC, 4, "0", STR_PAD_LEFT);
                    $valor = number_format($x->VALORAR, 2, '.', ',');
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array($correlativo++, ($x->CLASE.'-'.$subClase.'-'.$correlsc), $x->NOM_SUB,$x->NOM_MAR,$x->NOM_MOD,$x->SERIE,$x->CHASIS,$x->MOTOR,$x->NUMEQUIPO,$valor,$x->OBSERVACIONES ),0);
                    $sumaValor = $sumaValor+$x->VALORAR;
                }
                $pdf->Cell(180,10,'TOTAL $',0,0,'R');
                $pdf->Cell(30,10,number_format($sumaValor, 2, '.', ','),0,1,'R');               
               
                
                $pdf->Cell(30,6,'OBSERVACIONES:   _______________________________________________________________________________________________________________________________________________________________________________',0,1,'L');
                $pdf->Cell(25);
                $pdf->Cell(30,6,'_______________________________________________________________________________________________________________________________________________________________________________',0,1,'L');

                $pdf->ln(15);
                
                $pdf->Cell(90,4,'Firma:          ____________________________________',0,0,'L');
                $pdf->Cell(90,4,'Firma:          ____________________________________',0,0,'L');
                $pdf->Cell(30,4,'Firma:          ____________________________________',0,1,'L');

                $pdf->Cell(90,4,'Nombre:         '.$oniJefe->NOMPER.' '.$oniJefe->APEPER,0,0,'L');
                $pdf->Cell(90,4,'Nombre:         '.$oniEncargado->NOMPER.' '.$oniEncargado->APEPER,0,0,'L');
                $pdf->Cell(30,4,'Nombre:         '.$oniAsignado->NOMPER.' '.$oniAsignado->APEPER,0,1,'L');

                $pdf->Cell(90,4,'Cargo:           '.'JEFE DE DEL CENTRO DE COSTO',0,0,'L');
                $pdf->Cell(90,4,'Cargo:           '.'ENCARGADO DE A.F.',0,0,'L');
                $pdf->Cell(90,4,'Cargo:           '.'RESPONSABLE DE CENTRO DE COSTO',0,0,'L');
                $pdf->Cell(90,4,' ____________________________________',0,1,'L');

                $pdf->Cell(90,4,'ONI:              '.$asigEncabezado->ONI_JEFE,0,0,'L');
                $pdf->Cell(90,4,'ONI:              '.$asigEncabezado->ONI_ENCARGADO,0,0,'L');
                $pdf->Cell(90,4,'ONI:              '.$asigEncabezado->ONI_ASIGNADO,0,0,'L');
                $pdf->Cell(55,4,'FIRMA Y SELLO PROCESADO',0,1,'C');
                $pdf->Cell(119,4,'ENTREGA',0,0,'R');
                $pdf->Cell(87.5,4,'RECIBE',0,0,'R');
                
            }            
            $pdfString = $pdf->Output(trim($cCostoSelected->CCOSTO).' - '.trim($cCostoSelected->NOM_COS)."_".date('d/m/Y').".pdf", "S");
            $pdfBase64 = base64_encode($pdfString);
            echo 'data:application/pdf;base64,' . $pdfBase64;                 
        }
    }  
    #hasta aqui mi pdf

    public function ReporteActivoFijo($ccosto)
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $clases = array();
            $subclases = array();
            $activos = array();

            if ($cCostoSelected = $this->CentrosCostos_model->getById($ccosto)) {
                $clasesSelected = $this->ActivosFijos_model->getClaseByCCosto($cCostoSelected->CCOSTO);
                foreach ($clasesSelected as $clase) {
                    array_push($clases, $clase->CLASE);
                }
                    
                if (count($clases) == 0) {
                    return $this->PDFErrorGeneral($cCostoSelected);
                    exit();
                }
                    
                $subclasesSelected = $this->ActivosFijos_model->getSubClaseByClaseAndCCosto($cCostoSelected->CCOSTO, $clases);
                foreach ($subclasesSelected as $subclase) {
                    array_push($subclases, $subclase->SUBCLA);
                }

                if (count($subclases) == 0) {
                    return $this->PDFErrorGeneral($cCostoSelected);
                    exit();
                }

                $activosSelected = $this->ActivosFijos_model->getActivoFijoByClaseSubClaseCCosto($clases, $subclases, $cCostoSelected->CCOSTO);
                foreach ($subclasesSelected as $subclase) {
                    array_push($subclases, $subclase->SUBCLA);
                }
        
                $array = json_decode(json_encode($activosSelected), true);
                $groupedArray = $this->groupArray($array, "CLASE_SUBCLASE");
                   
                $this->PDFActivosCentroDeCosto($cCostoSelected, $groupedArray);
            } else {
                return $this->PDFErrorGeneral($cCostoSelected);
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function ExcelPorCentroDeCostoInvTec($ccosto, $token)
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($token);
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,5,6))) {
            $clases = array();
            $subclases = array();
            $activos = array();

            if ($cCostoSelected = $this->CentrosCostos_model->getById($ccosto)) {
                $clasesSelected = $this->ActivosFijos_model->getClaseByCCosto($cCostoSelected->CCOSTO);
                foreach ($clasesSelected as $clase) {
                    if($clase->CLASE == 301 || $clase->CLASE == 302 || $clase->CLASE == 354){
                        array_push($clases, $clase->CLASE);        
                    }
                    
                }
                //301, 302, 354
                if (count($clases) == 0) {
                    return $this->PDFErrorGeneral($cCostoSelected);
                    exit();
                }
            
                $subclasesSelected = $this->ActivosFijos_model->getSubClaseByClaseAndCCosto($cCostoSelected->CCOSTO, $clases);
                foreach ($subclasesSelected as $subclase) {
                    
                        array_push($subclases, $subclase->SUBCLA);
                }

                if (count($subclases) == 0) {
                    return $this->PDFErrorGeneral($cCostoSelected);
                    exit();
                }

                $activosSelected = $this->ActivosFijos_model->getActivoFijoByClaseSubClaseCCostoInvTec($clases, $subclases, $cCostoSelected->CCOSTO);
                foreach ($subclasesSelected as $subclase) {
                    array_push($subclases, $subclase->SUBCLA);
                }

                $array = json_decode(json_encode($activosSelected), true);
                $groupedArray = $this->groupArray($array, "CLASE_SUBCLASE");
                //var_dump($subclases);
                $this->ExcelActivosCentroDeCosto($cCostoSelected, $groupedArray);
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function ExcelPorCentroDeCosto($ccosto, $token)
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($token);
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,5,6))) {
            $clases = array();
            $subclases = array();
            $activos = array();

            if ($cCostoSelected = $this->CentrosCostos_model->getById($ccosto)) {
                $clasesSelected = $this->ActivosFijos_model->getClaseByCCosto($cCostoSelected->CCOSTO);
                foreach ($clasesSelected as $clase) {
                    
                        array_push($clases, $clase->CLASE);        
                    
                    
                }
                //301, 302, 354
                if (count($clases) == 0) {
                    return $this->PDFErrorGeneral($cCostoSelected);
                    exit();
                }
            
                $subclasesSelected = $this->ActivosFijos_model->getSubClaseByClaseAndCCosto($cCostoSelected->CCOSTO, $clases);
                foreach ($subclasesSelected as $subclase) {
                    array_push($subclases, $subclase->SUBCLA);
                }

                if (count($subclases) == 0) {
                    return $this->PDFErrorGeneral($cCostoSelected);
                    exit();
                }

                $activosSelected = $this->ActivosFijos_model->getActivoFijoByClaseSubClaseCCosto($clases, $subclases, $cCostoSelected->CCOSTO);
                foreach ($subclasesSelected as $subclase) {
                    array_push($subclases, $subclase->SUBCLA);
                }

                $array = json_decode(json_encode($activosSelected), true);
                $groupedArray = $this->groupArray($array, "CLASE_SUBCLASE");
                //var_dump($cCostoSelected->CCOSTO);
                $this->ExcelActivosCentroDeCosto($cCostoSelected, $groupedArray);
            }
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function ExcelPorCentroDeCostoInvTecnico($request, $token)
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($token);
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,5,6))) 
        {
            
            $outBase64 = base64_decode($request);
            $objRequest = json_decode($outBase64, false);
            
            $whereSentence = array();
            $cCosto = xss_clean($objRequest->cCosto);
            $subClase = xss_clean($objRequest->subClase);
            $clase = xss_clean($objRequest->clase);
            $claseA = array($clase);
            $subClaseA = array($subClase);
            $user = $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);

            $activosFijos = $this->ActivosFijos_model->getActivoFijoByClaseSubClaseCCostoInvTecnico($clase, $subClase, $cCosto);
            $array = json_decode(json_encode($activosFijos), true);
            $groupedArray = $this->groupArray($array, "CLASE_SUBCLASE");
            $this->ExcelActivosCentroDeCostoInvTecnico($cCosto, $clase, $subClase, $groupedArray);
            //var_dump($claseA);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    private function ExcelActivosCentroDeCostoInvTecnico($cCosto, $clase, $subClase, $datosReporte)
    {
        $fileName = trim($clase).' - '.trim($subClase).' - '.trim($cCosto);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'CAF');
        $sheet->setCellValue('B1', 'CLASE');
        $sheet->setCellValue('C1', 'SUBCLASE');
        $sheet->setCellValue('D1', 'CORRELATIVO');
        $sheet->setCellValue('E1', 'TIPO ADQ.');
        $sheet->setCellValue('F1', 'FEC. INGRESO.');
        $sheet->setCellValue('G1', 'FEC. ASIG');
        $sheet->setCellValue('H1', 'COMPROB. CTBLE.');
        $sheet->setCellValue('I1', 'FACTURA');
        $sheet->setCellValue('J1', 'OBSERV.');
        $sheet->setCellValue('K1', 'MARCA');
        $sheet->setCellValue('L1', 'NOMBRE PROVEEDOR');
        $sheet->setCellValue('M1', 'FECHA DESCARGO');
        $sheet->setCellValue('N1', 'SERIE');
        $sheet->setCellValue('O1', 'FOLIO/ACTA');
        $sheet->setCellValue('P1', 'GARANTIA');
        $sheet->setCellValue('Q1', 'FIN GARANTIA');
        $sheet->setCellValue('R1', 'MANTENIMIENTO');
        $sheet->setCellValue('S1', 'IP');
        $sheet->setCellValue('T1', 'Disco Duro');
        $sheet->setCellValue('U1', 'Memoria RAM');
        $sheet->setCellValue('V1', 'Procesador');
        $sheet->setCellValue('W1', 'Sistema Operativo');
        $sheet->setCellValue('X1', 'No. AF1');
        $sheet->setCellValue('Y1', 'V.UNITARIO');
        $sheet->setCellValue('Z1', 'ESTADO');
        $sheet->setCellValue('AA1', 'MOTIVO DESCARGO');
        $sheet->setCellValue('AB1', 'ONI ASIGNADO');
        $sheet->setCellValue('AC1', 'PLACA');
        $sheet->setCellValue('AD1', 'NUMERO DE EQUIPO');
        $sheet->setCellValue('AE1', 'MODELO');
        $rows = 2;
        foreach ($datosReporte as $data) {
            foreach ($data["groupeddata"] as $activo) {
                if($activo['GARANTIA'] == 1){
                    $garantia = "SI";
                }elseif($activo['GARANTIA'] == 0 && $activo['GARANTIA'] != null){
                    $garantia = "NO";
                }else{
                    $garantia = "";
                }
                if($activo['MANTENIMIENTO'] == 1){
                    $mant = "SI";
                }elseif($activo['MANTENIMIENTO'] == 0 && $activo['MANTENIMIENTO'] != null){
                    $mant = "NO";
                }else{
                    $mant = "";
                }

                $sheet->setCellValue('A' . $rows, trim($activo["CAF"]));
                $sheet->setCellValue('B' . $rows, trim($activo["CLASE"]));
                $sheet->setCellValue('C' . $rows, trim($activo["SUBCLA"]));
                $sheet->setCellValue('D' . $rows, trim($activo["CORRELSC"]));
                $sheet->setCellValue('E' . $rows, trim($activo['NOMADQUISI']));
                $sheet->setCellValue('F' . $rows, $activo['FINGRESO']);
                $sheet->setCellValue('G' . $rows, $activo['FASIGNA']);
                $sheet->setCellValue('H' . $rows, trim($activo['CBTECONT']));
                $sheet->setCellValue('I' . $rows, trim($activo['FACTURA']));
                $sheet->setCellValue('J' . $rows, trim($activo['OBSERVA']));
                $sheet->setCellValue('K' . $rows, trim($activo['NOM_MAR']));
                $sheet->setCellValue('L' . $rows, trim($activo['NOM_PROV']));
                $sheet->setCellValue('M' . $rows, $activo['FECHA_DESC']);
                $sheet->setCellValue('N' . $rows, trim($activo['SERIE']));
                $sheet->setCellValue('O' . $rows, trim($activo["FOLIO_DESC"]));
                $sheet->setCellValue('P' . $rows, $garantia);
                $sheet->setCellValue('Q' . $rows, trim($activo['FINGARANTIA']));
                $sheet->setCellValue('R' . $rows, $mant);
                $sheet->setCellValue('S' . $rows, trim($activo['IP']));
                $sheet->setCellValue('T' . $rows, trim($activo['HDD']));
                $sheet->setCellValue('U' . $rows, trim($activo['RAM']));
                $sheet->setCellValue('V' . $rows, trim($activo['PROCESADOR']));
                $sheet->setCellValue('W' . $rows, trim($activo['SYSDESC']));
                $sheet->setCellValue('X' . $rows, trim($activo['CORRELF1']));
                $sheet->setCellValue('Y' . $rows, "$ ".trim(number_format($activo["VALORAR"], 2, '.', ',')));
                $sheet->setCellValue('Z' . $rows, trim($activo['NOM_ESTA']));
                $sheet->setCellValue('AA' . $rows, trim($activo['DESCRIPCIO']));
                $sheet->setCellValue('AB' . $rows, trim($activo['ONI']));
                $sheet->setCellValue('AC' . $rows, trim($activo['PLACA']));
                $sheet->setCellValue('AD' . $rows, trim($activo['NUMEQUIPO']));
                $sheet->setCellValue('AE' . $rows, trim($activo['NOM_MOD']));
                $rows++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"');
        $writer->save('php://output');
    }

    private function ExcelActivosCentroDeCosto($cCostoSelected, $datosReporte)
    {
        $fileName = trim($cCostoSelected->CCOSTO).' - '.trim($cCostoSelected->NOM_COS);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'CAF');
        $sheet->setCellValue('B1', 'CLASE');
        $sheet->setCellValue('C1', 'SUBCLASE');
        $sheet->setCellValue('D1', 'CORRELATIVO');
        $sheet->setCellValue('E1', 'TIPO ADQ.');
        $sheet->setCellValue('F1', 'FEC. INGRESO.');
        $sheet->setCellValue('G1', 'FEC. ASIG');
        $sheet->setCellValue('H1', 'COMPROB. CTBLE.');
        $sheet->setCellValue('I1', 'FACTURA');
        $sheet->setCellValue('J1', 'OBSERV.');
        $sheet->setCellValue('K1', 'MARCA');
        $sheet->setCellValue('L1', 'NOMBRE PROVEEDOR');
        $sheet->setCellValue('M1', 'FECHA DESCARGO');
        $sheet->setCellValue('N1', 'SERIE');
        $sheet->setCellValue('O1', 'FOLIO/ACTA');
        $sheet->setCellValue('P1', 'GARANTIA');
        $sheet->setCellValue('Q1', 'FIN GARANTIA');
        $sheet->setCellValue('R1', 'MANTENIMIENTO');
        $sheet->setCellValue('S1', 'IP');
        $sheet->setCellValue('T1', 'Disco Duro');
        $sheet->setCellValue('U1', 'Memoria RAM');
        $sheet->setCellValue('V1', 'Procesador');
        $sheet->setCellValue('W1', 'Sistema Operativo');
        $sheet->setCellValue('X1', 'No. AF1');
        $sheet->setCellValue('Y1', 'V.UNITARIO');
        $sheet->setCellValue('Z1', 'ESTADO');
        $sheet->setCellValue('AA1', 'MOTIVO DESCARGO');
        $sheet->setCellValue('AB1', 'ONI ASIGNADO');
        $sheet->setCellValue('AC1', 'PLACA');
        $sheet->setCellValue('AD1', 'NUMERO DE EQUIPO');
        $sheet->setCellValue('AE1', 'MODELO');
        $rows = 2;
        foreach ($datosReporte as $data) {
            foreach ($data["groupeddata"] as $activo) {
                if($activo['GARANTIA'] == 1){
                    $garantia = "SI";
                }else{
                    $garantia = "";
                }
                if($activo['MANTENIMIENTO'] == 1){
                    $mant = "SI";
                }else{
                    $mant = "";
                }
                $sheet->setCellValue('A' . $rows, trim($activo["CAF"]));
                $sheet->setCellValue('B' . $rows, trim($activo["CLASE"]));
                $sheet->setCellValue('C' . $rows, trim($activo["SUBCLA"]));
                $sheet->setCellValue('D' . $rows, trim($activo["CORRELSC"]));
                $sheet->setCellValue('E' . $rows, trim($activo['NOMADQUISI']));
                $sheet->setCellValue('F' . $rows, $activo['FINGRESO']);
                $sheet->setCellValue('G' . $rows, $activo['FASIGNA']);
                $sheet->setCellValue('H' . $rows, trim($activo['CBTECONT']));
                $sheet->setCellValue('I' . $rows, trim($activo['FACTURA']));
                $sheet->setCellValue('J' . $rows, trim($activo['OBSERVA']));
                $sheet->setCellValue('K' . $rows, trim($activo['NOM_MAR']));
                $sheet->setCellValue('L' . $rows, trim($activo['NOM_PROV']));
                $sheet->setCellValue('M' . $rows, $activo['FECHA_DESC']);
                $sheet->setCellValue('N' . $rows, trim($activo['SERIE']));
                $sheet->setCellValue('O' . $rows, trim($activo["FOLIO_DESC"]));
                $sheet->setCellValue('P' . $rows, $garantia);
                $sheet->setCellValue('Q' . $rows, trim($activo['FINGARANTIA']));
                $sheet->setCellValue('R' . $rows, $mant);
                $sheet->setCellValue('S' . $rows, trim($activo['IP']));
                $sheet->setCellValue('T' . $rows, trim($activo['HDD']));
                $sheet->setCellValue('U' . $rows, trim($activo['RAM']));
                $sheet->setCellValue('V' . $rows, trim($activo['PROCESADOR']));
                $sheet->setCellValue('W' . $rows, trim($activo['SYSDESC']));
                $sheet->setCellValue('X' . $rows, trim($activo['CORRELF1']));
                $sheet->setCellValue('Y' . $rows, "$ ".trim(number_format($activo["VALORAR"], 2, '.', ',')));
                $sheet->setCellValue('Z' . $rows, trim($activo['NOM_ESTA']));
                $sheet->setCellValue('AA' . $rows, trim($activo['DESCRIPCIO']));
                $sheet->setCellValue('AB' . $rows, trim($activo['ONI']));
                $sheet->setCellValue('AC' . $rows, trim($activo['PLACA']));
                $sheet->setCellValue('AD' . $rows, trim($activo['NUMEQUIPO']));
                $sheet->setCellValue('AE' . $rows, trim($activo['NOM_MOD']));
                $rows++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"');
        $writer->save('php://output');
    }

    private function PDFErrorGeneral($cCostoSelected)
    {
        $this->load->library('pdf_general');
        $pdf = $this->pdf_general->getInstance();
        $pdf->SetUser($this->session->userdata('username'), $this->validateuser_library->ONIByUser($this->session->userdata('username')));
        $pdf->AddPage('L', 'Letter');
        $pdf->AliasNbPages();
        $pdf->SetWidths(array(20,24,16,20,20,18,50,25,25,15,20));
        $pdf->SetAligns(array('L','L','L','L','L','L','L','L','L','L','C'));
        if ($cCostoSelected) {
            $pdf->SetCCosto($cCostoSelected);
            $pdf->Text(10, 25, trim($cCostoSelected->CCOSTO).' - '.trim($cCostoSelected->NOM_COS));
            $pdf->SetFont('Arial', '', 11);
            $pdf->Text(10, 60, 'Este Centro de Costo no posee bienes asignados para generar un reporte. Si esta informacion no es correcta contacte al administrador del sistema.');
            $pdfString = $pdf->Output(trim($cCostoSelected->CCOSTO).' - '.trim($cCostoSelected->NOM_COS)."_".date('d/m/Y').".pdf", "S");
            $pdfBase64 = base64_encode($pdfString);
            echo 'data:application/pdf;base64,' . $pdfBase64;
        } else {
            $pdf->SetCCosto(null);
            $pdf->SetFont('Arial', '', 11);
            $pdf->Text(10, 60, 'No se ha seleccionado un Centro de Costo.');
            $pdfString = $pdf->Output(trim($cCostoSelected->CCOSTO).' - '.trim($cCostoSelected->NOM_COS)."_".date('d/m/Y').".pdf", "S");
            $pdfBase64 = base64_encode($pdfString);
            echo 'data:application/pdf;base64,' . $pdfBase64;
        }
    }

    private function PDFErrorGeneralControlCalidad()
    {
        $this->load->library('pdf_general');
        $pdf = $this->pdf_general->getInstance();
        $pdf->SetUser($this->session->userdata('username'), $this->validateuser_library->ONIByUser($this->session->userdata('username')));
        $pdf->AddPage('L', 'Letter');
        $pdf->AliasNbPages();
        $pdf->SetWidths(array(20,24,16,20,20,18,50,25,25,15,20));
        $pdf->SetAligns(array('L','L','L','L','L','L','L','L','L','L','C'));
        $pdf->Text(10, 60, 'Los filtros seleccionados no han generado ningun tipo de informacion, si cree que esto es un error intente nuevamente generar el reporte, sino contacte al administrador del sistema.');
        $pdfString = $pdf->Output('ERROR_PDF'.date('d/m/Y').".pdf", "S");
        $pdfBase64 = base64_encode($pdfString);
        echo 'data:application/pdf;base64,' . $pdfBase64;
    }

    private function PDFErrorGeneralResumenControlCalidad()
    {
        $this->load->library('pdf_controlcalidad_resumido');
        $pdf = $this->pdf_controlcalidad_resumido->getInstance();
        $pdf->SetUser($this->session->userdata('username'), $this->validateuser_library->ONIByUser($this->session->userdata('username')));
        $pdf->AddPage('L', 'Letter');
        $pdf->AliasNbPages();
        $pdf->SetWidths(array(20,24,16,20,20,18,50,25,25,15,20));
        $pdf->SetAligns(array('L','L','L','L','L','L','L','L','L','L','C'));
        $pdf->Text(10, 60, 'Los filtros seleccionados no han generado ningun tipo de informacion, si cree que esto es un error intente nuevamente generar el reporte, sino contacte al administrador del sistema.');
        $pdfString = $pdf->Output('ERROR_PDF'.date('d/m/Y').".pdf", "S");
        $pdfBase64 = base64_encode($pdfString);
        echo 'data:application/pdf;base64,' . $pdfBase64;
    }


    private function PDFActivosCentroDeCosto($cCostoSelected, $datosReporte)
    {
        $this->load->library('pdf_general');
        $pdf = $this->pdf_general->getInstance();
        $pdf->SetUser($this->session->userdata('username'), $this->validateuser_library->ONIByUser($this->session->userdata('username')));
        $pdf->AddPage('L', 'Letter');
        $pdf->AliasNbPages();
        $pdf->SetCCosto($cCostoSelected);
        $totalGlobalActivos = 0;
        $montoTotalGlobalActivos = 0;
        $i = 0;
        foreach ($datosReporte as $data) {
            $totalActivos = 0;
            $montoTotalActivos = 0;
            $pdf->SetTitle($data["CLASE_SUBCLASE"]);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Text(10, 25, trim($cCostoSelected->CCOSTO).' - '.trim($cCostoSelected->NOM_COS));
            if ($i == 0) {
                $pdf->Ln(12);
            } else {
                $pdf->Ln(2);
            }
            $pdf->SetWidths(array(253));
            $pdf->SetAligns(array('L'));
            $pdf->RowHeader(array($data["CLASE_SUBCLASE"]));

            foreach ($data["groupeddata"] as $activo) {
                $pdf->SetWidths(array(20,13,15,15,8,15,20,62,29,29,13,18));
                $pdf->SetAligns(array('L','L','C','C','L','L','L','L','L','L','L','R'));
                $totalActivos = $totalActivos + 1;
                $montoTotalActivos = $montoTotalActivos + $activo["VALORAR"];
                $pdf->Row(array(
                    trim($activo["CORRELSC"]),
                    substr(trim($activo["NOMADQUISI"]), 0, 5).".",
                    date("d/m/y", strtotime(trim($activo["FINGRESO"]))),
                    date("d/m/y", strtotime(trim($activo["FASIGNA"]))),
                    trim($activo["CBTECONT"]),
                    trim($activo["FACTURA"]),
                    trim($activo["NOM_MAR"]),
                    trim($activo["NOM_PROV"]),
                    trim($activo["SERIE"]),
                    trim($activo["MOTOR"]),
                    trim($activo["CORRELF1"]),
                    "$ ".trim(number_format($activo["VALORAR"], 2, '.', ','))
                ));
                $pdf->SetWidths(array(10,71,25,62,29,29,13,18));
                $pdf->SetAligns(array('L','L','L','L','L','L','L','L'));
                $pdf->Row(array(
                    "",
                    utf8_decode(trim($activo["DESCRIPC"])),
                    utf8_decode(trim($activo["NOM_MOD"])),
                    $activo["FECHA_DESC"],
                    "",
                    trim($activo["CHASIS"]),
                    "",
                    trim($activo["FOLIO_DESC"]),
                    "",
                    ""
                ));
            }
            $pdf->SetWidths(array(153,102));
            $pdf->SetAligns(array('L','R'));
            $pdf->RowTotal(array("TOTAL DE  ".trim($data["CLASE_SUBCLASE"])." : ".$totalActivos,"MONTO TOTALIZADO : "."$ ".number_format($montoTotalActivos, 2, '.', ',')));
            $totalGlobalActivos = $totalGlobalActivos + $totalActivos;
            $montoTotalGlobalActivos =  $montoTotalGlobalActivos + $montoTotalActivos;
            $i++;
        }
        $pdf->Ln(2);
        $pdf->RowTotal(array(
            "TOTAL GLOBAL DE BIENES : "."           ".$totalGlobalActivos,
            "MONTO GLOBAL : "."$ ".number_format($montoTotalGlobalActivos, 2, '.', ',')
        ));
        $pdfString = $pdf->Output(trim($cCostoSelected->CCOSTO).' - '.trim($cCostoSelected->NOM_COS)."_".date('d/m/Y').".pdf", "S");
        $pdfBase64 = base64_encode($pdfString);
        echo 'data:application/pdf;base64,' . $pdfBase64;
    }

    public function PDFResumen($ccosto, $unidadesAscritas, $clase, $subclase, $estado, $motivo, $groupBy)
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $tituloReporte = "";
            $whereSentence = array();
            $this->load->library('pdf_generador');
            $pdf = $this->pdf_generador->getInstance();
            $pdf->SetUser($this->session->userdata('username'), $this->validateuser_library->ONIByUser($this->session->userdata('username')));
            $pdf->SetAdscritas($unidadesAscritas);

            if (!empty($ccosto) && $ccosto != "null") {
                $whereSentence['T_ACTFIJOS.CCOSTO'] = $ccosto;
                $get = $this->CentrosCostos_model->getById($ccosto);
                $pdf->SetCCosto($get ->NOM_COS);
            } else {
                $pdf->SetCCosto("TODOS");
            }

            if (!empty($clase) && $clase != "null") {
                $whereSentence['T_ACTFIJOS.CLASE'] = $clase;
                $get = $this->Clases_model->getById($clase);
                $pdf->SetClase($get->NOM_CLAS);
            } else {
                $pdf->SetClase("TODAS");
            }

            if (!empty($subclase) && $subclase != "null") {
                $whereSentence['T_ACTFIJOS.SUBCLA'] = $subclase;
                $get = $this->SubClases_model->getById($subclase, $clase);
                $pdf->SetSubClase($get->NOM_SUB);
            } else {
                $pdf->SetSubClase("TODAS");
            }

            if (!empty($estado) && $estado != "null") {
                $whereSentence['T_ACTFIJOS.ESTADO'] = $estado;
                $get = $this->Estados_model->getById($estado);
                $pdf->SetEstado($get->NOM_ESTA);
            } else {
                $pdf->SetEstado("TODOS");
            }

            if (!empty($motivo) &&  $motivo != "null") {
                $whereSentence['T_ACTFIJOS.MOTIVO_DES'] = $motivo;
                $get = $this->Actas_model->getById($motivo);
                $pdf->SetMotivoDescargo($get->DESCRIPCIO);
            } else {
                $pdf->SetMotivoDescargo("TODAS");
            }

        
            switch ($groupBy) {
                    case "CS":
                        $pdf->SetTitle("RESUMEN POR CLASE Y SUBCLASE");
                        $pdf->AddPage('P', 'Letter');
                        $pdf->AliasNbPages();
                        $data = $this->ActivosFijos_model->TotalizadoByClaseSubClase($whereSentence, $unidadesAscritas);
                        $claseActual = "";
                        $tituloClaseActual = "";
                        $sumas = 0;
                        $total = 0;
                        $totalSubClase = 0;
                        $sumasSubClase = 0;
                        foreach ($data as $clase) {
                            $total += $clase->TOTAL_BIENES;
                            $sumas += $clase->SUMAS_BIENES;
                            if ($claseActual == "") {
                                $pdf->SetWidths(array(100));
                                $pdf->SetAligns(array('L'));
                                $pdf->Row(array($clase->CLASE.' - '.$clase->NOM_CLAS));
                                $pdf->SetWidths(array(100,48,48));
                                $pdf->SetAligns(array('L','R','R'));
                                $pdf->Row(array('', 'TOTAL DE BIENES', 'VALOR TOTAL'));
                                $tituloClaseActual = $clase->CLASE.' - '.$clase->NOM_CLAS;
                            }
                            
                            if ($clase->CLASE != $claseActual && $claseActual != "") {

                                /*Totales de la Clase Anterior*/
                                $pdf->SetWidths(array(100,48,48));
                                $pdf->SetAligns(array('L','R','R'));
                                $pdf->Row(array('TOTAL DE '.$tituloClaseActual, 'CANT. TOTAL', 'MONTO TOTAL'));
                                $pdf->Row(array('', number_format($totalSubClase, 0, '.', ','), "$ ".number_format($sumasSubClase, 2, '.', ',')));

                                $pdf->Ln(5);
                                /*Empieza Nueva Clase*/
                                $totalSubClase = 0;
                                $sumasSubClase = 0;
                                $pdf->SetWidths(array(100));
                                $pdf->SetAligns(array('L'));
                                $tituloClaseActual = $clase->CLASE.' - '.$clase->NOM_CLAS;
                                $pdf->Row(array($clase->CLASE.' - '.$clase->NOM_CLAS));
                                $pdf->SetWidths(array(100,48,48));
                                $pdf->SetAligns(array('L','R','R'));
                                $pdf->Row(array('', 'TOTAL DE BIENES', 'VALOR TOTAL'));
                            }

                            $pdf->SetFont('Arial', '', 8);
                            $pdf->Row(array($clase->SUBCLA.' - '.$clase->NOM_SUB, number_format($clase->TOTAL_BIENES, 0, '.', ','),  "$ ".number_format($clase->SUMAS_BIENES, 2, '.', ',')));
                            $totalSubClase += $clase->TOTAL_BIENES;
                            $sumasSubClase += $clase->SUMAS_BIENES;
                            $claseActual = $clase->CLASE;
                            $pdf->SetFont('Arial', 'B', 8);
                        };
                        $pdf->Ln(5);
                        $pdf->SetWidths(array(100,48,48));
                        $pdf->SetAligns(array('L','R','R'));
                        $pdf->RowTotal(array('TOTALES', number_format($total, 0, '.', ','), "$ ".number_format($sumas, 2, '.', ',')));
                        $tituloReporte = "RESUMEN_POR_CLASE_SUBCLASE_";
                    break;
        
                    case "CC":
                        $pdf->SetTitle("RESUMEN POR CENTRO DE COSTO");
                        $pdf->AddPage('P', 'Letter');
                        $pdf->AliasNbPages();
                        $data = $this->ActivosFijos_model->TotalizadoByCCosto($whereSentence, $unidadesAscritas);
                        $pdf->SetWidths(array(25,100,35,35));
                        $pdf->SetAligns(array('L','L','R','R'));
                        $pdf->Row(array('CODIGO', 'CENTRO DE COSTO', 'TOTAL DE BIENES', 'MONTO TOTAL'));
                        $pdf->SetFont('Arial', '', 8);
                        $total = 0;
                        $sumas = 0;
                        foreach ($data as $objeto) {
                            $pdf->Row(array($objeto->CCOSTO, $objeto->NOM_COS, number_format($objeto->TOTAL_BIENES, 0, '.', ','),  "$ ".number_format($objeto->SUMAS_BIENES, 2, '.', ',')));
                            $total += $objeto->TOTAL_BIENES;
                            $sumas += $objeto->SUMAS_BIENES;
                        }
                        $pdf->SetWidths(array(125,35,35));
                        $pdf->SetAligns(array('L','R','R'));
                        $pdf->SetFont('Arial', 'B', 9);
                        $pdf->RowTotal(array('TOTALES  ', number_format($total, 0, '.', ','), "$ ".number_format($sumas, 2, '.', ',')));
                        $tituloReporte = "RESUMEN_POR_CENTRO_DE_COSTO_";
                    break;

                    case "CCD":
                        $pdf->SetTitle("RESUMEN POR CENTRO DE COSTO DONDE FUE DESCARGADO");
                        $pdf->AddPage('P', 'Letter');
                        $pdf->AliasNbPages();
                        $data = $this->ActivosFijos_model->TotalizadoByCCostoDescargado($whereSentence, $unidadesAscritas);
                        $pdf->SetWidths(array(25,100,35,35));
                        $pdf->SetAligns(array('L','L','R','R'));
                        $pdf->Row(array('CODIGO', 'CENTRO DE COSTO', 'TOTAL DE BIENES', 'MONTO TOTAL'));
                        $pdf->SetFont('Arial', '', 8);
                        $total = 0;
                        $sumas = 0;
                        foreach ($data as $objeto) {
                            $pdf->Row(array($objeto->CC_DESCARG, $objeto->NOM_COS, number_format($objeto->TOTAL_BIENES, 0, '.', ','),  "$ ".number_format($objeto->SUMAS_BIENES, 2, '.', ',')));
                            $total += $objeto->TOTAL_BIENES;
                            $sumas += $objeto->SUMAS_BIENES;
                        }
                        $pdf->SetWidths(array(125,35,35));
                        $pdf->SetAligns(array('L','R','R'));
                        $pdf->SetFont('Arial', 'B', 9);
                        $pdf->RowTotal(array('TOTALES  ', number_format($total, 0, '.', ','), "$ ".number_format($sumas, 2, '.', ',')));
                        $tituloReporte = "RESUMEN_POR_CENTRO_DE_COSTO_DESCARGADO";
                    break;

                
                    case "ETDO":
                        $pdf->SetTitle("RESUMEN POR ESTADOS DEL BIEN");
                        $pdf->AddPage('P', 'Letter');
                        $pdf->AliasNbPages();
                        $data = $this->ActivosFijos_model->TotalizadoByEstado($whereSentence, $unidadesAscritas);
                        $pdf->SetWidths(array(25,100,35,35));
                        $pdf->SetAligns(array('L','L','R','R'));
                        $pdf->Row(array('CODIGO', 'ESTADO', 'TOTAL DE BIENES', 'MONTO TOTAL'));
                        $pdf->SetFont('Arial', '', 8);
                        $total = 0;
                        $sumas = 0;
                        foreach ($data as $objeto) {
                            $pdf->Row(array($objeto->ESTADO, $objeto->NOM_ESTA, number_format($objeto->TOTAL_BIENES, 0, '.', ','),  "$ ".number_format($objeto->SUMAS_BIENES, 2, '.', ',')));
                            $total += $objeto->TOTAL_BIENES;
                            $sumas += $objeto->SUMAS_BIENES;
                        }
                        $pdf->SetWidths(array(125,35,35));
                        $pdf->SetAligns(array('L','R','R'));
                        $pdf->SetFont('Arial', 'B', 9);
                        $pdf->RowTotal(array('TOTALES  ', number_format($total, 0, '.', ','), "$ ".number_format($sumas, 2, '.', ',')));
                        $tituloReporte = "RESUMEN_POR_ESTADO_DEL_BIEN_";
                    break;
                }

            $pdfString = $pdf->Output($tituloReporte.' '.date('d/m/Y').".pdf", "S");
            $pdfBase64 = base64_encode($pdfString);
            echo 'data:application/pdf;base64,' . $pdfBase64;
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function PDFDetallado($ccosto, $unidadesAscritas, $clase, $subclase, $estado, $motivo, $groupBy)
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $tituloReporte = "";
            $whereSentence = array();
            $this->load->library('pdf_generador');
            $pdf = $this->pdf_generador->getInstance();
            $pdf->SetUser($this->session->userdata('username'), $this->validateuser_library->ONIByUser($this->session->userdata('username')));
            $pdf->SetAdscritas($unidadesAscritas);

            if (!empty($ccosto) && $ccosto != "null") {
                $whereSentence['T_ACTFIJOS.CCOSTO'] = $ccosto;
                $get = $this->CentrosCostos_model->getById($ccosto);
                $pdf->SetCCosto($get ->NOM_COS);
            } else {
                $pdf->SetCCosto("TODOS");
            }

            if (!empty($clase) && $clase != "null") {
                $whereSentence['T_ACTFIJOS.CLASE'] = $clase;
                $get = $this->Clases_model->getById($clase);
                $pdf->SetClase($get->NOM_CLAS);
            } else {
                $pdf->SetClase("TODAS");
            }

            if (!empty($subclase) && $subclase != "null") {
                $whereSentence['T_ACTFIJOS.SUBCLA'] = $subclase;
                $get = $this->SubClases_model->getById($subclase, $clase);
                $pdf->SetSubClase($get->NOM_SUB);
            } else {
                $pdf->SetSubClase("TODAS");
            }

            if (!empty($estado) && $estado != "null") {
                $whereSentence['T_ACTFIJOS.ESTADO'] = $estado;
                $get = $this->Estados_model->getById($estado);
                $pdf->SetEstado($get->NOM_ESTA);
            } else {
                $pdf->SetEstado("TODOS");
            }

            if (!empty($motivo) &&  $motivo != "null") {
                $whereSentence['T_ACTFIJOS.MOTIVO_DES'] = $motivo;
                $get = $this->Actas_model->getById($motivo);
                $pdf->SetMotivoDescargo($get->DESCRIPCIO);
            } else {
                $pdf->SetMotivoDescargo("TODAS");
            }

    
            switch ($groupBy) {
                case "CS":
                    $totalReporte = 0;
                    $sumasReporte = 0;
                    $pdf->SetTitle("DETALLE POR CLASE Y SUBCLASE");
                    $pdf->AddPage('P', 'Letter');
                    $pdf->AliasNbPages();
                    $data = $this->ActivosFijos_model->DetalladoByClaseSubClase($whereSentence, $unidadesAscritas);
                    $array = json_decode(json_encode($data), true);
                    $groupedArray = $this->groupArray($array, "CENTRO_COSTO");
                    $cCostoActual = "";
                    foreach ($groupedArray as $data) {
                        $cCostoActual = $data["CENTRO_COSTO"];
                        $pdf->SetWidths(array(100));
                        $pdf->SetAligns(array('L'));
                        $pdf->Row(array('CENTRO DE COSTO : '.$data["CENTRO_COSTO"]));

                        $claseActual = "";
                        $tituloClaseActual = "";
                        $sumas = 0;
                        $total = 0;
                        $totalSubClase = 0;
                        $sumasSubClase = 0;

                        foreach ($data["groupeddata"] as $clase) {
                            $total += $clase["TOTAL_BIENES"];
                            $sumas += $clase["SUMAS_BIENES"];

                            if ($claseActual == "") {
                                $pdf->SetWidths(array(100));
                                $pdf->SetAligns(array('L'));
                                $pdf->Row(array($clase["CLASE"].' - '.$clase["NOM_CLAS"]));
                                $pdf->SetWidths(array(100,48,48));
                                $pdf->SetAligns(array('L','R','R'));
                                $pdf->Row(array('', 'TOTAL DE BIENES', 'VALOR TOTAL'));
                                $tituloClaseActual = $clase["CLASE"].' - '.$clase["NOM_CLAS"];
                            }
                            
                            if ($clase["CLASE"] != $claseActual && $claseActual != "") {

                                /*Totales de la Clase Anterior*/
                                $pdf->SetWidths(array(100,48,48));
                                $pdf->SetAligns(array('L','R','R'));
                                $pdf->Row(array('TOTAL DE '.$tituloClaseActual, 'CANT. TOTAL', 'MONTO TOTAL'));
                                $pdf->Row(array('', number_format($totalSubClase, 0, '.', ','), "$ ".number_format($sumasSubClase, 2, '.', ',')));

                                $pdf->Ln(5);
                                /*Empieza Nueva Clase*/
                                $totalSubClase = 0;
                                $sumasSubClase = 0;
                                $pdf->SetWidths(array(100));
                                $pdf->SetAligns(array('L'));
                                $tituloClaseActual = $clase["CLASE"].' - '.$clase["NOM_CLAS"];
                                $pdf->Row(array($clase["CLASE"].' - '.$clase["NOM_CLAS"]));
                                $pdf->SetWidths(array(100,48,48));
                                $pdf->SetAligns(array('L','R','R'));
                                $pdf->Row(array('', 'TOTAL DE BIENES', 'VALOR TOTAL'));
                            }

                            $pdf->SetFont('Arial', '', 8);
                            $pdf->Row(array($clase["SUBCLA"].' - '.$clase["NOM_SUB"], number_format($clase["TOTAL_BIENES"], 0, '.', ','),  "$ ".number_format($clase["SUMAS_BIENES"], 2, '.', ',')));
                            $totalSubClase += $clase["TOTAL_BIENES"];
                            $sumasSubClase += $clase["SUMAS_BIENES"];
                            $claseActual = $clase["CLASE"];
                            $pdf->SetFont('Arial', 'B', 8);
                        }

                        
                        $pdf->Ln(5);
                        $pdf->SetWidths(array(100,48,48));
                        $pdf->SetAligns(array('L','R','R'));
                        $pdf->RowTotal(array('TOTALES '.$cCostoActual, number_format($total, 0, '.', ','), "$ ".number_format($sumas, 2, '.', ',')));
                        $pdf->Ln(5);
                        $totalReporte += $total;
                        $sumasReporte += $sumas;
                    }
                        $pdf->Ln(5);
                        $pdf->SetWidths(array(100,48,48));
                        $pdf->SetAligns(array('L','R','R'));
                        $pdf->RowTotal(array('TOTALES', number_format($totalReporte, 0, '.', ','), "$ ".number_format($sumasReporte, 2, '.', ',')));
                        $tituloReporte = "DETALLE_POR_CLASE_SUBCLASE_";
                break;
    
                case "CC":
                    $pdf->SetTitle("DETALLE POR CENTRO DE COSTO");
                    $pdf->AddPage('P', 'Letter');
                    $pdf->AliasNbPages();
                    $data = $this->ActivosFijos_model->TotalizadoByCCosto($whereSentence, $unidadesAscritas);
                    $pdf->SetWidths(array(25,100,35,35));
                    $pdf->SetAligns(array('L','L','R','R'));
                    $pdf->Row(array('CODIGO', 'CENTRO DE COSTO', 'TOTAL DE BIENES', 'MONTO TOTAL'));
                    $pdf->SetFont('Arial', '', 8);
                    $total = 0;
                    $sumas = 0;
                    foreach ($data as $objeto) {
                        $pdf->Row(array($objeto->CCOSTO, $objeto->NOM_COS, number_format($objeto->TOTAL_BIENES, 0, '.', ','),  "$ ".number_format($objeto->SUMAS_BIENES, 2, '.', ',')));
                        $total += $objeto->TOTAL_BIENES;
                        $sumas += $objeto->SUMAS_BIENES;
                    }
                    $pdf->SetWidths(array(125,35,35));
                    $pdf->SetAligns(array('L','R','R'));
                    $pdf->SetFont('Arial', 'B', 9);
                    $pdf->RowTotal(array('TOTALES  ', number_format($total, 0, '.', ','), "$ ".number_format($sumas, 2, '.', ',')));
                    $tituloReporte = "RESUMEN_POR_CENTRO_DE_COSTO_";
                break;


                case "CCD":
                    $pdf->SetTitle("RESUMEN POR CENTRO DE COSTO DONDE FUE DESCARGADO");
                    $pdf->AddPage('P', 'Letter');
                    $pdf->AliasNbPages();
                    $data = $this->ActivosFijos_model->TotalizadoByCCostoDescargado($whereSentence, $unidadesAscritas);
                    $pdf->SetWidths(array(25,100,35,35));
                    $pdf->SetAligns(array('L','L','R','R'));
                    $pdf->Row(array('CODIGO', 'CENTRO DE COSTO', 'TOTAL DE BIENES', 'MONTO TOTAL'));
                    $pdf->SetFont('Arial', '', 8);
                    $total = 0;
                    $sumas = 0;
                    foreach ($data as $objeto) {
                        $pdf->Row(array($objeto->CC_DESCARG, $objeto->NOM_COS, number_format($objeto->TOTAL_BIENES, 0, '.', ','),  "$ ".number_format($objeto->SUMAS_BIENES, 2, '.', ',')));
                        $total += $objeto->TOTAL_BIENES;
                        $sumas += $objeto->SUMAS_BIENES;
                    }
                    $pdf->SetWidths(array(125,35,35));
                    $pdf->SetAligns(array('L','R','R'));
                    $pdf->SetFont('Arial', 'B', 9);
                    $pdf->RowTotal(array('TOTALES  ', number_format($total, 0, '.', ','), "$ ".number_format($sumas, 2, '.', ',')));
                    $tituloReporte = "RESUMEN_POR_CENTRO_DE_COSTO_DESCARGADO";
                break;


                case "ETDO":

                    $totalReporte = 0;
                    $sumasReporte = 0;
                    $pdf->SetTitle("DETALLE POR ESTADOS DEL BIEN");
                    $pdf->AddPage('P', 'Letter');
                    $pdf->AliasNbPages();
                    $data = $this->ActivosFijos_model->DetalladoByEstado($whereSentence, $unidadesAscritas);
                    $array = json_decode(json_encode($data), true);
                    $groupedArray = $this->groupArray($array, "CENTRO_COSTO");
                    $cCostoActual = "";
                    foreach ($groupedArray as $data) {
                        $cCostoActual = $data["CENTRO_COSTO"];
                        $pdf->SetWidths(array(100));
                        $pdf->SetAligns(array('L'));
                        $pdf->Row(array('CENTRO DE COSTO : '.$data["CENTRO_COSTO"]));

                        $estadoActual = "";
                        $tituloEstadoActual = "";
                        $sumas = 0;
                        $total = 0;
                        $totalSubEstado = 0;
                        $sumasSubEstado = 0;

                        foreach ($data["groupeddata"] as $estado) {
                            $total += $estado["TOTAL_BIENES"];
                            $sumas += $estado["SUMAS_BIENES"];

                            if ($estadoActual == "") {
                                $pdf->SetWidths(array(100,48,48));
                                $pdf->SetAligns(array('L','R','R'));
                                $pdf->Row(array('', 'TOTAL DE BIENES', 'VALOR TOTAL'));
                                $tituloEstadoActual = $estado["ESTADO"].' - '.$estado["NOM_ESTA"];
                                $pdf->Ln(2);
                            }
                            
                            if ($estado["ESTADO"] != $estadoActual && $estadoActual != "") {
                                $pdf->Ln(5);
                                /*Empieza Nueva Estado*/
                                $totalSubEstado = 0;
                                $sumasSubEstado = 0;
                                $pdf->SetWidths(array(100,48,48));
                                $pdf->SetAligns(array('L','R','R'));
                                $pdf->Row(array('', 'TOTAL DE BIENES', 'VALOR TOTAL'));
                            }

                            $pdf->SetFont('Arial', '', 8);
                            $pdf->Row(array($estado["NOM_ESTA"], number_format($estado["TOTAL_BIENES"], 0, '.', ','),  "$ ".number_format($estado["SUMAS_BIENES"], 2, '.', ',')));
                            $totalSubEstado += $estado["TOTAL_BIENES"];
                            $sumasSubEstado += $estado["SUMAS_BIENES"];
                            $estadoActual = $estado["ESTADO"];
                            $pdf->SetFont('Arial', 'B', 8);
                        }

                        
                        $pdf->Ln(5);
                        $pdf->SetWidths(array(100,48,48));
                        $pdf->SetAligns(array('L','R','R'));
                        $pdf->RowTotal(array('TOTALES '.$cCostoActual, number_format($total, 0, '.', ','), "$ ".number_format($sumas, 2, '.', ',')));
                        $pdf->Ln(5);
                        $totalReporte += $total;
                        $sumasReporte += $sumas;
                    }
                        $pdf->Ln(5);
                        $pdf->SetWidths(array(100,48,48));
                        $pdf->SetAligns(array('L','R','R'));
                        $pdf->RowTotal(array('TOTALES', number_format($totalReporte, 0, '.', ','), "$ ".number_format($sumasReporte, 2, '.', ',')));
                        $tituloReporte = "DETALLE_POR_ESTADO_DEL_BIEN_";
            }

            $pdfString = $pdf->Output($tituloReporte.' '.date('d/m/Y').".pdf", "S");
            $pdfBase64 = base64_encode($pdfString);
            echo 'data:application/pdf;base64,' . $pdfBase64;
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function ReporteActivoFijoControlCalidad()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $whereSentence = array();
            $ccosto = xss_clean($this->input->post('cCosto'));
            $ccostoDescargo = xss_clean($this->input->post('centroCostoDescargado'));
            $estados = xss_clean($this->input->post('estados'));
            $motivo = xss_clean($this->input->post('acta'));
            $AF1 = xss_clean($this->input->post('af1'));
            $docAsgina = xss_clean($this->input->post('docAsgina'));
            $formato = xss_clean($this->input->post('formato'));
            $user = $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            
            if($user === 'validacion4' && $ccosto == ""){
                $costo = $this->validateuser_library->returnCcosto($is_valid_token['data']->user_name);
                if ($ccostoDescargo == 0) {
                    $whereSentence['T_ACTFIJOS.CCOSTO'] = $costo;
                }
    
                if ($ccostoDescargo == 1) {
                    $whereSentence['T_ACTFIJOS.CCOSTO'] = null;
                    $whereSentence['T_ACTFIJOS.CC_DESCARG'] = $costo;
                }
                
            }
            if (!empty($ccosto) && $ccosto != "null" && $ccostoDescargo == 0) {
                $whereSentence['T_ACTFIJOS.CCOSTO'] = $ccosto;
            }

            if (!empty($ccosto) && $ccosto != "null" && $ccostoDescargo == 1) {
                $whereSentence['T_ACTFIJOS.CCOSTO'] = null;
                $whereSentence['T_ACTFIJOS.CC_DESCARG'] = $ccosto;
            }

            $parseEstados = json_decode($estados);
            if (count($parseEstados) > 0) {
                $whereSentence['T_ACTFIJOS.ESTADO'] = $parseEstados;
            }

           if (!empty($motivo) &&  $motivo != "null") {
                $whereSentence['T_ACTFIJOS.MOTIVO_DES'] = $motivo;
            }

            if (!empty($AF1) &&  $AF1 != "null") {
                $whereSentence['T_ACTFIJOS.CORRELF1'] = $AF1;
            }

            if (!empty($docAsgina) &&  $docAsgina != "null") {
                $whereSentence['T_ACTFIJOS.DOC_ASIGNA'] = $docAsgina;
            } 
            
            $clases = array();
            $subclases = array();
            $activos = array();
        
            $clasesSelected = $this->ActivosFijos_model->getClaseByMultiple($whereSentence);
            foreach ($clasesSelected as $clase) {
                array_push($clases, $clase->CLASE);
            }
                
            if (count($clases) == 0) {
                if($formato == 'R'){
                    return $this->PDFErrorGeneralResumenControlCalidad();
                    exit();
                } else if ($formato == 'D'){
                    return $this->PDFErrorGeneralControlCalidad();
                    exit();
                }
            }

            
            $subclasesSelected = $this->ActivosFijos_model->getSubClaseByClaseAndMultiple($whereSentence, $clases);
            foreach ($subclasesSelected as $subclase) {
                array_push($subclases, $subclase->SUBCLA);
            }

            if (count($subclases) == 0) {
                if($formato == 'R'){
                    return $this->PDFErrorGeneralResumenControlCalidad();
                    exit();
                } else if ($formato == 'D'){
                    return $this->PDFErrorGeneralControlCalidad();
                    exit();
                }
            }

            $activosSelected = $this->ActivosFijos_model->getActivoFijoByClaseSubClaseMultiple($clases, $subclases, $whereSentence);
            foreach ($subclasesSelected as $subclase) {
                array_push($subclases, $subclase->SUBCLA);
            }
    
           $array = json_decode(json_encode($activosSelected), true);
           $groupedArray = $this->groupArray($array, "CLASE_SUBCLASE");
            
           if($formato == 'R'){
            $this->PDFControlCalidadResumen($groupedArray, $whereSentence);
           } else if ($formato == 'D'){
            $this->PDFControlCalidad($groupedArray, $whereSentence);
           }
           

        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function ExcelControlCalidad($request, $token)
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($token);
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {

            $outBase64 = base64_decode($request);
            $objRequest = json_decode($outBase64, false);
            
            $whereSentence = array();
            $ccosto = xss_clean($objRequest->cCosto);
            $ccostoDescargo = xss_clean($objRequest->centroCostoDescargado);
            $estados = xss_clean($objRequest->estados);
            $motivo = xss_clean($objRequest->acta);
            $AF1 = xss_clean($objRequest->af1);
            $docAsgina = xss_clean($objRequest->docAsgina);
            $user = $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            
            if (!empty($ccosto) && $ccosto != "null" && $ccostoDescargo == 0) {
                $whereSentence['T_ACTFIJOS.CCOSTO'] = $ccosto;
            }

            if (!empty($ccosto) && $ccosto != "null" && $ccostoDescargo == 1) {
                $whereSentence['T_ACTFIJOS.CCOSTO'] = null;
                $whereSentence['T_ACTFIJOS.CC_DESCARG'] = $ccosto;
            }

            $parseEstados = json_decode($estados);
            if (count($parseEstados) > 0) {
                $whereSentence['T_ACTFIJOS.ESTADO'] = $parseEstados;
            }

           if (!empty($motivo) &&  $motivo != "null") {
                $whereSentence['T_ACTFIJOS.MOTIVO_DES'] = $motivo;
            }

            if (!empty($AF1) &&  $AF1 != "null") {
                $whereSentence['T_ACTFIJOS.CORRELF1'] = $AF1;
            }

            if (!empty($docAsgina) &&  $docAsgina != "null") {
                $whereSentence['T_ACTFIJOS.DOC_ASIGNA'] = $docAsgina;
            } 
            
            $clases = array();
            $subclases = array();
            $activos = array();
        
            $clasesSelected = $this->ActivosFijos_model->getClaseByMultiple($whereSentence);
            foreach ($clasesSelected as $clase) {
                array_push($clases, $clase->CLASE);
            }
                
            if (count($clases) == 0) {
                return $this->PDFErrorGeneralControlCalidad();
                exit();
            }

            
            $subclasesSelected = $this->ActivosFijos_model->getSubClaseByClaseAndMultiple($whereSentence, $clases);
            foreach ($subclasesSelected as $subclase) {
                array_push($subclases, $subclase->SUBCLA);
            }

           if (count($subclases) == 0) {
                return $this->PDFErrorGeneralControlCalidad($ccosto);
                exit();
            }
            
            $activosSelected = $this->ActivosFijos_model->getActivoFijoByClaseSubClaseMultiple($clases, $subclases, $whereSentence);
            foreach ($subclasesSelected as $subclase) {
                array_push($subclases, $subclase->SUBCLA);
            }
    
           $array = json_decode(json_encode($activosSelected), true);
           $groupedArray = $this->groupArray($array, "CLASE_SUBCLASE");
            
           
            $this->ExcelActivoControlDeCalidad($groupedArray);
            
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    private function ExcelActivoControlDeCalidad($datosReporte)
    {
        $fileName = date('d/m/Y').'_CONTROL_DE_CALIDAD';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'CAF');
        $sheet->setCellValue('B1', 'CLASE');
        $sheet->setCellValue('C1', 'SUBCLASE');
        $sheet->setCellValue('D1', 'CORRELATIVO');
        $sheet->setCellValue('E1', 'TIPO ADQ.');
        $sheet->setCellValue('F1', 'FEC. INGRESO.');
        $sheet->setCellValue('G1', 'FEC. ASIG');
        $sheet->setCellValue('H1', 'COMPROB. CTBLE.');
        $sheet->setCellValue('I1', 'FACTURA');
        $sheet->setCellValue('J1', 'OBSERV.');
        $sheet->setCellValue('K1', 'MARCA');
        $sheet->setCellValue('L1', 'NOMBRE PROVEEDOR');
        $sheet->setCellValue('M1', 'FECHA DESCARGO');
        $sheet->setCellValue('N1', 'SERIE');
        $sheet->setCellValue('O1', 'FOLIO/ACTA');
        $sheet->setCellValue('P1', 'MOTOR');
        $sheet->setCellValue('Q1', 'CHASIS');
        $sheet->setCellValue('R1', 'No. AF1');
        $sheet->setCellValue('S1', 'V.UNITARIO');
        $sheet->setCellValue('T1', 'ESTADO');
        $sheet->setCellValue('U1', 'MOTIVO DESCARGO');
        $sheet->setCellValue('V1', 'ONI ASIGNADO');
        $sheet->setCellValue('W1', 'PLACA');
        $sheet->setCellValue('X1', 'NUMERO DE EQUIPO');
        $sheet->setCellValue('Z1', 'MODELO');
        $rows = 2;
        foreach ($datosReporte as $data) {
            foreach ($data["groupeddata"] as $activo) {
                $sheet->setCellValue('A' . $rows, trim($activo["CAF"]));
                $sheet->setCellValue('B' . $rows, trim($activo["CLASE"]));
                $sheet->setCellValue('C' . $rows, trim($activo["SUBCLA"]));
                $sheet->setCellValue('D' . $rows, trim($activo["CORRELSC"]));
                $sheet->setCellValue('E' . $rows, trim($activo['NOMADQUISI']));
                $sheet->setCellValue('F' . $rows, $activo['FINGRESO']);
                $sheet->setCellValue('G' . $rows, $activo['FASIGNA']);
                $sheet->setCellValue('H' . $rows, trim($activo['CBTECONT']));
                $sheet->setCellValue('I' . $rows, trim($activo['FACTURA']));
                $sheet->setCellValue('J' . $rows, trim($activo['OBSERVA']));
                $sheet->setCellValue('K' . $rows, trim($activo['NOM_MAR']));
                $sheet->setCellValue('L' . $rows, trim($activo['NOM_PROV']));
                $sheet->setCellValue('M' . $rows, $activo['FECHA_DESC']);
                $sheet->setCellValue('N' . $rows, trim($activo['SERIE']));
                $sheet->setCellValue('O' . $rows, trim($activo["FOLIO_DESC"]));
                $sheet->setCellValue('P' . $rows, trim($activo['MOTOR']));
                $sheet->setCellValue('Q' . $rows, trim($activo['CHASIS']));
                $sheet->setCellValue('R' . $rows, trim($activo['CORRELF1']));
                $sheet->setCellValue('S' . $rows, "$ ".trim(number_format($activo["VALORAR"], 2, '.', ',')));
                $sheet->setCellValue('T' . $rows, trim($activo['NOM_ESTA']));
                $sheet->setCellValue('U' . $rows, trim($activo['DESCRIPCIO']));
                $sheet->setCellValue('V' . $rows, trim($activo['ONI']));
                $sheet->setCellValue('W' . $rows, trim($activo['PLACA']));
                $sheet->setCellValue('X' . $rows, trim($activo['NUMEQUIPO']));
                $sheet->setCellValue('Z' . $rows, trim($activo['NOM_MOD']));
                $rows++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"');
        $writer->save('php://output');
    }
    
    private function PDFControlCalidad($datosReporte,$whereSentence)
    {
        $this->load->library('pdf_controlcalidad');
        $pdf = $this->pdf_controlcalidad->getInstance();
        $pdf->SetUser($this->session->userdata('username'), $this->validateuser_library->ONIByUser($this->session->userdata('username')));
        $pdf->AddPage('L', 'Letter');
        $pdf->AliasNbPages();
        $totalGlobalActivos = 0;
        $montoTotalGlobalActivos = 0;
        $i = 0;
        foreach ($datosReporte as $data) {
            $totalActivos = 0;
            $montoTotalActivos = 0;
            $pdf->SetTitle($data["CLASE_SUBCLASE"]);
            $pdf->SetFont('Arial', 'B', 9);
            if ($i == 0) {
                $pdf->Ln(12);
            } else {
                $pdf->Ln(2);
            }
            $pdf->SetWidths(array(253));
            $pdf->SetAligns(array('L'));
            $pdf->RowHeader(array($data["CLASE_SUBCLASE"]));

            foreach ($data["groupeddata"] as $activo) {
                $pdf->SetWidths(array(20,13,15,15,8,15,20,62,29,29,13,18));
                $pdf->SetAligns(array('L','L','C','C','L','L','L','L','L','L','L','R'));
                $totalActivos = $totalActivos + 1;
                $montoTotalActivos = $montoTotalActivos + $activo["VALORAR"];
                $pdf->Row(array(
                    trim($activo["CORRELSC"]),
                    substr(trim($activo["NOMADQUISI"]), 0, 5).".",
                    date("d/m/y", strtotime(trim($activo["FINGRESO"]))),
                    date("d/m/y", strtotime(trim($activo["FASIGNA"]))),
                    trim($activo["CBTECONT"]),
                    trim($activo["FACTURA"]),
                    trim($activo["NOM_MAR"]),
                    trim($activo["NOM_PROV"]),
                    trim($activo["SERIE"]),
                    trim($activo["MOTOR"]),
                    trim($activo["CORRELF1"]),
                    "$ ".trim(number_format($activo["VALORAR"], 2, '.', ','))
                ));
                $pdf->SetWidths(array(10,71,25,62,29,29,13,18));
                $pdf->SetAligns(array('L','L','L','L','L','L','L','L'));
                $pdf->Row(array(
                    "",
                    utf8_decode(trim($activo["DESCRIPC"])),
                    utf8_decode(trim($activo["NOM_MOD"])),
                    $activo["FECHA_DESC"],
                    "",
                    trim($activo["CHASIS"]),
                    "",
                    trim($activo["FOLIO_DESC"]),
                    "",
                    ""
                ));
            }
            $pdf->SetWidths(array(153,102));
            $pdf->SetAligns(array('L','R'));
            $pdf->RowTotal(array("TOTAL DE  ".trim($data["CLASE_SUBCLASE"])." : ".$totalActivos,"MONTO TOTALIZADO : "."$ ".number_format($montoTotalActivos, 2, '.', ',')));
            $totalGlobalActivos = $totalGlobalActivos + $totalActivos;
            $montoTotalGlobalActivos =  $montoTotalGlobalActivos + $montoTotalActivos;
            $i++;
        }
        $pdf->Ln(2);
        $pdf->RowTotal(array(
            "TOTAL GLOBAL DE BIENES : "."           ".$totalGlobalActivos,
            "MONTO GLOBAL : "."$ ".number_format($montoTotalGlobalActivos, 2, '.', ',')
        ));
        $pdf->Ln(2);
        $pdf->RowTotal(array("FILTRADOR POR : "));
        $pdf->Ln(2);
        if(!empty($whereSentence['T_ACTFIJOS.CCOSTO']))
        {
            $cCostoSelected = $this->CentrosCostos_model->getById($whereSentence['T_ACTFIJOS.CCOSTO']);
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('CENTRO DE COSTO : '.$cCostoSelected->CCOSTO.'-'.$cCostoSelected->NOM_COS));
        }

        if(!empty($whereSentence['T_ACTFIJOS.CC_DESCARG']))
        {
            $cCostoSelected = $this->CentrosCostos_model->getById($whereSentence['T_ACTFIJOS.CC_DESCARG']);
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('CENTRO DE COSTO DEL QUE FUE DESCARGADO : '.$cCostoSelected->CCOSTO.'-'.$cCostoSelected->NOM_COS));
        }

        if(!empty($whereSentence['T_ACTFIJOS.MOTIVO_DES']))
        {
            $get = $this->Actas_model->getById($whereSentence['T_ACTFIJOS.MOTIVO_DES']);
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('MOTIVO DESCARGO : '.$get->DESCRIPCIO));
        }

        if(!empty($whereSentence['T_ACTFIJOS.CORRELF1']))
        {
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('No. AF1 : '.$whereSentence['T_ACTFIJOS.CORRELF1']));
        }

        if(!empty($whereSentence['T_ACTFIJOS.DOC_ASIGNA']))
        {
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('DOCUMENTO DE ASIGNACION : '.$whereSentence['T_ACTFIJOS.DOC_ASIGNA']));
        }

        if(count($whereSentence['T_ACTFIJOS.ESTADO']) > 0)
        {
            $pdf->Ln(2);
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('ESTADOS FILTRADOS : '));
            $estados = $this->Estados_model->getAllById($whereSentence['T_ACTFIJOS.ESTADO']);
            foreach ($estados as $estado) {
                $pdf->RowTotal(array($estado->NOM_ESTA));
            } 
        }

        $pdfString = $pdf->Output("test_".date('d/m/Y').".pdf", "S");
        $pdfBase64 = base64_encode($pdfString);
        echo 'data:application/pdf;base64,' . $pdfBase64;
    }

    private function PDFControlCalidadResumen($datosReporte,$whereSentence)
    {
        $this->load->library('pdf_controlcalidad_resumido');
        $pdf = $this->pdf_controlcalidad_resumido->getInstance();
        $pdf->SetUser($this->session->userdata('username'), $this->validateuser_library->ONIByUser($this->session->userdata('username')));
        $pdf->AddPage('L', 'Letter');
        $pdf->AliasNbPages();
        $totalGlobalActivos = 0;
        $montoTotalGlobalActivos = 0;
        $i = 0;
        
        foreach ($datosReporte as $data) {
            $totalActivos = 0;
            $montoTotalActivos = 0;
            if ($i == 0) {
                $pdf->Ln(10);
            }
            foreach ($data["groupeddata"] as $activo) {
                $pdf->SetWidths(array(24,63,33,33,40,21,46));
                $pdf->SetAligns(array('L','L','C','C','C','R','R'));
                $totalActivos = $totalActivos + 1;
                $montoTotalActivos = $montoTotalActivos + $activo["VALORAR"];
                if($activo["DESCRIPC"] == null || empty($activo["DESCRIPC"])){
                    $pdf->Row(array(
                        trim($activo["CAF"]),
                        trim(utf8_decode($activo["DESCRIPC"])),
                        trim(utf8_decode($activo["NOM_MAR"])),
                        trim(utf8_decode($activo["NOM_MOD"])),
                        trim(utf8_decode($activo["SERIE"])),
                        "$ ".trim(number_format($activo["VALORAR"], 2, '.', ',')),
                        trim(utf8_decode($activo["NOM_ESTA"])),
                    ));
                } else {
                    $pdf->Row(array(
                        trim($activo["CAF"]),
                        trim(utf8_decode($activo["DESCRIPC"])),
                        trim(utf8_decode($activo["NOM_MAR"])),
                        trim(utf8_decode($activo["NOM_MOD"])),
                        trim(utf8_decode($activo["SERIE"])),
                        "$ ".trim(number_format($activo["VALORAR"], 2, '.', ',')),
                        trim(utf8_decode($activo["NOM_ESTA"])),
                    ));
                }

            }
            $totalGlobalActivos = $totalGlobalActivos + $totalActivos;
            $montoTotalGlobalActivos =  $montoTotalGlobalActivos + $montoTotalActivos;
            $i++;
        }
        $pdf->SetWidths(array(113,102));
        $pdf->SetAligns(array('L','R'));
        $pdf->Ln(2);
        $pdf->RowTotal(array(
            "TOTAL GLOBAL DE BIENES : "."           ".$totalGlobalActivos,
            "MONTO GLOBAL : "."$ ".number_format($montoTotalGlobalActivos, 2, '.', ',')
        ));
        $pdf->Ln(2);
        $pdf->RowTotal(array("FILTRADOR POR : "));
        $pdf->Ln(2);
        if(!empty($whereSentence['T_ACTFIJOS.CCOSTO']))
        {
            $cCostoSelected = $this->CentrosCostos_model->getById($whereSentence['T_ACTFIJOS.CCOSTO']);
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('CENTRO DE COSTO : '.$cCostoSelected->CCOSTO.'-'.$cCostoSelected->NOM_COS));
        }

        if(!empty($whereSentence['T_ACTFIJOS.CC_DESCARG']))
        {
            $cCostoSelected = $this->CentrosCostos_model->getById($whereSentence['T_ACTFIJOS.CC_DESCARG']);
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('CENTRO DE COSTO DEL QUE FUE DESCARGADO : '.$cCostoSelected->CCOSTO.'-'.$cCostoSelected->NOM_COS));
        }

        if(!empty($whereSentence['T_ACTFIJOS.MOTIVO_DES']))
        {
            $get = $this->Actas_model->getById($whereSentence['T_ACTFIJOS.MOTIVO_DES']);
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('MOTIVO DESCARGO : '.$get->DESCRIPCIO));
        }

        if(!empty($whereSentence['T_ACTFIJOS.CORRELF1']))
        {
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('No. AF1 : '.$whereSentence['T_ACTFIJOS.CORRELF1']));
        }

        if(!empty($whereSentence['T_ACTFIJOS.DOC_ASIGNA']))
        {
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('DOCUMENTO DE ASIGNACION : '.$whereSentence['T_ACTFIJOS.DOC_ASIGNA']));
        }

        if(count($whereSentence['T_ACTFIJOS.ESTADO']) > 0)
        {
            $pdf->Ln(2);
            $pdf->SetWidths(array(153));
            $pdf->RowTotal(array('ESTADOS FILTRADOS : '));
            $estados = $this->Estados_model->getAllById($whereSentence['T_ACTFIJOS.ESTADO']);
            foreach ($estados as $estado) {
                $pdf->RowTotal(array($estado->NOM_ESTA));
            } 
        }

        $pdfString = $pdf->Output("test_".date('d/m/Y').".pdf", "S");
        $pdfBase64 = base64_encode($pdfString);
        echo 'data:application/pdf;base64,' . $pdfBase64;
    }

    public function groupArray($array, $groupkey)
    {
        if (count($array)>0) {
            $keys = array_keys($array[0]);
            $removekey = array_search($groupkey, $keys);
            if ($removekey===false) {
                return array("Clave \"$groupkey\" no existe");
            } else {
                unset($keys[$removekey]);
            }
            $groupcriteria = array();
            $return=array();
            foreach ($array as $value) {
                $item=null;
                foreach ($keys as $key) {
                    $item[$key] = $value[$key];
                }
                $busca = array_search($value[$groupkey], $groupcriteria);
                if ($busca === false) {
                    $groupcriteria[]=$value[$groupkey];
                    $return[]=array($groupkey=>$value[$groupkey],'groupeddata'=>array());
                    $busca=count($return)-1;
                }
                $return[$busca]['groupeddata'][]=$item;
            }
            return $return;
        } else {
            return array();
        }
    }

    public function getAsignacionesByOni () {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $oni = xss_clean($this->input->post('nOni'));
            $ccosto = xss_clean($this->input->post('nCcosto'));
            $tipoRep = xss_clean($this->input->post('tipoRep'));

            $tipoMov = ($tipoRep=="TR")?'1':'0';
            $data = $this->ActivosFijos_model->getAsignacionPersonalEncabezado($oni, $ccosto, $tipoMov);
            
            if ($data) {
                $arr = array('data' => $data);
            } 
            echo json_encode($arr);
        }else{
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    public function reporteInventarioTecnico()
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));

        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $sessionTimeout = $this->timejwt_library->differenceTime(
                $this->CI->config->item('jwt_expire_time'),
                $is_valid_token['data']->time
            );

            $user = $this->session->userdata('username');
            $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
    
            $data['title'] = 'Reporte Inventario Tecnico'; // Capitalize the first letter
            $data['username'] = $this->session->userdata('username');
            $data['token'] = $this->session->userdata('token');
            $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
            $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
            $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
            $data['ID_ROL'] = $userInfo->ID_ROL;
            $this->load->helper('url');

            $this->load->view('templates/header', $data);
            $this->load->view('reportes/reporteInventarioTecnico', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

     #PDF DE TRASLADOS DE BIENES A CENTROS DE COSTOS
     public function reporteAsignacionGeneral()
     {
         $is_valid_token = $this->authorization_token->validateToken();
         if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
            $oni = xss_clean($this->input->post('nOni'));
            $ccosto = xss_clean($this->input->post('nCcosto'));

            $cCostoSelected = $this->CentrosCostos_model->getById($ccosto);
            $activos = $this->MovimientosActivos_model->getActivosAsignacion($ccosto,strtoupper($oni));

            $this->load->library('pdf_asignacion_general');
            $pdf = $this->pdf_asignacion_general->getInstance();
            $pdf->SetDocumento($documento); 
            $pdf->SetTipoDocumento("ACTIVOS ASIGNADOS A PERSONAL"); 
            $pdf->SetCCosto($cCostoSelected); 
            $pdf->SetUser($this->session->userdata('username'), strtoupper($this->validateuser_library->ONIByUser($this->session->userdata('username'))));
            
            $pdf->AddPage('L', 'Legal');
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(10,35,55,30,25,25,25,25,25,30,45));
            $pdf->SetAligns(array('C','C','L','L','L','L','R','L','L','R','L'));
            if ($activos->num_rows() > 0) {
                $sumaValor = 0;
                $correlativo = 1;
                foreach ($activos->result() as $x) {                    
                    $asigna = $this->ActivosFijos_model->getAsignacion($x->FILAID_ASIGNA_ONI);
                    $subClase = str_pad($x->SUBCLA, 3, "0", STR_PAD_LEFT);
                    $correlsc = str_pad($x->CORRELSC, 4, "0", STR_PAD_LEFT);
                    $valor = number_format($x->VALORAR, 2, '.', ',');
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Row(array($correlativo++, ($x->CLASE.'-'.$subClase.'-'.$correlsc), $x->NOM_SUB,$x->NOM_MAR,$x->NOM_MOD,$x->SERIE,$x->VALORAR,$asigna->FECHA_ASIGNA,$asigna->TIPO_MOV,$asigna->FILAID,$x->OBSERVACIONES ),0);
                    $sumaValor = $sumaValor+$x->VALORAR;
                }
                $pdf->Cell(180,10,'TOTAL $',0,0,'R');
                $pdf->Cell(25,10,number_format($sumaValor, 2, '.', ','),0,1,'R');
            }             
             $pdfString = $pdf->Output(trim($cCostoSelected->CCOSTO).' - '.trim($cCostoSelected->NOM_COS)."_".date('d/m/Y').".pdf", "S");
             $pdfBase64 = base64_encode($pdfString);
             echo 'data:application/pdf;base64,' . $pdfBase64;                 
         }
     }  
     #hasta aqui mi pdf
     
     public function reporteActivos()
     {
         $is_valid_token = $this->authorization_token->validateTokenOverride($this->session->userdata('token'));
         if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,6))) {
             $sessionTimeout = $this->timejwt_library->differenceTime(
                 $this->CI->config->item('jwt_expire_time'),
                 $is_valid_token['data']->time
             );
 
             $data['title'] = 'Reporte de Activos Asignados';
             $data['username'] = $this->session->userdata('username');
             $data['token'] = $this->session->userdata('token');
             $data['allOptions'] =  $this->validateuser_library->returnOptionUser($is_valid_token['data']->user_name);
             $data['alertaSesion'] =  $sessionTimeout['alertaSesion'];
             $data['tiempoSesion'] =  $sessionTimeout['tiempoSesion'];
             $this->load->helper('url');
 
             $this->load->view('templates/header', $data);
             $this->load->view('reportes/reporteActivos', $data);
             $this->load->view('templates/footer', $data);
         } else {
             $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
             redirect('unauthorized/');
         }
    }

    #EXCEL DE REPORTES DE ACTIVOS ASIGNADOS POR CLASE Y SUBCLASE
    public function xlsActivosAsignadosClase($request, $token)
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($token);
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,5,6))) 
        {               
            $outBase64 = base64_decode($request);
            $objRequest = json_decode($outBase64, false);
            $subClase = xss_clean($objRequest->subClase);
            $clase = xss_clean($objRequest->clase);

            $user = $this->session->userdata('username');
            $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
            
            $datoCcosto = ($userInfo->ID_ROL == 4 || $userInfo->ID_ROL == 5)?$userInfo->CCOSTO:'null';
            $this->excelAsignaCosto($datoCcosto, $clase, $subClase, '1');

        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    #EXCEL DE REPORTES DE ACTIVOS ASIGNADOS POR CENTRO DE COSTO
    public function xlsActivosAsignados($cCosto, $token)
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($token);
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,5,6))) 
        {   
            $this->excelAsignaCosto($cCosto,'null', 'null', '2');
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }    

    #EXCEL DE REPORTES DE ACTIVOS ASIGNADOS POR CENTRO DE COSTO, CLASE Y SUBCLASE
    public function xlsActivosAsignadosClaseCentroCosto($request, $token)
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($token);
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,5,6))) 
        {               
            $outBase64 = base64_decode($request);
            $objRequest = json_decode($outBase64, false);
            $subClase = xss_clean($objRequest->subClase);
            $cCosto = xss_clean($objRequest->cCosto);
            $clase = xss_clean($objRequest->clase);

            $user = $this->session->userdata('username');
            $userInfo =  $this->CI->Usuarios_model->getByUserName($user);            
            $this->excelAsignaCosto($cCosto, $clase, $subClase, '3');

        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
        }
    }

    private function excelAsignaCosto($cCosto, $clase, $subclase, $filtro)
    {       
        switch ($filtro) {
            case "1":
                $query = $this->MovimientosActivos_model->getActivosBusquedaAsignado($cCosto, $clase, $subclase);
                break;
            case "2":
                $query = $this->MovimientosActivos_model->getActivosBusquedaAsignado($cCosto, 'null', 'null');
                break;
            case "3":
                $query = $this->MovimientosActivos_model->getActivosBusquedaAsignado($cCosto, $clase, $subclase);
                break ;
        }
        $etiquetaCosto = ($cCosto=='null')?'General':$cCosto;
        $fileName = "Asignaciones ".$etiquetaCosto;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'CAF');
        $sheet->setCellValue('B1', 'DESCRIPCION');
        $sheet->setCellValue('C1', 'MARCA');
        $sheet->setCellValue('D1', 'MODELO');
        $sheet->setCellValue('E1', 'SERIE');
        $sheet->setCellValue('F1', 'NO EQUIPO');
        $sheet->setCellValue('G1', 'NO CHASIS');
        $sheet->setCellValue('H1', 'FECHA ASIGNACION');
        $sheet->setCellValue('I1', 'DOC. ASIGNACION');
        $sheet->setCellValue('J1', 'OBSERVACIONES');
        $sheet->setCellValue('K1', 'ASIGNADO A');
        $sheet->setCellValue('L1', 'ESTADO');
        $rows = 2;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $r) {
                if($r->ONI_ASIGNADO!=null and $r->FILAID_ASIGNA_ONI!=null){
                    $detalle = $this->ActivosFijos_model->getAsignacionPersonalIdDet($r->FILAID,$r->FILAID_ASIGNA_ONI);
                    $obs = $detalle->OBSERVACIONES;
                }
                else{
                    $obs ="";
                }
               
                if($r->ONI_ASIGNADO!=null){
                    $datoPersonal = $this->Personal_model->datosPersona(strtoupper($r->ONI_ASIGNADO));
                    $nombre = $datoPersonal->NOMPER.' '.$datoPersonal->APEPER;
                }
                else{
                    $nombre = "";
                }
                $sheet->setCellValue('A' . $rows, trim($r->CAF));
                $sheet->setCellValue('B' . $rows, trim($r->NOM_SUB));
                $sheet->setCellValue('C' . $rows, trim($r->NOM_MAR));
                $sheet->setCellValue('D' . $rows, trim($r->NOM_MOD));
                $sheet->setCellValue('E' . $rows, trim($r->SERIE));
                $sheet->setCellValue('F' . $rows, trim($r->NUMEQUIPO));
                $sheet->setCellValue('G' . $rows, trim($r->CHASIS));
                $sheet->setCellValue('H' . $rows, trim($r->FECHA_ASIGNA_ONI));
                $sheet->setCellValue('I' . $rows, trim($r->DOC_ASIGNA));
                $sheet->setCellValue('J' . $rows, trim($obs));
                $sheet->setCellValue('K' . $rows, trim($nombre));
                $sheet->setCellValue('L' . $rows, trim($r->NOM_ESTA));
                $rows++;
            }
        }else{
            $sheet->setCellValue('A' . $rows, 'null');
            $sheet->setCellValue('B' . $rows, 'null');
            $sheet->setCellValue('C' . $rows, 'null');
            $sheet->setCellValue('D' . $rows, 'null');
            $sheet->setCellValue('E' . $rows, 'null');
            $sheet->setCellValue('F' . $rows, 'null');
            $sheet->setCellValue('G' . $rows, 'null');
            $sheet->setCellValue('H' . $rows, 'null');
            $sheet->setCellValue('I' . $rows, 'null');
            $sheet->setCellValue('J' . $rows, 'null');
            $sheet->setCellValue('K' . $rows, 'null');
            $sheet->setCellValue('L' . $rows, 'null');
        }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"');
        $writer->save('php://output');
    }

    public function xlsConsultasGenerales($request, $token)
    {
        $is_valid_token = $this->authorization_token->validateTokenOverride($token);
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,4,5,6))) 
        {     
            #CONSULTANDO DATOS DE USUARIO
            $user = $this->session->userdata('username');
            $userInfo =  $this->CI->Usuarios_model->getByUserName($user);

            $outBase64 = base64_decode($request); 
            $objRequest = json_decode($outBase64, false);
            $filtro = xss_clean($objRequest->id_consulta);
            $centroDeCosto = xss_clean($objRequest->id_ccostos);
            $clase = xss_clean($objRequest->id_clase);
            $subclase = xss_clean($objRequest->id_subclase);
            $fechaDesde = xss_clean($objRequest->fechaDesde);
            $fechaHasta = xss_clean($objRequest->fechaHasta);

            $desde = $this->convertDateOracle($fechaDesde);
            $hasta = $this->convertDateOracle($fechaHasta);

            $datoCcosto = ($userInfo->ID_ROL == 4)?$userInfo->CCOSTO:'null';

            switch ($filtro) {
                case "FI":
                        $query = $this->ActivosFijos_model->getActivosByFechaIngreso($desde, $hasta, $datoCcosto);
                        $nombreDoc = 'Consulta por Fecha de ingreso';
                    break; 
                case "CS":
                        $query = $this->ActivosFijos_model->getActivosByClaseSubClase($clase, $subclase, $datoCcosto);
                        $nombreDoc = 'Consulta por Clase y Sub-Clase';
                    break;
                case "CC":
                        $query = $this->ActivosFijos_model->getActivosByCentroCosto($centroDeCosto);
                        $nombreDoc = 'Consulta por Centro de Costo';
                    break;
                case "CCCS":
                        $query = $this->ActivosFijos_model->getActivosByCentroCostoClaseSubClase($centroDeCosto, $clase, $subclase);
                        $nombreDoc = 'Centro de Costo, Clase y Sub-Clase';
                    break ;
                case "FICS":
                        $query = $this->ActivosFijos_model->getActivosByFechaIngresoClaseSubClase($desde, $hasta, $clase, $subclase, $datoCcosto);
                        $nombreDoc = 'Fecha Ingreso, Clase y Sub-Clase';
                    break;
            }
            $fileName = $nombreDoc;
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'CAF');
            $sheet->setCellValue('B1', 'DESCRIPCION');
            $sheet->setCellValue('C1', 'FECHA INGRESO');
            $sheet->setCellValue('D1', 'MARCA');
            $sheet->setCellValue('E1', 'MODELO');
            $sheet->setCellValue('F1', 'SERIE');
            $sheet->setCellValue('G1', 'NO EQUIPO');
            $sheet->setCellValue('H1', 'FECHA ASIGNACION');
            $sheet->setCellValue('I1', 'DOC. ASIGNACION');
            $sheet->setCellValue('J1', 'NO CHASIS');
            $sheet->setCellValue('K1', 'NO MOTOR');
            $sheet->setCellValue('L1', 'OBSERVACIONES');
            $sheet->setCellValue('M1', 'ESTADO');
            $sheet->setCellValue('N1', 'CCOSTO');
            $sheet->setCellValue('O1', 'FACTURA');
            $sheet->setCellValue('P1', 'VALORAR');
            $sheet->setCellValue('Q1', 'CLASE');
            $sheet->setCellValue('R1', 'SUBCLA');
            $sheet->setCellValue('S1', 'CORRELSC');
            $rows = 2;
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $r) {
                    $sheet->setCellValue('A' . $rows, $r->CAF);
                    $sheet->setCellValue('B' . $rows, $r->DESCRIPC);
                    $sheet->setCellValue('C' . $rows, $r->FINGRESO);
                    $sheet->setCellValue('D' . $rows, $r->NOM_MAR);
                    $sheet->setCellValue('E' . $rows, $r->NOM_MOD);
                    $sheet->setCellValue('F' . $rows, $r->SERIE);
                    $sheet->setCellValue('G' . $rows, $r->NUMEQUIPO);
                    $sheet->setCellValue('H' . $rows, $r->FASIGNA);
                    $sheet->setCellValue('I' . $rows, $r->DOC_ASIGNA);
                    $sheet->setCellValue('J' . $rows, $r->CHASIS);
                    $sheet->setCellValue('K' . $rows, $r->MOTOR);
                    $sheet->setCellValue('L' . $rows, $r->OBSERVA);
                    $sheet->setCellValue('M' . $rows, $r->NOM_ESTA);
                    $sheet->setCellValue('N' . $rows, $r->CCOSTO);
                    $sheet->setCellValue('O' . $rows, $r->FACTURA);
                    $sheet->setCellValue('P' . $rows, $r->VALORAR);
                    $sheet->setCellValue('Q' . $rows, $r->CLASE);
                    $sheet->setCellValue('R' . $rows, $r->SUBCLA);
                    $sheet->setCellValue('S' . $rows, $r->CORRELSC);
                    $rows++;
                }
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"');
            $writer->save('php://output');
            
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            redirect('unauthorized/');
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

}
