<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InviteServices extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('invite_model');
    }

    /*
     * setDefaultRules() --> Common function to set default validation rules.
     * @param: param1 array --> No. of fields to validate rules against.
     */

    public function setDefaultRules($field_details) {
        $this->load->library('form_validation');
        $this->form_validation->set_data($field_details);

        $this->form_validation->set_rules('accessToken', 'Access token', 'trim|required', array('required' => 'Forbidden access.'));
        $this->form_validation->set_rules('uniqueId', 'Unique Id', 'trim|required');
        $this->form_validation->set_rules('deviceType', 'Device type', 'trim|required');
        $this->form_validation->set_rules('deviceToken', 'Device token', 'trim|required');
    }

    public function send_mail($from, $to, $subject, $message) {
        $this->email->clear();
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from($from, 'WRH');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        //Send mail 
        if ($this->email->send()) {
            return "Email sent successfully.";
        } else {
            return "Error in sending Email.";
        }
    }

    public function addInvite() {
        $invite_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($invite_details);
        $this->form_validation->set_rules('recipientName', 'Recipient name', "trim|required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z' ]+$/]");
        $this->form_validation->set_rules('recipientEmail', 'Recipient email', 'trim|required|valid_email|is_unique[wrh_invite.recipientEmail]', array("is_unique" => "Email already exist. Please try different email-id."));
        $this->form_validation->set_rules('recipientPhone', 'Recipient phone', 'trim|required|min_length[10]|max_length[10]|is_unique[wrh_invite.recipientPhone]', array("is_unique" => "Phone number already registered."));

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
            $response = $this->invite_model->addInvite($invite_details);
            if ($response['data']) {
                $to = $response['data']['recipientEmail'];
                $subject = "Setup app";
                $message = "Hello " . $response['data']['recipientName'] . ",<br/><br/>";
                $message .= "Please follow the link to install app: <br/><br/>";
                $message .= "<a href='https://play.google.com/store?hl=en' target='_blank'>"
                        . "<img src='" . ASSETS_URL . "images/PlayStore.ico' height='50' width='50' alt='Google play-store' /></a>";
                $message .= "&nbsp;&nbsp;&nbsp;<a href='https://www.appstore.com/' target='_blank'>"
                        . "<img src='" . ASSETS_URL . "images/AppStore.ico' height='50' width='50' alt='Apple play-store' /></a>";
                $response['responseMessage'] .= " " . $this->send_mail(FROM_EMAIL, $to, $subject, $message);
            }
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    public function viewInvites() {
        $invite_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($invite_details);

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
            $response = $this->invite_model->viewInvites($invite_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

}
