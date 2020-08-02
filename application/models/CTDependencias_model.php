<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CTDependencias_model extends CI_Model
{
    public function __construct()
    {
        $this->tableName =  "CATALOGOSPNC.CT_DEPENDENCIAS";
        $this->primaryKey =  "ID";
        $this->load->database();
    }

    public function getSelect2($searchTerm = "")
    {
        $this->db->select("ID, CONCAT(CONCAT(NOMBRE, ' - '), DESCRIPCION) AS DEPENDENCIA");
        $this->db->like("CONCAT(CONCAT(NOMBRE, ' - '), DESCRIPCION)", $searchTerm);
        $this->db->where_not_in("IDDEP", NULL);
        $fetched_records = $this->db->get($this->tableName);
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("id"=>$record['ID'], "text"=>$record['DEPENDENCIA']);
        }
        return $data;
    }
}
