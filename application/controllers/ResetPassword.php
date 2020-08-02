<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ResetPassword extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {

            redirect('login');
        }
        $this->username = $this->session->userdata['username'];
        $this->CI =& get_instance();
        $this->load->model('ResetPasswordModel');
        $this->load->helper('url_helper');
        $this->load->library('form_validation');
        $this->load->library('authorization_token');
        $this->load->library('validateuser_library');
        $this->load->library('timejwt_library');
        $this->load->library('audit_library');
        $this->tableName = 'TTO_T_USUARIOS';
    }

    public function update($id){                                                                    
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isAdminUser($is_valid_token['data']->user_name)){
            if ($this->input->post()) {
                $password = xss_clean($this->input->post('password'));
                $passwordConfirm = xss_clean($this->input->post('confirmarpassword'));
                $oldPass = $this->input->post('oldPass');
                $pass =  getHashedPassword(xss_clean($this->input->post('password')));
                $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[55]');
                $this->form_validation->set_rules('confirmarpassword', 'Confirmar Password', 'trim|required|max_length[55]');

                if ($this->form_validation->run() == true) {
                    if ($user = $this->Usuarios_model->getByUserName($usuario)) {
                        if($user->ESTADO === 'P'){
                            $this->ResetPasswordModel->update($pass,$user->ID_USUARIO);
                            $this->Auditoria_model->update(
                                $this->audit_library->auditArray(
                                    $this->tableName,
                                    $user->ID_USUARIO,
                                    'ACTUALIZAR',
                                    $user->NOMBRE_USUARIO,
                                    'HORA_MOD',
                                    $oldPass,
                                    $pass,
                                    $this->input->ip_address()
                                )
                            );    
                        }
                    }
                    
                }
            }
    
    
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
}