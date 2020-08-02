<?php defined('BASEPATH') or exit('No direct script access allowed');

class Audit_Library
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function auditArray($tabla, $filaid, $operacion, $usuario, $campo, $valorAntiguo, $valorNuevo, $ipOrigen)
    {
        $data = array(
            'TABLA' => $tabla,
            'FILAID' => $filaid,
            'OPERACION' => $operacion,
            'FECHAHORA' => date('d-M-y h:i:s A'),
            'USUARIO' => $usuario,
            'CAMPO' => $campo,
            'VALORANTIGUO' => $valorAntiguo,
            'VALORNUEVO' => $valorNuevo,
            'IPORIGEN' => $ipOrigen,
            'APP' => 'TRANSITO'
        );

        return $data;
    }

    public function diffInData($oldRecords, $newRecords)
    {
        $old = (array) $oldRecords;
        $new = (array) $newRecords;
        $result = array_diff_assoc($new, $old);
        return $result;
    }
}