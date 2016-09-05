<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VendorServices_model extends CI_Model {

    public function viewAllVendors() {
        return $this->db->get_where('wrh_vendor', array('is_deleted' => 0))->result_array();
    }

    public function getImageSource($vendorImage) {
        $imageData = file_get_contents($vendorImage['path']);
        $base64Image = base64_encode($imageData);
        $src = 'data:' . $vendorImage['file_type'] . ';base64,' . $base64Image;
        return $src;
    }

    public function addVendor($vendorImage) {
        $vendorName = trim($this->input->post('vendorName'));
        $createdOn = new DateTime('now');
        $createdOn = $createdOn->format('Y-m-d H:i:s');

        if (!$vendorImage || $vendorImage['file_size'] === 0 || !$vendorImage['is_image']) {
            $vendorImage["path"] = base_url() . "assets/images/no-image.png";
            $vendorImage['file_type'] = "image/png";
        } else {
            $vendorImage["path"] = base_url() . "images/vendor/" . $vendorImage['file_name'];
        }

        $src = $this->getImageSource($vendorImage);

        $data = array(
            "vendorName" => $vendorName,
            "createdOn" => $createdOn,
            "vendorImage" => $src
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

    public function updateVendor($vendorId, $vendorImage) {
        $vendorName = trim($this->input->post('vendorName'));

        if (!$vendorImage || $vendorImage['file_size'] === 0 || !$vendorImage['is_image']) {
            $vendorImage["path"] = base_url() . "assets/images/no-image.png";
            $vendorImage['file_type'] = "image/png";
        } else {
            $vendorImage["path"] = base_url() . "images/vendor/" . $vendorImage['file_name'];
        }

        $src = $this->getImageSource($vendorImage);

        $data = array(
            "vendorName" => $vendorName,
            "vendorImage" => $src
        );
        $this->db->update('wrh_vendor', $data, array("vendorId" => $vendorId));

        return $this->db->affected_rows() > -1 ? TRUE : FALSE;
    }

    public function deleteVendor($vendorId) {
        $this->db->delete('wrh_coupon', array('vendorId' => $vendorId));

        $data = array('is_deleted' => 1);
        $this->db->update('wrh_vendor', $data, array('vendorId' => $vendorId));
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

}
