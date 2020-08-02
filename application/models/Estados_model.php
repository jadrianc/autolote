<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Estados_model extends CI_Model
{
    public function __construct()
    {
        $this->tableName =  "C_ESTADO";
        $this->primaryKey =  "ESTADO";
        $this->load->database();
    }

    
    public function getSelect2($searchTerm = "")
    {
        $this->db->select('*');
        $this->db->where("NOM_ESTA like '%".$searchTerm."%' ");
        $this->db->or_where("ESTADO like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['ESTADO'], "text"=>$record['ESTADO'].' - '.$record['NOM_ESTA']);
        }
        return $data;
    }


    public function getAll()
    {
        $this->db->from($this->tableName);
        $this->db->order_by($this->tableName.'.ESTADO','ASC');
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

    public function getAllById($id)
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
}
