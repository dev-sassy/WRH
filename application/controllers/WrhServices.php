<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WrhServices extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('wrhServices_model');
    }

    /*
     * addUniqueId() --> Decode request containing JSON data & validate fields.
     * --> Add unique id, device type, device token and access token.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function addUniqueId() {
        $access_details = json_decode(file_get_contents('php://input'), true);

        $this->load->library('form_validation');

        $this->form_validation->set_data($access_details);
        $this->form_validation->set_rules('uniqueId', 'Unique id', 'trim|required');
        $this->form_validation->set_rules('deviceType', 'Device type', 'trim|required');
        $this->form_validation->set_rules('deviceToken', 'Device token', 'trim|required');
        
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
            $response = $this->wrhServices_model->addUniqueId($access_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

}
