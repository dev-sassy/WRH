<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends CI_Controller {
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
        $data['title'] = "Inquiry";

        $data['content'] = $this->load->view("inquiry", $data, true);
        $this->load->view("default_layout", $data);
    }

}
