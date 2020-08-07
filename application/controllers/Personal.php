<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Personal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('environment') != ENVIRONMENT) {

            redirect('login');
        }
        $this->CI =& get_instance();
        $this->load->model('Personal_model');
        $this->load->helper('url_helper');
        $this->load->library('authorization_token');
        $this->load->library('validateuser_library');
    }

    public function getNombreById()
    {
        $is_valid_token = $this->authorization_token->validateToken();
        if (!empty($is_valid_token) and $is_valid_token['status'] === true && $this->validateuser_library->isValidUser($is_valid_token['data']->user_name,$roles = array(1,2,3,4,5,6))) {
            $status = false;
            $arr = array('success' => $status, 'data' => '');
            if ($this->input->post()) {
                $oni = $this->input->post('oni');
                $data = $this->Personal_model->getNombreById(strtoupper($oni));
                if ($data) {
                    $status = true;
                    $arr = array('success' => $status, 'data' => $data);
                }
            }
            echo json_encode($arr);
        } else {
            $this->output->set_header('HTTP/1.0 401 UNAUTHORIZED');
            echo json_encode(array("status" => 401, 'data' => 'UNAUTHORIZED'));
        }
    }

    
}
