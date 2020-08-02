<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CentrosCostos_model extends CI_Model
{
    public function __construct()
    {
        $this->tableName =  "C_CCOSTOAF";
        $this->primaryKey =  "CCOSTO";
        $this->load->database();
    }

    public function getSelect2($searchTerm = "")
    {
        $this->db->select('*');
        $this->db->where("NOM_COS like '%".$searchTerm."%' ");
        $this->db->or_where("CCOSTO like '%".$searchTerm."%' ");
        $this->db->order_by("CCOSTO", "ASC");
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();
        $newRecords = $this->removeElementWithValue($records, 'ESTADO', 'I');
        $data = array();
        foreach ($newRecords as $record) {
            $data[] = array("id"=>$record['CCOSTO'], "text"=>$record['CCOSTO'].' - '.$record['NOM_COS']);
        }
        return $data;
    }

    public function getSelect2Exclude($searchTerm = "", $exclude)
    {
        $this->db->select('*');
        $this->db->where("NOM_COS like '%".$searchTerm."%' ");
        $this->db->or_where("CCOSTO like '%".$searchTerm."%' ");
        $this->db->where_in("ESTADO", "A");
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();
        $ccostoActivos = $this->removeElementWithValue($records, 'ESTADO', 'I');
        $newRecords = $this->removeElementWithValue($ccostoActivos, 'CCOSTO', $exclude);
        $data = array();
        foreach ($newRecords as $record) {
            $data[] = array("id"=>$record['CCOSTO'], "text"=>$record['CCOSTO'].' - '.$record['NOM_COS']);
        }
        return $data;
    }

    public function getSelect2CCostosDescargo($searchTerm = "")
    {
        $this->db->select('*');
        $ccostos = array('16999901  ', '16999902  ');
        $this->db->where_in('CCOSTO', $ccostos);
        $this->db->where("CCOSTO like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['CCOSTO'], "text"=>$record['CCOSTO'].' - '.$record['NOM_COS']);
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

    public function getFilterSelect2($searchTerm = "", $include)
    {
        $this->db->select('*');
        $this->db->where("NOM_COS like '%".$searchTerm."%' ");
        $this->db->or_where("CCOSTO like '%".$searchTerm."%' ");
        $this->db->where_in("ESTADO", "A");
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();
        $ccostoActivos = $this->removeElementWithValue($records, 'ESTADO', 'I');
        $newRecords = $this->removeFilter($ccostoActivos, 'CCOSTO', $include);
        $data = array();
        foreach ($newRecords as $record) {
            $data[] = array("id"=>$record['CCOSTO'], "text"=>$record['CCOSTO'].' - '.$record['NOM_COS']);
        }
        return $data;
    }

    private function removeFilter($array, $key, $value)
    {
        foreach ($array as $subKey => $subArray) {
            if ($subArray[$key] !== $value) {
                unset($array[$subKey]);
            }
        }
        return $array;
    }


    public function getAll()
    {
        $this->db->from($this->tableName);
        $query=$this->db->get();
        return $query->result();
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->join("CATALOGOSPNC.CT_DEPENDENCIAS", $this->tableName.'.IDIMPERIUM = CATALOGOSPNC.CT_DEPENDENCIAS.ID', 'LEFT');
        $this->db->where($this->primaryKey, $id);
        $query = $this->db->get();
  
        return $query->row();
    }

    public function getByIdNotJoin($id)
    {
        $this->db->select('*');
        $this->db->from($this->tableName);
        $this->db->where($this->primaryKey, $id);
        $query = $this->db->get();
  
        return $query->row();
    }


    public function getAdscritasById($id)
    {
        $this->db->from($this->tableName);
        $query=$this->db->get();
        $this->db->like($this->primaryKey, $id, 'after');
        $this->db->where("ESTADO", "A");
        $this->db->order_by("CCOSTO", "ASC");
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

    public function getIdCcostoByDependencia($oni_asignado){
        $this->db->select('C_CCOSTOAF.CCOSTO as IDCCOSTO');
        $this->db->from('C_CCOSTOAF');
        $this->db->join('CATALOGOSPNC.PERSONALIMPERIUM', 'CATALOGOSPNC.PERSONALIMPERIUM.IDUBI =  C_CCOSTOAF.IDIMPERIUM', 'RIGHT');
        $this->db->where('CATALOGOSPNC.PERSONALIMPERIUM.CODPER', $oni_asignado);
        $query = $this->db->get();
  
        return $query->row();


    }
}
