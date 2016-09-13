<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationServices extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('notification_model');
    }

    public function notificationsList() {        
        // Default response.
        $response = array(
            'data' => NULL,
            'status' => 0,
            'responseMessage' => 'Server refused to process request. Please try again later.'
        );

        $response = $this->notification_model->notificationsList();

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

}
