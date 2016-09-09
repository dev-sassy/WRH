<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryServices_model extends CI_Model {
    /*
     * getImageSource() --> Get image data, convert to base64
     * @param: param1 array(key, value) --> image info. (size, name, type, ... ).
     * @return: base64 image string
     */

    public function getImageSource($categoryImage) {
        $imageData = file_get_contents($categoryImage['path']);
        $base64Image = base64_encode($imageData);
        $src = 'data:' . $categoryImage['file_type'] . ';base64,' . $base64Image;
        return $src;
    }

    /*
     * addCategory() --> Add category info to db.
     * @param: param1 array(key, value) --> image info. (size, name, type, ... ).
     * @return: bool true/false
     */

    public function addCategory($categoryImage) {
        if (!$categoryImage || $categoryImage['file_size'] === 0 || !$categoryImage['is_image']) { // Use default image.
            $categoryImage["path"] = "";
            $categoryImage['file_type'] = "image/png";
        } else {
            $categoryImage["path"] = "category/" . $categoryImage['file_name'];
        }

        //$src = $this->getImageSource($categoryImage);

        $data = array(
            "categoryName" => trim($this->input->post('categoryName')),
            "categoryImage" => $categoryImage["path"]
        );
        $this->db->insert('wrh_category', $data);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /*
     * editCategory() --> Get category info by category id.
     * @param: param1 int --> category id.
     * @return: array --> category record.
     */

    public function editCategory($categoryId) {
        $query = $this->db->get_where('wrh_category', array("categoryId" => $categoryId));

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    /*
     * updateCategory() --> Update category info by category id.
     * @param: param1 int --> category id, param2 array(key, value) --> image info. (size, name, type, ... ).
     * @return: bool true/false
     */

    public function updateCategory($categoryId, $categoryImage) {
        if (!$categoryImage || $categoryImage['file_size'] === 0 || !$categoryImage['is_image']) { // Use default image.
            $categoryImage["path"] = "";
            $categoryImage['file_type'] = "image/png";
        } else {
            $categoryImage["path"] = "category/" . $categoryImage['file_name'];
        }

        //$src = $this->getImageSource($categoryImage);

        $data = array(
            "categoryName" => trim($this->input->post('categoryName')),
            "categoryImage" => $categoryImage["path"]
        );
        $this->db->update('wrh_category', $data, array("categoryId" => $categoryId));
        return $this->db->affected_rows() > -1 ? TRUE : FALSE;
    }

    /*
     * deleteCategory() --> Delete category info by category id.
     * @param: param1 int --> category id.
     * @return: bool true/false
     */

    public function deleteCategory($categoryId) {
        $this->db->delete('wrh_coupon', array('categoryId' => $categoryId));

        $data = array('is_deleted' => 1);
        $this->db->update('wrh_category', $data, array('categoryId' => $categoryId));

        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /* ---------------------------------------- Webservices for Mobile ------------------------------------------------ */

    /*
     * validate_access() --> Checks if user have valid access.
     * @param: param1 array --> category info, param2 bool true/false.
     * @return: bool true/false
     */

    public function validate_access($category_details, $finfo = NULL) {
        if (!empty($category_details)) {
            $accessToken = $this->encryption->decrypt($category_details['accessToken']);
            $key = explode('--', $accessToken);

            if (count($key) !== 4) {
                return FALSE;
            }

            $this->db->where("uniqueId", $key[0]);
            $this->db->where("deviceType", $key[1]);
            $this->db->where("is_deleted", 0);

            $query = $this->db->get('wrh_access_token_list');

            if ($query->num_rows() > 0) {
                $access_details = $query->row_array();

                if ($access_details['uniqueId'] == $category_details['uniqueId'] &&
                        $access_details['deviceType'] == $category_details['deviceType']) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /*
     * categoryList() --> Return all categories in response.
     * @param: param1 array --> category info, param2 bool true/false.
     * @return: object --> {data, status, responseMessage}
     */

    public function categoryList($category_details, $is_admin = FALSE) {
        if ($this->validate_access($category_details) === TRUE || $is_admin == TRUE) {
            $this->db->select("categoryId, categoryName, categoryImage");
            $query = $this->db->get_where('wrh_category', array('is_deleted' => 0));

            if ($query->num_rows() > 0) {
                $category_details = $query->result_array();

                $response = array(
                    'data' => $category_details,
                    'status' => 1,
                    'responseMessage' => 'success'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Categories are empty.'
                );
            }
        } else {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'Forbidden request.'
            );
        }

        return $response;
    }

    /*
     * categoryDetails() --> Return category in response by category id.
     * @param: param1 array --> category info, param2 bool true/false.
     * @return: object --> {data, status, responseMessage}
     */

    public function categoryDetails($category_details, $is_admin = FALSE) {
        if ($this->validate_access($category_details) === TRUE || $is_admin == TRUE) {
            $this->db->where("categoryId", $category_details['categoryId']);
            $this->db->where("is_deleted", 0);
            $query = $this->db->get('wrh_category');

            if ($query->num_rows() > 0) {
                $category_details = $query->result_array();
                unset($category_details[0]['is_deleted']);

                $response = array(
                    'data' => $category_details,
                    'status' => 1,
                    'responseMessage' => 'success'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Category Id not found.'
                );
            }
        } else {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'Forbidden request.'
            );
        }

        return $response;
    }

}
