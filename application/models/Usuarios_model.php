<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Usuarios_model extends CI_Model
{

    public function __construct()
    {
        $this->tableName =  "usuarios";
        $this->joinTableName =  "roles";
        
        $this->primaryKey =  "id_usuario";
        $this->foreignKey =  "id_rol";
        $this->load->database();
    }

    public function getSelect2($searchTerm = ""){
        $this->db->select('*');
        $this->db->where("id_rol", 2);
        $this->db->or_where("nombre like '%".$searchTerm."%' ");
        $this->db->or_where("id_usuario like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();
        $newRecords = $this->removeElementWithValue($records, 'id_rol', 1);
        $data = array();
        foreach($newRecords as $record){
           $data[] = array("id"=>$record['id_usuario'], "text"=>$record['id_usuario'].' - '.$record['nombre']);
        }
        return $data;
    }

    private function removeElementWithValue($array, $key, $value)
    {
        foreach ($array as $subKey => $subArray) {
            if ($subArray[$key] == $value) {
                unset($array[$subKey]);
            }
        }
        return $array;
    }

    public function getAll()
    {
        $this->db->select($this->tableName.'.*,'.$this->joinTableName.'.*');
        $this->db->from($this->tableName);
        $this->db->join($this->joinTableName, $this->joinTableName.'.'.$this->foreignKey.'='.$this->tableName.'.'.$this->foreignKey, 'inner');
        $query=$this->db->get();
        return $query->result();
    }

    public function getById($id)
    {
        $this->db->select($this->tableName.'.*,'.$this->joinTableName.'.*');
        $this->db->from($this->tableName);
        $this->db->join($this->joinTableName, $this->joinTableName.'.'.$this->foreignKey.'='.$this->tableName.'.'.$this->foreignKey, 'inner');
        $this->db->where($this->tableName.'.'.$this->primaryKey,$id);
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
