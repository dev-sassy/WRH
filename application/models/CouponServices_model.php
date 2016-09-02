<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CouponServices_model extends CI_Model {

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
    public function index() {
        echo "Welcome to WRH";
    }

    public function viewAllCoupons() {
        return $this->db->get_where('wrh_coupon', array('is_deleted' => 0))->result_array();
    }

    public function addCoupon() {
        $categoryId = trim($this->input->post('categoryId'));
        $couponName = trim($this->input->post('couponName'));
        $couponCode = trim($this->input->post('couponCode'));
        $startDate = trim($this->input->post('startDate'));
        $expiryDate = trim($this->input->post('expiryDate'));
        $couponLimit = trim($this->input->post('couponLimit'));

        $data = array(
            "categoryId" => $categoryId,
            "couponName" => $couponName,
            "couponCode" => $couponCode,
            "startDate" => $startDate,
            "expiryDate" => $expiryDate,
            "couponLimit" => $couponLimit
        );

        $this->db->insert('wrh_coupon', $data);
        return $this->db->affected_rows() > -1 ? TRUE : FALSE;
    }

    public function fetchCategories() {
        return $this->db->get_where('wrh_category', array("is_deleted" => "0"))->result_array();
    }

    public function editCoupon($couponId) {
        $query = $this->db->get_where('wrh_coupon', array("couponId" => $couponId));

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function updateCoupon($couponId) {
        $categoryId = trim($this->input->post('categoryId'));
        $couponName = trim($this->input->post('couponName'));
        $couponCode = trim($this->input->post('couponCode'));
        $startDate = trim($this->input->post('startDate'));
        $expiryDate = trim($this->input->post('expiryDate'));
        $couponLimit = trim($this->input->post('couponLimit'));

        $data = array(
            "categoryId" => $categoryId,
            "couponName" => $couponName,
            "couponCode" => $couponCode,
            "startDate" => $startDate,
            "expiryDate" => $expiryDate,
            "couponLimit" => $couponLimit
        );
        $this->db->update('wrh_coupon', $data, array("couponId" => $couponId));
        return $this->db->affected_rows() > -1 ? TRUE : FALSE;
    }

    public function deleteCoupon($couponId) {
        $data = array('is_deleted' => 1);
        $this->db->update('wrh_coupon', $data, array('couponId' => $couponId));
        return $this->db->affected_rows() > -1 ? TRUE : FALSE;
    }

}
