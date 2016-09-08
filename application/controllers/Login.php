<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();
    }

    /*
     * index() --> Default function whenever the controller is called.
     * --> Load login page, create user session if not logged-in.
     */

    public function index() {
        // Check for session if user logged-in.
        if ($this->session->userdata('USERNAME') !== NULL && $this->session->userdata('USERNAME') !== '') {
            redirect(base_url() . 'category', 'refresh');
        }
        $this->load->model('login_model');

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

    /*
     * logout() --> Destroy the user session.
     * --> Redirect to login page.
     */

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'login', 'refresh');
    }

}
