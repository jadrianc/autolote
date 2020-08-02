<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auditoria_model extends CI_Model
{
    public function __construct()
    {
        $this->tableName =  "TTO_T_AUDITORIA";
        $this->primaryKey =  "AUDITID";
        $this->load->database();
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

    public function create($data)
    {
        $this->db->insert($this->tableName, $data);
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
