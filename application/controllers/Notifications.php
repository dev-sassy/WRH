<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {
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
        $data['title'] = "View All Notifications";

        $data['content'] = $this->load->view("notification", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function addnotifications() {
        $data['title'] = "Add Notifications";

        $data['content'] = $this->load->view("add_notification", $data, true);
        $this->load->view("default_layout", $data);
    }

}
