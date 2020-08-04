<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class models extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function getSelect2Marca($searchTerm = ""){
        $this->db->select('*');
        $this->db->where("marca like '%".$searchTerm."%' ");
        $this->db->or_where("id_marca like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get("marcas");
        $records = $fetched_records->result_array();

        $data = array();
        foreach($records as $record){
           $data[] = array("id"=>$record['id_marca'], "text"=>$record['id_marca'].' - '.$record['marca']);
        }
        return $data;
    }

    public function getSelect2Modelo($searchTerm = ""){
        $this->db->select('*');
        $this->db->where("modelo like '%".$searchTerm."%' ");
        $this->db->or_where("id_modelo like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get("modelos");
        $records = $fetched_records->result_array();

        $data = array();
        foreach($records as $record){
           $data[] = array("id"=>$record['id_modelo'], "text"=>$record['id_modelo'].' - '.$record['modelo']);
        }
        return $data;
    }

    public function getAll($tableName)
    {
        $this->db->select('*');
        $this->db->from($tableName);
        $query=$this->db->get();
        return $query->result();
    }

    public function getById($id, $tableName, $primaryKey)
    {
        $this->db->select('*');
        $this->db->from($tableName);
        $this->db->where($primaryKey, $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getVehById($id)
    {
        $this->db->select('vehiculos.*, marcas.marca as marcaV, modelos.modelo as modeloV');
        $this->db->from('vehiculos');
        $this->db->join('modelos', 'modelos.id_modelo = vehiculos.id_modelo', 'inner');
        $this->db->join('marcas', 'marcas.id_marca = vehiculos.id_marca', 'inner');
        $this->db->where('id_vehiculo', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getByUserNameNotJoin($id)
    {
        $this->db->from($this->tableName);
        $this->db->where($this->tableName.'.nombre',$id);
        $query = $this->db->get();
        return $query->row();
    }

    
    public function getByUserName($id)
    {
        $this->db->select($this->tableName.'.*,'.$this->joinTableName.'.*');
        $this->db->from($this->tableName);
        $this->db->join($this->joinTableName, $this->joinTableName.'.'.$this->foreignKey.'='.$this->tableName.'.'.$this->foreignKey, 'inner');
        $this->db->where($this->tableName.'.nombre',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function create($data, $tableName)
    {
        $this->db->insert($tableName, $data);
        return $data;
    }

    public function update($data, $tableName, $primaryKey)
    {
        $where = array($primaryKey => $data[$primaryKey]);
        $this->db->update($tableName, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($id, $tableName, $primaryKey)
    {
        $this->db->where($primaryKey, $id);
        $this->db->delete($tableName);
    }

    public function getDataByOni($oni){
        $this->db->select('UNIDAD');
        $this->db->from("TTO_T_USUARIOS");
        $this->db->where("CODPER", $oni);
        $query = $this->db->get();  
        return $query->row();
    }

    public function getAllVehiculos($tableName){
        $this->db->select('vehiculos.*, marcas.marca as marcaV, modelos.modelo as modeloV');
        $this->db->from('vehiculos');
        $this->db->join('modelos', 'modelos.id_modelo = vehiculos.id_modelo', 'inner');
        $this->db->join('marcas', 'marcas.id_marca = vehiculos.id_marca', 'inner');
        $query = $this->db->get();
        return $query->result();
    }
}
