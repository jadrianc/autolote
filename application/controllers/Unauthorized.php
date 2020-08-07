<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Unauthorized extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /*if ($this->session->userdata('username')) {
            redirect('inicio');
        }*/
    }

    public function index()
    {
        $data['title'] = 'Export | 401 No Autorizado'; // Capitalize the first letter
        $this->load->helper('url');
        $this->load->view('unauthorized', $data);
        $this->load->view('templates/footer', $data);
    }
}
