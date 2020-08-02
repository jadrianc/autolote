<?php
defined('BASEPATH') or exit('No direct script access allowed');
class LoginUserLog_model extends CI_Model
{
    public function __construct()
    {
        $this->tableName =  "TTO_T_USERLOG";
        $this->primaryKey =  "ID_LOG_LOGIN";
        $this->load->database();
    }

    public function create($data)
    {
        $this->db->insert($this->tableName, $data);
    }
}
