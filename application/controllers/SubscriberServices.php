<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SubscriberServices extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();
        $this->load->model('subscriberServices_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     */

    public function index() {
        $this->subscribersList();
    }

    public function setDefaultRules($field_details) {
        $this->load->library('form_validation');
        $this->form_validation->set_data($field_details);

        $this->form_validation->set_rules('accessToken', 'Access token', 'trim|required', array('required' => 'Forbidden access.'));
        $this->form_validation->set_rules('uniqueId', 'Unique Id', 'trim|required');
        $this->form_validation->set_rules('deviceType', 'Device type', 'trim|required');
        $this->form_validation->set_rules('deviceToken', 'Device token', 'trim|required');
    }

    public function subscribersList() {
        $subscriber_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($subscriber_details);
//        $this->load->library('form_validation');        
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
            $response = $this->subscriberServices_model->subscribersList($subscriber_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    public function subscribeUser() {
        $subscriber_details = json_decode(file_get_contents('php://input'), true);

//        $this->setDefaultRules($subscriber_details);
        $this->load->library('form_validation');
        $this->form_validation->set_data($subscriber_details);
        $this->form_validation->set_rules('subscriberEmailId', 'Email Id', 'trim|required|valid_email|is_unique[wrh_subscribers.subscriberEmailId]');

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
            $response = $this->subscriberServices_model->subscribeUser($subscriber_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    public function unsubscribeUser() {
        $subscriber_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($subscriber_details);
        $this->form_validation->set_rules('subscriberEmailId', 'Email Id', 'trim|required|valid_email');

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
            $response = $this->subscriberServices_model->unsubscribeUser($subscriber_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

}
