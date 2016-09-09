<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_settings extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();

        // Check for session if user logged-in.
        if ($this->session->userdata('USERNAME') === NULL || $this->session->userdata('USERNAME') === '') {
            redirect(base_url(), 'refresh');
        }
        $this->load->model('categoryServices_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     */

    public function index() {
        $data['title'] = "User Settings";

        $data['content'] = $this->load->view("user_settings", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function change_password() {
        $data['title'] = "Change password";

        $data['content'] = $this->load->view("change_password", $data, true);
        $this->load->view("default_layout", $data);
    }

}
