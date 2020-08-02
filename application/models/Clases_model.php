<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Clases_model extends CI_Model
{
    public function __construct()
    {
        $this->tableName =  "C_CLASES";
        $this->primaryKey =  "CLASE";
        $this->load->database();
    }

    public function getSelect2($searchTerm = "")
    {
        $this->db->select('*');
        $this->db->where("NOM_CLAS like '%".$searchTerm."%' ");
        $this->db->or_where("CLASE like '%".$searchTerm."%' ");
        $this->db->order_by("CLASE", "ASC");
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['CLASE'], "text"=>$record['CLASE'].' - '.$record['NOM_CLAS']);
        }
        return $data;
    }

    public function getAll()
    {
        $this->db->from($this->tableName);
        $query=$this->db->get();
        return $query->result();
    }

    public function getById($id)
    {
        $this->db->from($this->tableName);
        $this->db->where($this->primaryKey, $id);
        $query = $this->db->get();
  
        return $query->row();
    }

    public function getByIds($id)
    {
        $this->db->from($this->tableName);
        $this->db->where_in($this->primaryKey, $id);
        $query=$this->db->get();
        return $query->result();
    }

    public function create($data)
    {
        $this->db->insert($this->tableName, $data);
        return $data[$this->primaryKey];
    }

    public function update($data)
    {
        $where = array($this->primaryKey => $data[$this->primaryKey]);
        $this->db->update($this->tableName, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where($this->primaryKey, $id);
        $this->db->delete($this->tableName);
    }

    public function getSelect2EquiposTecnicos($searchTerm = "")
    {
        $where = array(302,301,354);
        $this->db->select('*');
        $this->db->where_in('CLASE', $where);
        $this->db->order_by("CLASE", "ASC");
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['CLASE'], "text"=>$record['CLASE'].' - '.$record['NOM_CLAS']);
        }
        return $data;
    }
}
