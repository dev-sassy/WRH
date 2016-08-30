<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryServices extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('categoryServices_model');
    }

    public function index() {
        echo "Welcome to WRH";
    }

    public function setDefaultRules($field_details, $finfo = false) {
        $this->load->library('form_validation');
        $this->form_validation->set_data($field_details);

        $this->form_validation->set_rules('uniqueId', 'Unique id', 'trim|required');
        $this->form_validation->set_rules('deviceType', 'Device type', 'trim|required');

        if (!isset($finfo) && !$finfo) {
            $this->form_validation->set_rules('deviceToken', 'Device token', 'trim|required');
        }
    }

    public function addUniqueId() {
        $access_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($access_details);

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
            $response = $this->categoryServices_model->addUniqueId($access_details);
        }

        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    public function categoryList() {
        $category_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($category_details);

        $this->form_validation->set_rules('accessToken', 'access token', 'trim|required', array('required' => 'Forbidden request.'));

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

        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    public function categoryDetails() {
        $category_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($category_details);

        $this->form_validation->set_rules('accessToken', 'access token', 'trim|required', array('required' => 'Forbidden request.'));
        $this->form_validation->set_rules('categoryId', 'Category Id', 'trim|required|numeric');

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

        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    public function couponList() {
        $coupon_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($coupon_details);

        $this->form_validation->set_rules('accessToken', 'access token', 'trim|required', array('required' => 'Forbidden request.'));
        $this->form_validation->set_rules('categoryId', 'Category Id', 'trim|required|numeric');
        $this->form_validation->set_rules('index', 'page index', 'trim|numeric');

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
            if (!(isset($coupon_details['index']) && (int) $coupon_details['index'])) {
                $coupon_details['index'] = 1;
            }
            $response = $this->categoryServices_model->couponList($coupon_details);
        }

        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    public function couponDetails() {
        $coupon_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($coupon_details);

        $this->form_validation->set_rules('accessToken', 'access token', 'trim|required', array('required' => 'Forbidden request.'));
        $this->form_validation->set_rules('couponId', 'Coupon Id', 'trim|required|numeric');

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
            $response = $this->categoryServices_model->couponDetails($coupon_details);
        }

        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    public function saveCoupon() {
        $coupon_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($coupon_details, true);

        $this->form_validation->set_rules('couponId', 'Coupon Id', 'trim|required|numeric');

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
            $response = $this->categoryServices_model->saveCoupon($coupon_details);
        }

        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }
    
    public function discardCoupon() {
        $coupon_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($coupon_details, true);

        $this->form_validation->set_rules('couponId', 'Coupon Id', 'trim|required|numeric');

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
            $response = $this->categoryServices_model->discardCoupon($coupon_details);
        }

        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

}
