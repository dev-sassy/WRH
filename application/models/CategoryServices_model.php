<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryServices_model extends CI_Model {

    public function getImageSource($categoryImage) {
        $imageData = file_get_contents($categoryImage['path']);
        $base64Image = base64_encode($imageData);
        $src = 'data:' . $categoryImage['file_type'] . ';base64,' . $base64Image;
        return $src;
    }

    public function addCategory($categoryImage) {
        if (!$categoryImage || $categoryImage['file_size'] === 0 || !$categoryImage['is_image']) {
            $categoryImage["path"] = base_url() . "assets/images/no-image.png";
            $categoryImage['file_type'] = "image/png";
        } else {
            $categoryImage["path"] = base_url() . "images/category/" . $categoryImage['file_name'];
        }

        $src = $this->getImageSource($categoryImage);

        $data = array(
            "categoryName" => trim($this->input->post('categoryName')),
            "categoryImage" => $src
        );
        $this->db->insert('wrh_category', $data);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    public function editCategory($categoryId) {
        $query = $this->db->get_where('wrh_category', array("categoryId" => $categoryId));

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function updateCategory($categoryId, $categoryImage) {
        if (!$categoryImage || $categoryImage['file_size'] === 0 || !$categoryImage['is_image']) {
            $categoryImage["path"] = base_url() . "assets/images/no-image.png";
            $categoryImage['file_type'] = "image/png";
        } else {
            $categoryImage["path"] = base_url() . "images/category/" . $categoryImage['file_name'];
        }

        $src = $this->getImageSource($categoryImage);

        $data = array(
            "categoryName" => trim($this->input->post('categoryName')),
            "categoryImage" => $src
        );
        $this->db->update('wrh_category', $data, array("categoryId" => $categoryId));
        return $this->db->affected_rows() > -1 ? TRUE : FALSE;
    }

    public function deleteCategory($categoryId) {
        $this->db->delete('wrh_coupon', array('categoryId' => $categoryId));        

        $data = array('is_deleted' => 1);
        $this->db->update('wrh_category', $data, array('categoryId' => $categoryId));
        
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    public function addUniqueId($access_details) {
        $this->db->where("uniqueId", $access_details['uniqueId']);
        $this->db->where("deviceType", $access_details['deviceType']);
        $this->db->where("deviceToken", $access_details['deviceToken']);
        $this->db->where("is_deleted", 0);
        $query = $this->db->get('wrh_access_token_list');

        $key = $access_details['uniqueId'] . '--' . $access_details['deviceType'] . '--' . $access_details['deviceToken'] . '--' . microtime();
        $access_token = $this->encryption->encrypt($key);

        $access_details['accessToken'] = $access_token;
        $dt = new DateTime('now');
        $dt = $dt->format('Y-m-d H:i:s');
        $access_details['accessTokenTime'] = $dt;

        if ($query->num_rows() > 0) {
            $accessTokenId = $query->row_array();
            $accessTokenId = $accessTokenId['accessTokenId'];

            $this->db->where('accessTokenId', $accessTokenId);
            $this->db->update('wrh_access_token_list', array('is_deleted' => 1));
        }

        $this->db->insert('wrh_access_token_list', $access_details);

        if ($this->db->affected_rows() > -1) {
            $response = array(
                'data' => $access_details,
                'status' => 1,
                'responseMessage' => 'success'
            );
        } else {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'Insertion/Updation failed.'
            );
        }

        return $response;
    }

    public function validate_access($category_details, $finfo = false) {
        if (!empty($category_details)) {

            $this->db->where("uniqueId", $category_details['uniqueId']);
            $this->db->where("deviceType", $category_details['deviceType']);

            if (!$finfo) {
                $this->db->where("deviceToken", $category_details['deviceToken']);
            }
            $this->db->where("is_deleted", 0);
            $query = $this->db->get('wrh_access_token_list');

            if ($query->num_rows() > 0) {
                return true;
            }
        }
        return false;
    }

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
                'data' => $category_details,
                'status' => 0,
                'responseMessage' => 'Forbidden access.'
            );
        }

        return $response;
    }

    public function categoryDetails($category_details, $is_admin = FALSE) {
        if ($this->validate_access($category_details) === TRUE || $is_admin == TRUE) {
            $this->db->where("categoryId", $category_details['categoryId']);
            $this->db->where("is_deleted", 0);
            $query = $this->db->get('wrh_category');

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
                    'responseMessage' => 'Category Id not found.'
                );
            }
        } else {
            $response = array(
                'data' => $category_details,
                'status' => 0,
                'responseMessage' => 'Forbidden access.'
            );
        }

        return $response;
    }

    public function couponList($coupon_details, $is_admin = FALSE) {
        if ($this->validate_access($coupon_details) === TRUE || $is_admin == TRUE) {
            //        date_default_timezone_set('Asia/Kolkata');
            $limit = 10;
            $catgoryId = $coupon_details['categoryId'];
            $index = $coupon_details['index'] * $limit - $limit;
            $index = $index <= 0 ? 0 : $index;

            $this->db->select("cat.categoryId, cat.categoryName, coupon.*");
            $this->db->from("wrh_coupon AS coupon");
            $this->db->join("wrh_category AS cat", "cat.categoryId = coupon.categoryId", 'inner');
            $this->db->where("cat.categoryId", $catgoryId);
            $this->db->where("cat.is_deleted", 0);
            $this->db->where("coupon.is_deleted", 0);

            $dt = new DateTime('now');
            $dt = $dt->format('Y-m-d H:i:s');

            $this->db->where('coupon.startDate <=', $dt);
            $this->db->where('coupon.expiryDate >', $dt);
            $this->db->limit($limit, $index);
            $query = $this->db->get();
//            $query = $this->db->get_compiled_select();
//            echo $query;
//            exit;

            if ($query->num_rows() > 0) {
                $res_coupon_details = $query->result_array();

                foreach ($res_coupon_details as $key => $value) {
                    $coupon_details['couponId'] = $value['couponId'];
                    $res_coupon_details[$key]['isSaved'] = $this->isCouponSaved($coupon_details);
                }

                $response = array(
                    'data' => $res_coupon_details,
                    'status' => 1,
                    'responseMessage' => 'success'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Coupons not available for this category.'
                );
            }
        } else {
            $response = array(
                'data' => $coupon_details,
                'status' => 0,
                'responseMessage' => 'Forbidden access.'
            );
        }

        return $response;
    }

    public function couponDetails($coupon_details) {
        if ($this->validate_access($coupon_details) === FALSE) {
            $response = array(
                'data' => $coupon_details,
                'status' => 0,
                'responseMessage' => 'Forbidden access.'
            );
        } else {
            $this->db->where("couponId", $coupon_details['couponId']);
            $this->db->where("is_deleted", 0);
            $query = $this->db->get('wrh_coupon');

            if ($query->num_rows() > 0) {
                $res_coupon_details = $query->row_array();
                $res_coupon_details['isSaved'] = $this->isCouponSaved($coupon_details);

                $response = array(
                    'data' => $res_coupon_details,
                    'status' => 1,
                    'responseMessage' => 'success'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Coupons Id not found.'
                );
            }
        }

        return $response;
    }

    public function isCouponSaved($coupon_details) {
        $this->db->where("couponId", $coupon_details['couponId']);
        $this->db->where("uniqueId", $coupon_details['uniqueId']);
        $this->db->where("deviceType", $coupon_details['deviceType']);
        $this->db->where("is_deleted", 0);
        $query = $this->db->get('wrh_saved_coupon');

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function saveCoupon($coupon_details) {
        if ($this->validate_access($coupon_details, true) === FALSE) {
            $response = array(
                'data' => $coupon_details,
                'status' => 0,
                'responseMessage' => 'Forbidden access.'
            );
        } else {
            $this->db->where("couponId", $coupon_details['couponId']);
            $this->db->where("is_deleted", 0);
            $query = $this->db->get('wrh_coupon');

            if ($query->num_rows() <= 0) {
                return array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Coupon not found.'
                );
            }

            if (!$this->isCouponSaved($coupon_details)) {
                $dt = new DateTime('now');
                $dt = $dt->format('Y-m-d H:i:s');
                $coupon_details['couponSavedAt'] = $dt;

                $this->db->insert("wrh_saved_coupon", $coupon_details);

                $response = array(
                    'data' => $coupon_details,
                    'status' => 1,
                    'responseMessage' => 'success'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Coupon already saved.'
                );
            }
        }

        return $response;
    }

    public function discardCoupon($coupon_details) {
        if ($this->validate_access($coupon_details, true) === FALSE) {
            $response = array(
                'data' => $coupon_details,
                'status' => 0,
                'responseMessage' => 'Forbidden access.'
            );
        } else {
            $this->db->where("couponId", $coupon_details['couponId']);
            $this->db->where("is_deleted", 0);
            $query = $this->db->get('wrh_coupon');

            if ($query->num_rows() <= 0) {
                return array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Coupon not found.'
                );
            }

            $where = array(
                "couponId" => $coupon_details["couponId"],
                "uniqueId" => $coupon_details["uniqueId"],
                "deviceType" => $coupon_details["deviceType"],
                "is_deleted" => 0
            );

            $this->db->update("wrh_saved_coupon", array('is_deleted' => 1), $where);

            if ($this->db->affected_rows() > -1) {
                unset($where['is_deleted']);
                $this->db->where($where);
                $this->db->where('is_deleted', 1);
                $query = $this->db->get("wrh_saved_coupon");
                $coupon_details = $query->result_array();

                $response = array(
                    'data' => $coupon_details,
                    'status' => 1,
                    'responseMessage' => 'success'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Coupon not exists.'
                );
            }
        }

        return $response;
    }

}
