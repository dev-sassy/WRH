<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribers extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();

        // Check for session if user logged-in.
        if ($this->session->userdata('USERNAME') === NULL || $this->session->userdata('USERNAME') === '') {
            redirect(base_url(), 'refresh');
        }
        $this->load->model('subscriberServices_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     */

    public function index() {
        $this->viewSubscribers();
    }

    public function viewSubscribers() {
        $data['subscribers'] = $this->subscriberServices_model->subscribersList(array(), TRUE);
        $data['subscribers'] = $data['subscribers']['data'];
        $data['subscribers_count'] = count($data['subscribers']);
        $data['title'] = "Subscribers View";
        $data['js'] = array("customs/subscriber");

        $data['content'] = $this->load->view("subscriber/view_subscribers", $data, true);
        $this->load->view("default_layout", $data);
    }

}
