<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VendorServices_model extends CI_Model {

    public function viewAllVendors() {
        return $this->db->get_where('wrh_vendor', array('is_deleted' => 0))->result_array();
    }

    public function addVendor() {
        $vendorName = trim($this->input->post('vendorName'));
        $createdOn = trim($this->input->post('createdOn'));

        $data = array(
            "vendorName" => $vendorName,
            "createdOn" => $createdOn
        );

        $this->db->insert('wrh_vendor', $data);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    public function editVendor($vendorId) {
        $query = $this->db->get_where('wrh_vendor', array("vendorId" => $vendorId));

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function updateVendor($vendorId) {
        $vendorName = trim($this->input->post('vendorName'));
        $createdOn = trim($this->input->post('createdOn'));

        $data = array(
            "vendorName" => $vendorName,
            "createdOn" => $createdOn
        );

        $this->db->update('wrh_vendor', $data, array("vendorId" => $vendorId));
        return $this->db->affected_rows() > -1 ? TRUE : FALSE;
    }

    public function deleteVendor($vendorId) {
        $this->db->delete('wrh_coupon', array('vendorId' => $vendorId));

        $data = array('is_deleted' => 1);
        $this->db->update('wrh_vendor', $data, array('vendorId' => $vendorId));
        return $this->db->affected_rows() > -1 ? TRUE : FALSE;
    }

}
