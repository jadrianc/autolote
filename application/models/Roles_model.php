<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Roles_model extends CI_Model
{
    public function __construct()
    {
        $this->tableName =  "roles";
        $this->primaryKey =  "id_rol";
        $this->load->database();
    }

    public function getSelect2($searchTerm = "")
    {
        $this->db->select('*');
        $this->db->where("nombre_rol like '%".$searchTerm."%' ");
        $this->db->or_where("id_rol like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['id_rol'], "text"=>$record['id_rol'].' - '.$record['nombre_rol']);
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

    public function getByRolName($id)
    {
        $this->db->from($this->tableName);
        $this->db->where('NOMBRE_ROL', $id);
        $query = $this->db->get();
  
        return $query->row();
    }

    public function create($data)
    {
        $this->db->insert($this->tableName, $data);
        return $data;
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
