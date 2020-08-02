<?php
defined('BASEPATH') or exit('No direct script access allowed');
class TransitoModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getAll($table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $query=$this->db->get();
        return $query->result();
    }

    public function create($table, $data)
    {
        $this->db->insert($table, $data);
        //return $data[$primaryKey];
    }

    public function getById($tabla, $id, $primaryKey)
    {
        $this->db->from($tabla);
        $this->db->where($primaryKey, $id);
        $query = $this->db->get();  
        return $query->row();
    }

    public function update($tabla, $data, $primaryKey)
    {
        $where = array($primaryKey => $data[$primaryKey]);
        $this->db->update($tabla, $data, $where);
        $this->db->affected_rows();
    }

    public function delete($tabla, $id, $primaryKey)
    {
        $this->db->where($primaryKey, $id);
        $this->db->delete($tabla);
    }

    

    public function getAllJoin($tabla, $tablaJoin, $primaryKey, $foreignKey, $campo)
    {
        $this->db->select($tabla.'.*,'.$tablaJoin.'.'.$campo);
        $this->db->from($tabla);
        $this->db->join($tablaJoin, $tablaJoin.'.'.$foreignKey.'='.$tabla.'.'.$primaryKey, 'left');
        $query=$this->db->get();
        return $query->result();
    }   

    public function getRowById($tabla, $tablaJoin, $primaryKey, $foreignKey, $campo, $id)
    {
        $this->db->select($tabla.'.*,'.$tablaJoin.'.'.$campo);
        $this->db->from($tabla);
        $this->db->join($tablaJoin, $tablaJoin.'.'.$foreignKey.'='.$tabla.'.'.$primaryKey, 'left');
        $this->db->where($tabla.'.'.$foreignKey, $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getSelect2($searchTerm = "")
    {
        $this->db->select('*');
        $this->db->where("NOMBRE like '%".$searchTerm."%' ");
        $this->db->or_where("ID_FILA like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get('TTO_C_UNIDADES');
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['ID_FILA'], "text"=>$record['ID_FILA'].' - '.$record['NOMBRE']);
        }
        return $data;
    }

    public function comprobar($id, $table){
        $this->db->select('CARNOM, NOMPER, APEPER, CODPER');
        $this->db->from('PERSONALIMPERIUM');
        $this->db->where("CODPER ",$id);
        $query = $this->db->get();  
        return $query->row();
     }

     public function comprobarAutorizacionTalonario($id, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where("ONI ",$id);
        $query = $this->db->get();  
        return $query->row();
     }

     public function getAllTipos($table) {
         $this->db->select("ARM_C_TIPOS.ID_FILA, ARM_C_TIPOS.NOM_TIPO, ARM_C_CLASES.NOM_CLASE");
         $this->db->from($table);
         $this->db->join("ARM_C_CLASES", "ARM_C_CLASES.ID_FILA = ".$table.".ID_CLASE", "left");
         $fetched_records = $this->db->get();
        $records = $fetched_records->result_array();
        return $records;
     }


    public function getByIdClase($tabla, $id, $primaryKey)
    {
        $this->db->select("ARM_C_TIPOS.ID_FILA, ARM_C_TIPOS.NOM_TIPO, ARM_C_CLASES.NOM_CLASE");
        $this->db->from($tabla);
        $this->db->join("ARM_C_CLASES", "ARM_C_CLASES.ID_FILA = ".$tabla.".ID_CLASE", "left");
        $this->db->where("ARM_C_TIPOS.ID_FILA", $id);
        $query = $this->db->get();  
        return $query->row();
    }

    public function getId($tabla, $campo, $contenido)
    {        
        $this->db->from($tabla);
        $this->db->where($campo, $contenido);
        $query = $this->db->get();  
        return $query->row();
    }

    public function getSelectAll($searchTerm = "", $id, $campo, $tabla)
    {
        $this->db->select('*');
        $this->db->where($campo." like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get($tabla);
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record[$id], "text"=>$record[$campo]);
        }
        return $data;
    }


    public function getByIdRegistros($tabla, $id, $primaryKey)
    {
        $this->db->from($tabla);
        $this->db->where($primaryKey, $id); 
        $this->db->close();
        return $this->db->get();
    }


