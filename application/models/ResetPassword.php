<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Actas_model extends CI_Model
{
    public function __construct()
    {
        $this->tableName =  "TTO_T_USUARIOS";
        $this->load->database();
    }

    public function update ($password,$id) {
        $this->db->update($this->tableName, , $where);
        return $this->db->affected_rows();
    }

}