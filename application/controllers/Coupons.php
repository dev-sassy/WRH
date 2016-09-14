<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends CI_Controller {

    public $upload_data = array(); // To store uploaded image data/info.

    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();

        // Check for session if user logged-in.
        if ($this->session->userdata('USERNAME') === NULL || $this->session->userdata('USERNAME') === '') {
            redirect(base_url(), 'refresh');
        }
        $this->load->model('couponServices_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     */

    public function index() {
        $this->viewCoupons();
    }

    /*
     * viewCoupons() --> View coupons page is loaded.
     */

    public function viewCoupons() {
        $data['coupons'] = $this->couponServices_model->viewAllCoupons(array(), true);
        $data['coupon_count'] = count($data['coupons']);
        $data['title'] = "Coupon View";
        $data['js'] = array("customs/confirmation_modal", "customs/coupons");

        $data['content'] = $this->load->view("coupon/view_coupons", $data, true);
        $this->load->view("default_layout", $data);
    }

    /*
     * startDate_validation() --> Validate start date-time, must be greater than now.
     * @param: param1 datetime
     * @retrun: bool true/false
     */

    public function startDate_validation($str) {
        $dt = date('Y-m-d');
        
        if ($str < $dt) {
            $this->form_validation->set_message("startDate_validation", 'Start date-time should greater then current date-time.');
            return FALSE;
        }
        return TRUE;
    }

    /*
     * expiryDate_validation() --> Validate expiry date-time, must be greater than now and start date-time.
     * @param: param1 datetime
     * @retrun: bool true/false
     */

    public function expiryDate_validation($str) {
        $dt = new DateTime('now');
        $dt = $dt->format('Y-m-d H:i:s');

        $start = strtotime($this->input->post('startDate'));
        $expriry = strtotime($this->input->post('expiryDate'));

        if ($start > $expriry) {
            $this->form_validation->set_message('expiryDate_validation', 'Your start date-time must be earlier than your expiry date-time.');
            return FALSE;
        }
        return TRUE;
    }

    /*
     * getCategoryList() --> Fetch all categories, to display in category drop-down.     
     * @retrun: array(key, value) -> (category id, category name)
     */

    public function getCategoryList() {
        $categories = $this->couponServices_model->fetchCategories();

        $category_options = array();
        $category_options[""] = "-- Select category --";
        foreach ($categories as $item) {
            $category_options[$item['categoryId']] = $item['categoryName'];
        }
        return $category_options;
    }

    /*
     * getVendorList() --> Fetch all vendors, to display in vendor drop-down.     
     * @retrun: array(key, value) -> (vendor id, vendor name)
     */

    public function getVendorList() {
        $vendors = $this->couponServices_model->fetchVendors();

        $vendor_options = array();
        $vendor_options[""] = "-- Select vendor --";
        foreach ($vendors as $company) {
            $vendor_options[$company['vendorId']] = $company['vendorName'];
        }
        return $vendor_options;
    }

    /*
     * validate_image() --> Upload image & validate if it's an image file & <= 1MB.
     * @return: bool true/false
     */

    function validate_image() {
        if ($_FILES && $_FILES['couponImage']['size'] !== 0) {
            $upload_dir = './images/coupon';

            if (!is_dir($upload_dir)) { // Create directory if not exists.
                mkdir($upload_dir, 0777, true);
            }
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $_FILES['couponImage']['name'];
            $config['overwrite'] = FALSE;
            $config['max_size'] = 1024; // Default to 1MB.

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

    /*
     * addCoupon() --> Load add coupon page. (Coupons > Add Coupon)
     */

    public function addCoupon() {
        $this->load->helper('form');

        if ($this->input->post('add_coupon')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('categoryId', 'Category name', 'trim|required|numeric');
            $this->form_validation->set_rules('vendorId', 'Vendor name', 'trim|required|numeric');
            $this->form_validation->set_rules('couponName', 'Coupon name', "trim|required|is_unique[wrh_coupon.couponName]|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z' ]+$/]", array("is_unique" => "Coupon name already exist."));
            $this->form_validation->set_rules('couponImage', 'Coupon image', "callback_validate_image");
            $this->form_validation->set_rules('couponCode', 'Coupon code', "trim|required|regex_match[/^[a-zA-Z0-9]+$/]|is_unique[wrh_coupon.couponCode]");
            $this->form_validation->set_rules('startDate', 'Start date', 'trim|required|callback_startDate_validation');
            $this->form_validation->set_rules('expiryDate', 'Expiry date', 'trim|required|callback_expiryDate_validation');
            $this->form_validation->set_rules('couponDescription', 'Coupon description', 'trim');
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

    /*
     * editCoupon() --> Load add coupon page from coupons view page.
     * @param: param1 int --> coupon id.
     */

    public function editCoupon($couponId) {
        $this->load->helper('form');

        if ($this->input->post('edit_coupon')) {
            $this->load->library('form_validation');

            // Validate the value against permissible rules.
            $this->form_validation->set_rules('categoryId', 'Category name', 'trim|required');
            $this->form_validation->set_rules('couponName', 'Coupon name', "trim|required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z' ]+$/]");
            $this->form_validation->set_rules('couponImage', 'Coupon image', "callback_validate_image");
            $this->form_validation->set_rules('couponCode', 'Coupon code', "trim|required|regex_match[/^[a-zA-Z0-9]+$/]");
            $this->form_validation->set_rules('expiryDate', 'Expiry date', 'trim|required|callback_expiryDate_validation');
            $this->form_validation->set_rules('couponLimit', 'Coupon Limit', 'trim|required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->couponServices_model->updateCoupon($this->input->post('couponId'), $this->upload_data);
                if ($flag) {
                    $this->session->set_flashdata('success_message', 'Coupon details updated successfully.');
                    redirect(base_url() . 'coupons/viewCoupons', 'refresh');
                } else {
                    redirect(base_url() . 'coupons/editCoupon/' . $couponId, 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'coupons/editCoupon/' . $couponId, 'refresh');
            }
        }

        $data['coupon_details'] = $this->couponServices_model->editCoupon($couponId);
        if (!$data['coupon_details']) { // Redirect to coupons page if user tries to insert other user id in URL, if not exists.
            redirect(base_url() . 'coupons', 'refresh');
        }
        $data['categories'] = $this->getCategoryList();
        $data['vendors'] = $this->getVendorList();
        $data['js'] = array("customs/coupons");
        $data['title'] = "Edit Coupon";
        $data['content'] = $this->load->view("coupon/edit_coupon", $data, true);
        $this->load->view("default_layout", $data);
    }

    /*
     * deleteCoupon() --> Delete coupon from coupon view page.
     * @param: param1 int --> coupon id.
     */

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
