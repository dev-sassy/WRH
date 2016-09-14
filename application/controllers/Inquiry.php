<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();

        $this->load->model('inquiry_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     */

    public function index() {
        if ($this->session->userdata('USERNAME')) {
            $data['title'] = "Inquiry";
            $data['inq_detail'] = $this->inquiry_model->fetchInquiry();
            $data['inq_count'] = count($data['inq_detail']);
            $data['js'] = array("customs/inquiry");
            
            $data['content'] = $this->load->view("inquiry/view_inquiries", $data, true);
            $this->load->view("default_layout", $data);
        } else {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    public function setDefaultRules($field_details) {
        $this->load->library('form_validation');
        $this->form_validation->set_data($field_details);

        $this->form_validation->set_rules('accessToken', 'Access token', 'trim|required', array('required' => 'Forbidden access.'));
        $this->form_validation->set_rules('uniqueId', 'Unique Id', 'trim|required');
        $this->form_validation->set_rules('deviceType', 'Device type', 'trim|required');
        $this->form_validation->set_rules('deviceToken', 'Device token', 'trim|required');
    }

    public function addInquiry() {
        $inquiry_details = json_decode(file_get_contents('php://input'), true);
        $this->setDefaultRules($inquiry_details);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('inquiryName', 'Inquiry name', "trim|required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z' ]+$/]");
        $this->form_validation->set_rules('inquiryEmail', 'Inquiry email', 'trim|required|valid_email');
        $this->form_validation->set_rules('inquirySubject', 'Inquiry subject', 'trim|required');
        $this->form_validation->set_rules('inquiryMessage', 'Inquiry message', 'trim|required');
        $this->form_validation->set_rules('inquiryPhone', 'Inquiry phone', 'trim|required|min_length[10]|max_length[10]');

        // Default response.
        $response = array(
            'data' => NULL,
            'status' => 0,
            'responseMessage' => 'Server refused to process request. Please try again later.'
        );

        if ($this->form_validation->run() === FALSE) {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => strip_tags(validation_errors())
            );
        } else {
            $response = $this->inquiry_model->addInquiry($inquiry_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

}