public function getSelect2CcostoArmas($searchTerm = "")
    {
        $this->db->select('*');
        $this->db->where("NOM_CC like '%".$searchTerm."%' ");
        $this->db->or_where("CCOSTO like '%".$searchTerm."%' ");
        $this->db->order_by("CCOSTO", "ASC");
        $fetched_records = $this->db->get('ARM_C_CCOSTO');
        $records = $fetched_records->result_array();
        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['ID_FILA'], "text"=>$record['CCOSTO'].' - '.$record['NOM_CC']);
        }
        $this->db->close();
        return $data;
    }

    public function getArmaBySerieAsignada($serie){
        $this->db->select('ARM_C_ESTADOS.NOM_ESTADO, ARM_T_ARMAS.ONI_ASIGNACION, ARM_C_CLASES.NOM_CLASE, ARM_C_TIPOS.NOM_TIPO, ARM_C_MARCAS.NOM_MARCA, ARM_C_MODELOS.NOM_MODELO, ARM_T_ARMAS.DESCRIPCION, ARM_T_ARMAS.BALISTICA, ARM_C_CALIBRE.NOM_CALIBRE');
        $this->db->from('ARM_T_ARMAS');
        $this->db->join('ARM_C_ESTADOS', 'ARM_C_ESTADOS.ID_FILA = ARM_T_ARMAS.ID_ESTADO', 'LEFT');
        $this->db->join('ARM_C_CLASES', 'ARM_C_CLASES.ID_FILA = ARM_T_ARMAS.ID_CLASE', 'LEFT');
        $this->db->join('ARM_C_TIPOS', 'ARM_C_TIPOS.ID_FILA = ARM_T_ARMAS.ID_TIPO', 'LEFT');
        $this->db->join('ARM_C_MARCAS', 'ARM_C_MARCAS.ID_FILA = ARM_T_ARMAS.ID_MARCA', 'LEFT');
        $this->db->join('ARM_C_MODELOS', 'ARM_C_MODELOS.ID_FILA = ARM_T_ARMAS.ID_MODELO', 'LEFT');
        $this->db->join('ARM_C_CALIBRE', 'ARM_C_CALIBRE.ID_FILA = ARM_T_ARMAS.ID_CALIBRE', 'LEFT');
        $this->db->where('SERIE', $serie);
        //$this->db->where('ONI_ASIGNACION', $oni_asignado);
        $query = $this->db->get();
        $this->db->close();
        return $query->row();
    }

    public function getNumDoc(){
        $query = $this->db->query("SELECT MAX(ID_FILA) as NUM_DOC FROM ARM_T_ASIGNACION");
        $this->db->close();
        return $query->result();
    }

    public function getAsignacionByDoc($numDoc)
    {   
        $this->db->select('*');
        $this->db->from('ARM_T_ASIGNACION');
        $this->db->where('ID_FILA', $numDoc);
        $query = $this->db->get();
        $this->db->close();
        return $query->row();
    }

    public function getCcostoArmasById($id){
        $this->db->select('*');
        $this->db->from('ARM_C_CCOSTO');
        $this->db->where('ID_FILA', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getAsignacionArma($serieAsignada){
        $this->db->select("*");
        $this->db->from("ARM_T_ASIGNACION");
        $this->db->where("SERIE_ASIGNADA", $serieAsignada);
        $query = $this->db->get();
        
        return $query->row();

    }

    public function getNumAutorizacion(){
        $query = $this->db->query("SELECT MAX(ID_FILA) as NUM_AUT FROM TTO_CE_ONIAUT");
        $this->db->close();
        return $query->result();
    }

    public function getIdTalonario(){
        $query = $this->db->query("SELECT MAX(ID_FILA) as IDTALONARIO FROM TTO_TE_TALONARIOS");
        $this->db->close();
        return $query->result();
    }

    public function getNumTalonariosAsignado($oni){
        $this->db->select('count(TTO_TE_TALONARIOS.estado) as TALONARIOS');
        $this->db->from('TTO_TE_TALONARIOS');
        $this->db->where('ONI_RECIBE', $oni);
        $this->db->where('ESTADO', 'Asignado');
        $query = $this->db->get();
        return $query->row();
    }

    public function validarAsignacion($serieFinal,  $serieInicial){
        $query = $this->db->query("select * from TTO_TE_TALONARIOS where SERIE_FINAL BETWEEN ".$serieInicial." and ".$serieFinal);
        $this->db->close();
        return $query->result();
    }

    public function getTalonariosByOni($oni, $rol){
        $this->db->select('*');
        $this->db->from('TTO_TE_TALONARIOS');
        if($rol == false){
        $this->db->where('ONI_RECIBE', $oni);
        }
        //$this->db->where('ESTADO', 'Asignado');
        $query=$this->db->get();
        return $query->result();
    }

    public function reasignar($table, $data, $id){
        $this->db->where('ID_FILA', $id);
        $this->db->update($table, $data);
    }

    public function validarReasignacion($oni){
        $this->db->select('COUNT(ID_FILA) as NUM');
        $this->db->from("TTO_TE_TALONARIOS");
        $this->db->where("ONI_RESPONSABLE", $oni);
        $this->db->where("ESTADO", "REASIGNADO");
        $query=$this->db->get();
        return $query->result();
    }

    public function reporte($data, $key, $oniUsuario, $rol){
        
        $this->db->select("TTO_TE_TALONARIOS.SERIE_INICIAL, TTO_TE_TALONARIOS.SERIE_FINAL, TTO_TE_TALONARIOS.ESTADO, TTO_TE_TALONARIOS.FECHA_ENTREGA, TTO_TE_TALONARIOS.ONI_RECIBE, TTO_C_UNIDADES.NOMBRE, TTO_TE_TALONARIOS.ONI_RESPONSABLE, TTO_TE_TALONARIOS.FECHA_REASIGNACION, TTO_TE_TALONARIOS.OBSERVACION_E");
        $this->db->from("TTO_T_USUARIOS");
        $this->db->join("TTO_TE_TALONARIOS", "TTO_T_USUARIOS.CODPER = TTO_TE_TALONARIOS.ONI_RECIBE", "RIGHT");
        $this->db->join("TTO_C_UNIDADES", "TTO_C_UNIDADES.ID_FILA = TTO_T_USUARIOS.UNIDAD", "LEFT");
        $this->db->where("TTO_TE_TALONARIOS".".".$key, $data);
        if($rol == false){
            $this->db->where("TTO_TE_TALONARIOS.ONI_ENTREGA", $oniUsuario);
        }
        $query = $this->db->get();
        return $query->result();

    }

    public function getSelect2Documento($searchTerm = "")
    {
        $this->db->select("ID_FILA, CONCAT(CONCAT(CODIGO, ' - '), DESCRIPCION) AS DOCUMENTO");
        $this->db->like("CONCAT(CONCAT(CODIGO, ' - '), DESCRIPCION)", $searchTerm);
        $fetched_records = $this->db->get("TTO_CE_TIPOSLIC");
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['ID_FILA'], "text"=>$record['DOCUMENTO']);
        }
        return $data;
    }

    public function getSelect2Departamento($searchTerm = "")
    {
        $this->db->select("CODEP, CONCAT(CONCAT(CODEP, ' - '), DESDEP) AS DEPARTAMENTO");
        $this->db->like("CONCAT(CONCAT(CODEP, ' - '), DESDEP)", $searchTerm);
        $fetched_records = $this->db->get("CATALOGOSPNC.C_DEPARTAMENTOS");
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['CODEP'], "text"=>$record['DEPARTAMENTO']);
        }
        return $data;
    }
    
    public function getByPlaca($placa)
    {
        $this->db->select("*");
        $this->db->from("VEHICULOS");
        $this->db->where("PLACA", $placa);

        $fetched_records = $this->db->get();
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array(
            
            "tipo_placa" => $record["TIPO_PLACA"],
            "clase"=>$record['CLASE'],
            "marca"=>$record['MARCA'],
            "modelo"=>$record['MODELO'],
            "color"=>$record['COLORES'],
            "año"=>$record['ANIO_FAB'],
            "estado"=>$record['ESTADO_VEH']
        
        );
        }
        return $data;
    }

    public function getSelect2Plan($searchTerm = "")
    {
        $this->db->select("ID_FILA, CONCAT(CONCAT(ID_FILA, ' - '), DESCRIPCION) AS PLAN");
        $this->db->like("CONCAT(CONCAT(ID_FILA, ' - '), DESCRIPCION)", $searchTerm);
        $fetched_records = $this->db->get("TTO_CE_PLANES");
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['ID_FILA'], "text"=>$record['PLAN']);
        }
        return $data;
    }

    public function getSelect2Falta($searchTerm = "")
    {
        $this->db->select("ID_FILA, CONCAT(CONCAT(NUM_FALTA, ' - '), DESCRIPCION) AS DESCRIPCION, VALOR, CLASIFICACION, RUBRO");
        $this->db->like("CONCAT(CONCAT(ID_FILA, ' - '), DESCRIPCION)", $searchTerm);
        $fetched_records = $this->db->get("TTO_CE_FALTAS");
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array(
                "id"=>$record['ID_FILA'], 
                "text"=>$record['DESCRIPCION'], 
                "valor" => $record["VALOR"], 
                "clasificacion" => $record["CLASIFICACION"], 
                "rubro" => $record["RUBRO"]
            );
        }
        return $data;
    }

    public function getAsigTalonarios($oni, $serie, $tipo_consulta){

        $this->db->select("ID_FILA");
        $this->db->from("TTO_TE_ESQUELAS");
        $this->db->where("NUM_SERIE", $serie);
        $query = $this->db->get();
        $dato = $query->row();
        if($dato && $tipo_consulta == "ingreso"){
            
            return false;
            
        }else{
            $this->db->select("PERSONALIMPERIUM.NOMPER, PERSONALIMPERIUM.APEPER, PERSONALIMPERIUM.NOMUNIDAD, TTO_TE_TALONARIOS.FECHA_REASIGNACION, TTO_TE_TALONARIOS.TOT_IMPUESTAS, TTO_TE_TALONARIOS.SERIE_INICIAL, TTO_TE_TALONARIOS.SERIE_FINAL");
            $this->db->from("TTO_TE_TALONARIOS");
            $this->db->join("PERSONALIMPERIUM", "PERSONALIMPERIUM.CODPER = TTO_TE_TALONARIOS.ONI_RESPONSABLE", "inner");
            $this->db->where("TTO_TE_TALONARIOS.ONI_RESPONSABLE", $oni);
            $this->db->where($serie." between TTO_TE_TALONARIOS.SERIE_INICIAL and TTO_TE_TALONARIOS.SERIE_FINAL");
            $query = $this->db->get();
            $records = $query->result_array();

            $data = array();
            foreach ($records as $record) {
                $data[] = array(
                    "nombre"=>$record['NOMPER'], 
                    "apellidos"=>$record['APEPER'], 
                    "nomunidad" => $record["NOMUNIDAD"], 
                    "fecha" => $record["FECHA_REASIGNACION"], 
                    "impuestas" => $record["TOT_IMPUESTAS"]
                );
            }
            if($data){
                return $data;
            }
            return "no corresponde";
        }

        $this->db->close();
    }

    public function updateNumeroImpuestas($estado, $impuestas, $tabla, $serie){
        $this->db->set('TOT_IMPUESTAS', $impuestas);
        $this->db->set('ESTADO', $estado);
        $this->db->where($serie." BETWEEN SERIE_INICIAL AND SERIE_FINAL");
        $this->db->update($tabla);
        $this->db->affected_rows();
    }

    public function getEsquelaBySerie($serie)
    {   
        $this->db->select('*');
        $this->db->from('TTO_TE_ESQUELAS');
        $this->db->where('NUM_SERIE', $serie);
        $query = $this->db->get();
  
        return $query->row();
    }

    public function getSelect2Clase($searchTerm = "")
    {
        $this->db->select("ID_FILA, CONCAT(CONCAT(ID_FILA, ' - '), DESCRIPCION) AS DESCRIPCION");
        $this->db->like("CONCAT(CONCAT(ID_FILA, ' - '), DESCRIPCION)", $searchTerm);
        $fetched_records = $this->db->get("TTO_CE_CLASEVEH");
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['ID_FILA'], "text"=>$record['DESCRIPCION']);
        }
        return $data;
    }

    public function getSelect2Placa($searchTerm = "")
    {
        $this->db->select("ID_FILA, CONCAT(CONCAT(ID_FILA, ' - '), DESCRIPCION) AS DESCRIPCION");
        $this->db->like("CONCAT(CONCAT(ID_FILA, ' - '), DESCRIPCION)", $searchTerm);
        $fetched_records = $this->db->get("TTO_CE_TIPOPLACAS");
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['ID_FILA'], "text"=>$record['DESCRIPCION']);
        }
        return $data;
    }

    public function getTalonario($num_serie){

        $query = $this->db->query("SELECT * FROM TTO_TE_TALONARIOS WHERE ".$num_serie." BETWEEN SERIE_INICIAL AND SERIE_FINAL");
        
        return $query->result();
        $this->db->close();
    }
    
    
}