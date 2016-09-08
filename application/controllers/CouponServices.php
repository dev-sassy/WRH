<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CouponServices extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent::__construct();
        $this->load->model('couponServices_model');
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
     * listCoupons() --> Decode request containing JSON data & validate fields.
     * --> Fetch all coupons either by vendor id, category id or both.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function listCoupons() {
        $field_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($field_details);

        $this->form_validation->set_rules('categoryId', 'Category Id', 'trim|numeric');
        $this->form_validation->set_rules('vendorId', 'Vendor Id', 'trim|numeric');
        $this->form_validation->set_rules('index', 'page index', 'trim|numeric'); // For pagination.
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
            // Add index field, if request doesn't contains for pagination.
            if (!(isset($field_details['index']) && (int) $field_details['index'])) {
                $field_details['index'] = 1;
            }
            $response = $this->couponServices_model->listCoupons($field_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    /*
     * couponsByCategory() --> Decode request containing JSON data & validate fields.
     * --> Fetch all coupons by category id.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function couponsByCategory() {
        $category_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($category_details);
        $this->form_validation->set_rules('categoryId', 'Category Id', 'trim|required|numeric');
        $this->form_validation->set_rules('index', 'page index', 'trim|numeric'); // For pagination.
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
            // Add index field, if request doesn't contains for pagination.
            if (!(isset($category_details['index']) && (int) $category_details['index'])) {
                $category_details['index'] = 1;
            }
            $response = $this->couponServices_model->couponsByCategory($category_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    /*
     * couponsByVendor() --> Decode request containing JSON data & validate fields.
     * --> Fetch all coupons by vendor id.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function couponsByVendor() {
        $vendor_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($vendor_details);
        $this->form_validation->set_rules('vendorId', 'Vendor Id', 'trim|required|numeric');
        $this->form_validation->set_rules('index', 'page index', 'trim|numeric'); // For pagination.
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
            // Add index field, if request doesn't contains for pagination.
            if (!(isset($vendor_details['index']) && (int) $vendor_details['index'])) {
                $vendor_details['index'] = 1;
            }
            // Fetch coupons from db by vendor id.
            $response = $this->couponServices_model->couponsByVendor($vendor_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    /*
     * couponDetails() --> Decode request containing JSON data & validate fields.
     * --> Fetch coupon details by coupon id.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function couponDetails() {
        $coupon_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($coupon_details);
        $this->form_validation->set_rules('couponId', 'Coupon Id', 'trim|required|numeric');
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
            $response = $this->couponServices_model->couponDetails($coupon_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    /*
     * saveCoupon() --> Decode request containing JSON data & validate fields.
     * --> Save coupon by coupon id.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function saveCoupon() {
        $coupon_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($coupon_details);
        $this->form_validation->set_rules('couponId', 'Coupon Id', 'trim|required|numeric');

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
            $response = $this->couponServices_model->saveCoupon($coupon_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    /*
     * discardCoupon() --> Decode request containing JSON data & validate fields.
     * --> Discard coupon by coupon id i.e. delete the coupon.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function discardCoupon() {
        $coupon_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($coupon_details);

        $this->form_validation->set_rules('couponId', 'Coupon Id', 'trim|required|numeric');

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
            $response = $this->couponServices_model->discardCoupon($coupon_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    /*
     * redeemCoupon() --> Decode request containing JSON data & validate fields.
     * --> Redeem coupon by coupon id i.e. check the coupon that are not reached its limit.
     * @return: application/json --> Encode the reponse containing JSON data.
     */

    public function redeemCoupon() {
        $coupon_details = json_decode(file_get_contents('php://input'), true);

        $this->setDefaultRules($coupon_details);

        $this->form_validation->set_rules('couponId', 'Coupon Id', 'trim|required|numeric');

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
            $response = $this->couponServices_model->redeemCoupon($coupon_details);
        }

        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

}
