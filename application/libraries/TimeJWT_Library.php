<?php defined('BASEPATH') or exit('No direct script access allowed');

class TimeJWT_Library
{
    public function __construct()
    {
        $this->CI =& get_instance();
        
    }

    public function convertToMillisecondsJWT($minutes)
    {
        $milliseconds = $minutes * 60000;
        return $milliseconds;
    }
    
    public function differenceTime($timeExpire, $timeLogin)
    {
        $minutosVigenciaToken = number_format(gmdate("i", $timeExpire), 2, '.',',');

        $fechaYHoraActual = new DateTime(date('y-m-d H:i:s', time()));
        $fechaYHoraLogin = new DateTime(date('y-m-d H:i:s', $timeLogin));
     
        $intervalo = $fechaYHoraLogin->diff($fechaYHoraActual);
        $minutosTranscurridos = $intervalo->format('%i.%s');
        
        if($minutosTranscurridos == 0.0){
            $tiempoSesion = number_format($this->convertToMillisecondsJWT($minutosVigenciaToken), 0, '.', '');
            $alertaSesion = $tiempoSesion / 2;   
            return array('alertaSesion' => $alertaSesion, 'tiempoSesion' => $tiempoSesion);
        }

        if($minutosTranscurridos < 0){
            $tiempoSesion = number_format($this->convertToMillisecondsJWT($minutosVigenciaToken), 0, '.', '');
            $alertaSesion = $tiempoSesion / 2;   
            return array('alertaSesion' => 500, 'tiempoSesion' => 1000);
        }

        if($minutosTranscurridos > 0.00 && $minutosTranscurridos < $minutosVigenciaToken){
            $minutosRestantes = $minutosVigenciaToken - $minutosTranscurridos;
            $tiempoSesion = number_format($this->convertToMillisecondsJWT($minutosRestantes), 0, '.', '');
            $alertaSesion = $tiempoSesion / 2;   
            return array('alertaSesion' => $alertaSesion, 'tiempoSesion' => $tiempoSesion);
        }
    }
}
