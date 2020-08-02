<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ReportesModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function store($table, $data){
        $this->db->insert($table, $data);
    }

    public function getNumEsquelas($fechaDesde, $fechaHasta, $unidad, $table, $tipoFecha){

        $this->db->select('ID_FILA, COUNT(*) AS TOT_ESQUELAS, COUNT(DECOM_TARJETA) AS NUM_DECOMISO_TARJETA, COUNT(DECOM_LICENCIA) AS NUM_DECOMISO_LICENCIA, COUNT(DECOM_VEHICULO) AS NUM_DECOMISO_VEHICULO, COUNT(DECOM_1_PLACA) AS NUM_DECOMISO_1PLACA, COUNT(DECOM_2_PLACA) AS NUM_DECOMISO_2PLACA, COUNT(DECOM_PERMISO_L) AS NUM_DECOMISO_PERMISO, COUNT(DECOM_POLIZA) AS NUM_DECOMISO_POLIZA');
        $this->db->from($table);
        $this->db->where($tipoFecha.' BETWEEN '.$this->db->escape($fechaDesde).' AND '.$this->db->escape($fechaHasta));
        $this->db->where("ESTADO", 'PROCESADA');
        $this->db->where('ID_UNIDAD_TTO = '.$unidad);
        $this->db->group_by('ID_FILA');
        $query = $this->db->get();
        return $query->result();
        
    }

    public function getEsquelasRemitidas($fechaDesde, $fechaHasta, $unidad, $table, $tipoFecha){
        $this->db->select('TTO_TE_ESQUELAS.*, TTO_CE_FALTAS.NUM_FALTA');
        $this->db->from($table);
        $this->db->join('TTO_CE_FALTAS', 'TTO_CE_FALTAS.ID_FILA = TTO_TE_ESQUELAS.ID_FALTA', 'INNER');
        $this->db->where($tipoFecha." BETWEEN ".$this->db->escape($fechaDesde)." AND ".$this->db->escape($fechaHasta));
        $this->db->where("ESTADO", 'PROCESADA');
        $this->db->where('ID_UNIDAD_TTO = '.$unidad);
        $query = $this->db->get(); 

        return $query->result();
    }

    public function getEsquelasRemitidasDeco($fechaDesde, $fechaHasta, $unidad, $table, $tipoFecha){
        $this->db->select('TTO_TE_ESQUELAS.*, TTO_CE_TIPOSLIC.CODIGO, TTO_CE_FALTAS.NUM_FALTA');
        $this->db->from($table);
        $this->db->join('TTO_CE_FALTAS', 'TTO_CE_FALTAS.ID_FILA = TTO_TE_ESQUELAS.ID_FALTA', 'INNER');
        $this->db->join('TTO_CE_TIPOSLIC', 'TTO_CE_TIPOSLIC.ID_FILA = TTO_TE_ESQUELAS.ID_CLASELIC', 'INNER');
        $this->db->where($tipoFecha.' BETWEEN '.$this->db->escape($fechaDesde).' AND '.$this->db->escape($fechaHasta));
        $this->db->where("ESTADO", 'PROCESADA');
        $this->db->where('ID_UNIDAD_TTO = '.$unidad);
        $query = $this->db->get(); 

        return $query->result();
    }

    public function updateEsquelasPorRemision($data, $tabla, $idEsquela){
        $this->db->set($data);
        $this->db->where('ID_FILA', $idEsquela);
        $this->db->update($tabla);
        $this->db->affected_rows();
    }

    public function getRemision(){
        $query = $this->db->query("SELECT MAX(ID_FILA) as NUM_REM FROM TTO_TE_REMISION");
     
        return $query->result();
    }

    public function getReporteSimulacion($fechaDesde, $fechaHasta, $unidad, $table, $tipoFecha, $estado){
        $this->db->select('NUM_PLACA, NUM_SERIE,  NOMBRES, APELLIDOS, ID_FILA, FECHA_ESQUELA, ONI_IMPONE, DECOM_TARJETA, DECOM_LICENCIA, DECOM_VEHICULO, DECOM_1_PLACA, DECOM_2_PLACA, DECOM_PERMISO_L, DECOM_POLIZA, (count(DECOM_TARJETA) + count(DECOM_LICENCIA) + count(DECOM_VEHICULO) + count(DECOM_1_PLACA) + count(DECOM_2_PLACA) + count(DECOM_PERMISO_L) + count(DECOM_POLIZA)) AS TOTAL');
        $this->db->from($table);
        $this->db->where($tipoFecha.' BETWEEN '.$this->db->escape($fechaDesde).' AND '.$this->db->escape($fechaHasta));
        $this->db->where("ESTADO", $estado);
        $this->db->where("ID_UNIDAD_TTO", $unidad);
        $this->db->group_by('NUM_PLACA, NUM_SERIE,  NOMBRES, APELLIDOS, ID_FILA, FECHA_ESQUELA, ONI_IMPONE, DECOM_TARJETA, DECOM_LICENCIA, DECOM_VEHICULO, DECOM_1_PLACA, DECOM_2_PLACA, DECOM_PERMISO_L, DECOM_POLIZA');
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getOficio($fecha, $tipoBusqueda, $unidad){
        $this->db->select("TTO_TE_REMISION.ID_FILA, TTO_TE_REMISION.NUM_OFICIO, TTO_C_UNIDADES.NOMBRE, TTO_TE_REMISION.TOT_ESQUELAS");
        $this->db->from("TTO_TE_REMISION");
        $this->db->join("TTO_C_UNIDADES", "TTO_C_UNIDADES.ID_FILA = TTO_TE_REMISION.ID_UNIDAD_TTO", "inner");
        $this->db->where("FECHA_REMISION",$fecha);
        if($tipoBusqueda == "unidad"){
            $this->db->where("TTO_TE_REMISION.ID_UNIDAD_TTO", $unidad);
        }
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getOficioById($idOficio){
        $this->db->select("TTO_TE_REMISION.*, TTO_C_UNIDADES.NOMBRE, TTO_TE_ESQUELAS.USER_ADD");
        $this->db->from("TTO_TE_REMISION");
        $this->db->join("TTO_C_UNIDADES", "TTO_TE_REMISION.ID_UNIDAD_TTO = TTO_C_UNIDADES.ID_FILA", "inner");
        $this->db->join("TTO_TE_ESQUELAS", "TTO_TE_ESQUELAS.ID_REMISION = TTO_TE_REMISION.ID_FILA", "left");
        $this->db->where("TTO_TE_REMISION.ID_FILA", $idOficio);
        $query = $this->db->get(); 
        return $query->row();
    }

    public function getEsquelasSinDecomisos($fecha1, $fecha2, $unidad, $tabla, $tipoFecha){

        $this->db->select("E.ID_FILA, E.NUM_SERIE, E.NUM_LICENCIA, E.NOMBRES, E.APELLIDOS, E.NUM_PLACA, E.CLASE_VEHICULO, E.RUTA, E.FECHA_ESQUELA, E.HORA_ESQUELA, E.ONI_IMPONE, F.NUM_FALTA");
        $this->db->from("TTO_TE_ESQUELAS E");
        $this->db->join("TTO_CE_FALTAS F", "F.ID_FILA = E.ID_FALTA", "inner");
        $this->db->where("ESTADO", 'PROCESADA');
        $this->db->where("ID_UNIDAD_TTO", $unidad);
        $this->db->where($tipoFecha.' BETWEEN '.$this->db->escape($fecha1).' AND '.$this->db->escape($fecha2));
        $this->db->having("(count(E.DECOM_TARJETA) + count(E.DECOM_LICENCIA) + count(E.DECOM_VEHICULO) + count(E.DECOM_1_PLACA) + count(E.DECOM_2_PLACA) + count(E.DECOM_PERMISO_L) + count(E.DECOM_POLIZA)) = 0");
        $this->db->group_by("E.ID_FILA, E.NUM_SERIE, E.NUM_LICENCIA, E.NOMBRES, E.APELLIDOS, E.NUM_PLACA, E.CLASE_VEHICULO, E.RUTA, E.FECHA_ESQUELA, E.HORA_ESQUELA, E.ONI_IMPONE, F.NUM_FALTA");
    }

    public function getBitacoraTalonariosOni($oni){

        $this->db->select('TTO_TE_TALONARIOS.*, PERSONALIMPERIUM.APEPER, PERSONALIMPERIUM.NOMPER');
        $this->db->from("TTO_TE_TALONARIOS");
        $this->db->join('PERSONALIMPERIUM', 'PERSONALIMPERIUM.CODPER = TTO_TE_TALONARIOS.ONI_RECIBE', 'inner');
        $this->db->where("ONI_RECIBE", $oni);
        $query = $this->db->get(); 
        return $query->result();

    }

    public function getBitacoraTalonariosNombre($nombres, $apellidos){

        $this->db->select("TTO_TE_TALONARIOS.*, PERSONALIMPERIUM.APEPER, PERSONALIMPERIUM.NOMPER");
        $this->db->from("TTO_TE_TALONARIOS");
        $this->db->join('PERSONALIMPERIUM', 'PERSONALIMPERIUM.CODPER = TTO_TE_TALONARIOS.ONI_RECIBE', 'inner');
        $this->db->where("PERSONALIMPERIUM.APEPER", $nombres);
        $this->db->where("PERSONALIMPERIUM.NOMPER", $apellidos);
        $query = $this->db->get(); 
        return $query->result();

    }

    public function getEsquelasBySerie($serieInicial, $serieFinal){
        $this->db->select('*');
        $this->db->from('TTO_TE_ESQUELAS');
        $this->db->where('NUM_SERIE BETWEEN '.$serieInicial.' AND '.$serieFinal);
        $query = $this->db->get(); 
        return $query->result();
    }

    

}