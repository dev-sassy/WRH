<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent:: __construct();
        $this->load->model('login_model');
    }

    public function index() {
        if ($this->session->userdata('USERNAME') !== NULL && $this->session->userdata('USERNAME') !== '') {
            redirect(base_url() . 'category', 'refresh');
        }

        $check_login["status"] = '';

        if ($this->input->post('chk_login')) {
            $check_login = $this->login_model->chk_login();
            if ($check_login["isSuccess"]) {
                $this->session->set_userdata('USERNAME', $this->input->post('username'));
                redirect(base_url() . 'category');
            }
        }

        $this->load->view('login_view', $check_login);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'login', 'refresh');
    }

}
