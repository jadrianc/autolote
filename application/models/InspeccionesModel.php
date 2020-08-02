<?php
defined('BASEPATH') or exit('No direct script access allowed');
class InspeccionesModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function buscarAvances($direccion, $codigo, $fecha){
        
    }

}