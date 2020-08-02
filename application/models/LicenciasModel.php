<?php
defined('BASEPATH') or exit('No direct script access allowed');
class LicenciasModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getByLicencia($licencia)
    {
        $this->db->select("*");
        $this->db->from("LICSERTR");
        $this->db->where("NO_DOCTO", $licencia);

        $fetched_records = $this->db->get();
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array(
            
            "nombre" => $record["NOMBRE"],
            "apellidos"=>$record['APE_PAT'].' '.$record['APE_MAT']
        
        );
        }
        return $data;
    }
}