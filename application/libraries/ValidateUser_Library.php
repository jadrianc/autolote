<?php defined('BASEPATH') or exit('No direct script access allowed');

class ValidateUser_Library
{
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Usuarios_model');
    }

    public function getRolUser($user)
    { 
      $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
      return $userInfo->ID_ROL;
    }

    public function isAdminUser($user)
    {
      $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
      if($userInfo->ID_ROL === "1" || $userInfo->ID_ROL === "6"){
          return true;
      } else {
          return false;
      }
    }

    public function returnOptionUser($user)
    {
      $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
      return "validacion".$userInfo->ID_ROL;
    }

    public function returnCcosto ($user) {
      $userInfo = $this->CI->Usuarios_model->getByUserName($user);
      return $userInfo->NOMBRE;
    }

    public function returnPrefijoAcc ($user) {
      $userInfo = $this->CI->Usuarios_model->getByUserName($user);
      return $userInfo->PREFIJO_ACC;
    }


    public function returnIdUnidadTTO ($user) {
      $userInfo = $this->CI->Usuarios_model->getByUserName($user);
      return $userInfo->UNIDAD;
    }

    public function isValidUser($user,$roles)
    {
      $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
      if($userInfo && in_array($userInfo->ID_ROL, $roles)){
          return true;
      } else {
          return false;
      }
    } 
    
    public function verifyUser($user)
    {
      $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
      if($userInfo){
          return true;
      } else {
          return false;
      }
    } 

    public function ONIByUser($user)
    {
      $userInfo =  $this->CI->Usuarios_model->getByUserName($user);
      if($userInfo){
          return $userInfo->CODPER;
      } else {
          return NULL;
      }
    }  
    
    public function createGUIDSession()
    {
          // Create a token
          $token      = $_SERVER['HTTP_HOST'];
          $token     .= $_SERVER['REQUEST_URI'];
          $token     .= uniqid(rand(), true);
          
          // GUID is 128-bit hex
          $hash        = strtoupper(md5($token));
          
          // Create formatted GUID
          $guid        = '';
          
          // GUID format is XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX for readability    
          $guid .= substr($hash,  0,  8) . 
              '-' .
              substr($hash,  8,  4) .
              '-' .
              substr($hash, 12,  4) .
              '-' .
              substr($hash, 16,  4) .
              '-' .
              substr($hash, 20, 12);
                  
          return $guid;
    }
}