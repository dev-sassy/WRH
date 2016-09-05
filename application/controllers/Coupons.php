<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends CI_Controller {

    public $upload_data = array();

    public function __construct() {
        parent:: __construct();

        if ($this->session->userdata('USERNAME') === NULL || $this->session->userdata('USERNAME') === '') {
            redirect(base_url(), 'refresh');
        }
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

    public function getCategoryList() {
        $categories = $this->couponServices_model->fetchCategories();

        $category_options = array();
        $category_options[""] = "-- Select category --";
        foreach ($categories as $item) {
            $category_options[$item['categoryId']] = $item['categoryName'];
        }
        return $category_options;
    }

    public function getVendorList() {
        $vendors = $this->couponServices_model->fetchVendors();

        $vendor_options = array();
        $vendor_options[""] = "-- Select vendor --";
        foreach ($vendors as $company) {
            $vendor_options[$company['vendorId']] = $company['vendorName'];
        }
        return $vendor_options;
    }

    function validate_image() {
        if ($_FILES && $_FILES['couponImage']['size'] !== 0) {
            $upload_dir = './images/coupon';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $_FILES['couponImage']['name'];
            $config['overwrite'] = FALSE;
            $config['max_size'] = 1024;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('couponImage')) {
                $this->form_validation->set_message('validate_image', 'File size should be <= 1 MB.');
                return FALSE;
            } else {
                $this->upload_data = $this->upload->data();
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    public function addCoupon() {
        $this->load->helper('form');

        if ($this->input->post('add_coupon')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('categoryId', 'Category name', 'trim|required|numeric');
            $this->form_validation->set_rules('vendorId', 'Vendor name', 'trim|required|numeric');
            $this->form_validation->set_rules('couponName', 'Coupon name', "trim|required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z' ]+$/]");
            $this->form_validation->set_rules('couponImage', 'Coupon image', "callback_validate_image");
            $this->form_validation->set_rules('couponCode', 'Coupon code', 'trim|required|numeric');
            $this->form_validation->set_rules('startDate', 'Start date', 'trim|required|callback_startDate_validation');
            $this->form_validation->set_rules('expiryDate', 'Expiry date', 'trim|required|callback_expiryDate_validation');
            $this->form_validation->set_rules('couponLimit', 'Coupon Limit', 'trim|required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->couponServices_model->addCoupon($this->upload_data);
                if ($flag) {
                    $this->session->set_flashdata('success_message', 'Coupon added successfully.');
                    redirect(base_url() . 'coupons/viewCoupons', 'refresh');
                } else {
                    $this->session->set_flashdata('error_message', 'Please try again.');
                    redirect(base_url() . 'coupons/addCoupon', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'coupons/addCoupon', 'refresh');
            }
        }

        $data['categories'] = $this->getCategoryList();
        $data['vendors'] = $this->getVendorList();
        $data['title'] = "Add Coupon";
        $data['js'] = array("customs/coupons");
        $data['content'] = $this->load->view("coupon/add_coupon", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function editCoupon($couponId) {
        $this->load->helper('form');

        if ($this->input->post('edit_coupon')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('categoryId', 'Category name', 'trim|required');
            $this->form_validation->set_rules('couponName', 'Coupon name', "trim|required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z' ]+$/]");
            $this->form_validation->set_rules('couponImage', 'Coupon image', "callback_validate_image");
            $this->form_validation->set_rules('couponCode', 'Coupon code', 'trim|required|numeric');
            $this->form_validation->set_rules('expiryDate', 'Expiry date', 'trim|required|callback_expiryDate_validation');
            $this->form_validation->set_rules('couponLimit', 'Coupon Limit', 'trim|required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->couponServices_model->updateCoupon($this->input->post('couponId'), $this->upload_data);
                if ($flag) {
                    $this->session->set_flashdata('success_message', 'Coupon details updated successfully.');
                    redirect(base_url() . 'coupons/viewCoupons', 'refresh');
                } else {
                    $this->session->set_flashdata('error_message', 'Please try again.');
                    redirect(base_url() . 'coupons/editCoupon/' . $couponId, 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'coupons/editCoupon/' . $couponId, 'refresh');
            }
        }

        $data['coupon_details'] = $this->couponServices_model->editCoupon($couponId);
        if (!$data['coupon_details']) {
            redirect(base_url() . 'coupons', 'refresh');
        }
        $data['categories'] = $this->getCategoryList();
        $data['vendors'] = $this->getVendorList();
        $data['js'] = array("customs/coupons");
        $data['title'] = "Edit Coupon";
        $data['content'] = $this->load->view("coupon/edit_coupon", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function deleteCoupon($couponId) {
        $flag = $this->couponServices_model->deleteCoupon($couponId);
        if ($flag) {
            $this->session->set_flashdata('success_message', 'Coupon deleted successfully.');
            redirect(base_url() . 'coupons/viewCoupons', 'refresh');
        } else {
            $this->session->set_flashdata('error_message', 'Please try again.');
            redirect(base_url() . 'coupons', 'refresh');
        }
    }

}
