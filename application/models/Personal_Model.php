<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Personal_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getNombreById($oni)
    {
        $this->db->where("CODPER", $oni);
        $fetched_records = $this->db->get("PERSONALIMPERIUM");
        $records = $fetched_records->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array("nombre"=>$record['NOMPER'].' '.$record['APEPER'], "cargo" => $record['CARNOM'], "unidad" => $record['NOMUNIDAD'], "inuniorg" => $record['INUNIORG']);
        }
        return $data;
    }

    public function getNombreByIdTalonarios($oni)
    {
        $this->db->select('TTO_CE_ONIAUT.*, PERSONALIMPERIUM.NOMPER, PERSONALIMPERIUM.APEPER, TTO_C_UNIDADES.ID_FILA, TTO_C_UNIDADES.NOMBRE, PERSONALIMPERIUM.CARNOM, PERSONALIMPERIUM.DEPUESTO');
        $this->db->from('TTO_CE_ONIAUT');
        $this->db->join('PERSONALIMPERIUM', 'TTO_CE_ONIAUT.ONI = PERSONALIMPERIUM.CODPER');
        $this->db->join('TTO_C_UNIDADES', 'TTO_C_UNIDADES.ID_FILA = TTO_CE_ONIAUT.ID_UNIDAD');
        $this->db->where('TTO_CE_ONIAUT.ONI', $oni);
        
        $query = $this->db->get();
        return $query->row();
    }

    public function datosPersona($oni)
    {
        $this->db->select("NOMPER,APEPER,DEPUESTO,NOMUNIDAD,IDUBI, INUNIORG");
        $this->db->from("PERSONALIMPERIUM");
        $this->db->where("CODPER", $oni);
        $query = $this->db->get();
        return $query->row();
    }

    public function getUnidadTransitoByOni($oni){
        
    }
}
