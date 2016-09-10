<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invite extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();

        // Check for session if user logged-in.
        if ($this->session->userdata('USERNAME') === NULL || $this->session->userdata('USERNAME') === '') {
            redirect(base_url(), 'refresh');
        }

        $this->load->model('invite_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     */

    public function index() {
        $data['title'] = "Invite";

        $data['content'] = $this->load->view("invite", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function viewInvites() {
        $data['invites'] = $this->invite_model->viewInvites(array(), TRUE);
        $data['invites'] = $data['invites']['data'];
        $data['invite_count'] = count($data['invites']);
        $data['title'] = "Invite View";

        $data['content'] = $this->load->view("invite/view_invites", $data, true);
        $this->load->view("default_layout", $data);
    }

}
