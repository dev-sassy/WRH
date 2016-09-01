<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends CI_Controller {

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
        parent:: __construct();
        $this->load->model('couponServices_model');
    }

    public function index() {
        $this->viewCoupons();
    }

    public function viewCoupons() {
        $data['coupons'] = $this->couponServices_model->viewAllCoupons(array(), true);
        $data['coupon_count'] = count($data['coupons']);
        $data['title'] = "Coupon View";

        $data['content'] = $this->load->view("coupon/view_coupons", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function startDate_validation($str) {
        $dt = new DateTime('now');
        $dt = $dt->format('Y-m-d H:i:s');

        if ($str < $dt) {
            $this->form_validation->set_message("startDate_validation", 'Start date-time should greater then current date-time.');
            return FALSE;
        }
        return TRUE;
    }

    public function expiryDate_validation($str) {
        $dt = new DateTime('now');
        $dt = $dt->format('Y-m-d H:i:s');

        $start = strtotime($this->input->post('startDate'));
        $expriry = strtotime($this->input->post('expiryDate'));

        if ($start > $expriry) {
            $this->form_validation->set_message('expiryDate_validation', 'Your start date-time must be earlier than your expiry date-time');
            return FALSE;
        }
        return TRUE;
    }

    public function addCoupon() {
        $this->load->helper('form');

        if ($this->input->post('add_coupon')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('categoryId', 'Category Id', 'trim|required|numeric');
            $this->form_validation->set_rules('couponName', 'Coupon name', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('couponCode', 'Coupon code', 'trim|required|numeric');
            $this->form_validation->set_rules('startDate', 'Start date', 'trim|required|callback_startDate_validation');
            $this->form_validation->set_rules('expiryDate', 'Expiry date', 'trim|required|callback_expiryDate_validation');
            $this->form_validation->set_rules('couponLimit', 'Coupon Limit', 'trim|required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->couponServices_model->addCoupon();
                if ($flag) {
                    redirect(base_url() . 'coupons/viewCoupons');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'coupons/addCoupon', 'refresh');
            }
        }

        $data['title'] = "Add Coupon";
        $data['js'] = array("coupons");
        $data['content'] = $this->load->view("coupon/add_coupon", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function editCoupon($couponId) {
        $this->load->helper('form');

        if ($this->input->post('edit_coupon')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('categoryId', 'Category Id', 'trim|required|numeric');
            $this->form_validation->set_rules('couponName', 'Coupon name', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('couponCode', 'Coupon code', 'trim|required|numeric');            
            $this->form_validation->set_rules('expiryDate', 'Expiry date', 'trim|required|callback_expiryDate_validation');
            $this->form_validation->set_rules('couponLimit', 'Coupon Limit', 'trim|required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->couponServices_model->updateCoupon($this->input->post('couponId'));
                if ($flag) {
                    redirect(base_url() . 'coupons/viewCoupons');
                } else {
                    redirect(base_url() . 'coupons');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'coupons/editCoupon/' . $couponId, 'refresh');
            }
        }

        $data['coupon_details'] = $this->couponServices_model->editCoupon($couponId);
        $data['js'] = array("coupons");
        $data['title'] = "Edit Coupon";
        $data['content'] = $this->load->view("coupon/edit_coupon", $data, true);
        $this->load->view("default_layout", $data);
    }
    
    public function deleteCoupon($couponId) {
        $flag = $this->couponServices_model->deleteCoupon($couponId);
        if ($flag) {
            redirect(base_url() . 'coupons/viewCoupons');
        } else {
            redirect(base_url() . 'coupons');
        }
    }

}
