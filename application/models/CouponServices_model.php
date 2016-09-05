<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CouponServices_model extends CI_Model {

    public function viewAllCoupons() {
//        $dt = new DateTime('now');
//        $dt = $dt->format('Y-m-d H:i:s');
//
//        $data = array('is_deleted' => 1);
//        $this->db->where('expiryDate <', $dt);
//        $this->db->update('wrh_coupon', $data);

        return $this->db->get_where('wrh_coupon', array('is_deleted' => 0))->result_array();
    }

    public function getImageSource($couponImage) {
        $imageData = file_get_contents($couponImage['path']);

        $base64Image = base64_encode($imageData);
        $src = 'data:' . $couponImage['file_type'] . ';base64,' . $base64Image;
        return $src;
    }

    public function addCoupon($couponImage) {
        $categoryId = trim($this->input->post('categoryId'));
        $vendorId = trim($this->input->post('vendorId'));
        $couponName = trim($this->input->post('couponName'));
        $couponCode = trim($this->input->post('couponCode'));
        $startDate = trim($this->input->post('startDate'));
        $expiryDate = trim($this->input->post('expiryDate'));
        $couponLimit = trim($this->input->post('couponLimit'));

        if (!$couponImage || $couponImage['file_size'] === 0 || !$couponImage['is_image']) {
            $couponImage["path"] = base_url() . "assets/images/no-image.png";
            $couponImage['file_type'] = "image/png";
        } else {
            $couponImage["path"] = base_url() . "images/coupon/" . $couponImage['file_name'];
        }

        $src = $this->getImageSource($couponImage);

        $data = array(
            "categoryId" => $categoryId,
            "vendorId" => $vendorId,
            "couponName" => $couponName,
            "couponImage" => $src,
            "couponCode" => $couponCode,
            "startDate" => $startDate,
            "expiryDate" => $expiryDate,
            "couponLimit" => $couponLimit
        );

        $this->db->insert('wrh_coupon', $data);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    public function fetchCategories() {
        return $this->db->get_where('wrh_category', array("is_deleted" => "0"))->result_array();
    }

    public function fetchVendors() {
        return $this->db->get_where('wrh_vendor', array("is_deleted" => "0"))->result_array();
    }

    public function editCoupon($couponId) {
        $query = $this->db->get_where('wrh_coupon', array("couponId" => $couponId));

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function updateCoupon($couponId, $couponImage) {
        $categoryId = trim($this->input->post('categoryId'));
        $vendorId = trim($this->input->post('vendorId'));
        $couponName = trim($this->input->post('couponName'));
        $couponCode = trim($this->input->post('couponCode'));
        $startDate = trim($this->input->post('startDate'));
        $expiryDate = trim($this->input->post('expiryDate'));
        $couponLimit = trim($this->input->post('couponLimit'));

        if (!$couponImage || $couponImage['file_size'] === 0 || !$couponImage['is_image']) {
            $couponImage["path"] = base_url() . "assets/images/no-image.png";
            $couponImage['file_type'] = "image/png";
        } else {
            $couponImage["path"] = base_url() . "images/coupon/" . $couponImage['file_name'];
        }

        $src = $this->getImageSource($couponImage);

        $data = array(
            "categoryId" => $categoryId,
            "vendorId" => $vendorId,
            "couponName" => $couponName,
            "couponImage" => $src,
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
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

}
