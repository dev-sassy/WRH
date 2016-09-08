<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryServices extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('categoryServices_model');
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

    /*
     * categoryList() --> Decode request containing JSON data & validate fields.
     * --> Fetch all categories.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function categoryList() {
        $category_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($category_details);

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
            $response = $this->categoryServices_model->categoryList($category_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    /*
     * categoryDetails() --> Decode request containing JSON data & validate fields.
     * --> Fetch category by category id.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function categoryDetails() {
        $category_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($category_details);
        $this->form_validation->set_rules('categoryId', 'Category Id', 'trim|required|numeric');

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
            $response = $this->categoryServices_model->categoryDetails($category_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

}
