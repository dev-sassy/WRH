<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CouponServices_model extends CI_Model {
    /*
     * viewAllCoupons() --> Fetch all coupons.
     * @return: array --> No. of coupon records.
     */

    public function viewAllCoupons() {
        return $this->db->get_where('wrh_coupon', array('is_deleted' => 0))->result_array();
    }

    /*
     * getImageSource() --> Get image data, convert to base64
     * @param: param1 array(key, value) --> image info. (size, name, type, ... ).
     * @return: base64 image string
     */

    public function getImageSource($couponImage) {
        $imageData = file_get_contents($couponImage['path']);

        $base64Image = base64_encode($imageData);
        $src = 'data:' . $couponImage['file_type'] . ';base64,' . $base64Image;
        return $src;
    }

    /*
     * addCoupon() --> Add coupon info to db.
     * @param: param1 array(key, value) --> image info. (size, name, type, ... ).
     * @return: bool true/false
     */

    public function addCoupon($couponImage) {
        $categoryId = trim($this->input->post('categoryId'));
        $vendorId = trim($this->input->post('vendorId'));
        $couponName = trim($this->input->post('couponName'));
        $couponCode = trim($this->input->post('couponCode'));
        $startDate = trim($this->input->post('startDate'));
        $expiryDate = trim($this->input->post('expiryDate'));
        $couponLimit = trim($this->input->post('couponLimit'));

        if (!$couponImage || $couponImage['file_size'] === 0 || !$couponImage['is_image']) {
            $categoryImage["path"] = "";
            $couponImage['file_type'] = "image/png";
        } else {
            $couponImage["path"] = "coupon/" . $couponImage['file_name'];
        }

        //$src = $this->getImageSource($couponImage);

        $data = array(
            "categoryId" => $categoryId,
            "vendorId" => $vendorId,
            "couponName" => $couponName,
            "couponImage" => $couponImage["path"],
            "couponCode" => $couponCode,
            "startDate" => $startDate,
            "expiryDate" => $expiryDate,
            "couponLimit" => $couponLimit
        );

        $this->db->insert('wrh_coupon', $data);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /*
     * fetchCategories() --> Fetch all categories.     
     * @return: array --> No. of category records.
     */

    public function fetchCategories() {
        return $this->db->get_where('wrh_category', array("is_deleted" => "0"))->result_array();
    }

    /*
     * fetchVendors() --> Fetch all vendors.     
     * @return: array --> No. of vendor records.
     */

    public function fetchVendors() {
        return $this->db->get_where('wrh_vendor', array("is_deleted" => "0"))->result_array();
    }

    /*
     * editCoupon() --> Fetch coupon by coupon id.
     * @return: array --> coupon record.
     */

    public function editCoupon($couponId) {
        $query = $this->db->get_where('wrh_coupon', array("couponId" => $couponId));

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    /*
     * updateCoupon() --> Update coupon by coupon id.
     * @param: param1 int --> coupon id, param2 array(key, value) --> image info. (size, name, type, ... ).
     * @return: bool true/false
     */

    public function updateCoupon($couponId, $couponImage) {
        $categoryId = trim($this->input->post('categoryId'));
        $vendorId = trim($this->input->post('vendorId'));
        $couponName = trim($this->input->post('couponName'));
        $couponCode = trim($this->input->post('couponCode'));
        $startDate = trim($this->input->post('startDate'));
        $expiryDate = trim($this->input->post('expiryDate'));
        $couponLimit = trim($this->input->post('couponLimit'));

        $query = $this->db->get_where('wrh_coupon', array("couponName" => $couponName));
        $coupon_details = $query->row_array();

        if (!$coupon_details['couponId'] || ($couponId === $coupon_details['couponId']) && !strcmp($couponName, $coupon_details['couponName'])) {
            if (!$couponImage || $couponImage['file_size'] === 0 || !$couponImage['is_image']) {
                $couponImage["path"] = "";
                $couponImage['file_type'] = "image/png";
            } else {
                $couponImage["path"] = "coupon/" . $couponImage['file_name'];
            }

            $data = array(
                "categoryId" => $categoryId,
                "vendorId" => $vendorId,
                "couponName" => $couponName,
                "couponImage" => $couponImage["path"],
                "couponCode" => $couponCode,
                "startDate" => $startDate,
                "expiryDate" => $expiryDate,
                "couponLimit" => $couponLimit
            );

            $this->db->update('wrh_coupon', $data, array("couponId" => $couponId));

            if ($this->db->affected_rows() > -1) {
                return TRUE;
            } else {
                $this->session->set_flashdata('error_message', 'Please try again.');
            }
        } else {
            $this->session->set_flashdata('error_message', 'Coupon name already exist.');
        }

        return FALSE;
    }

    /*
     * deleteCoupon() --> Delete coupon by coupon id.
     * @param: param1 int --> coupon id
     * @return: bool true/false
     */

    public function deleteCoupon($couponId) {
        $data = array('is_deleted' => 1);
        $this->db->update('wrh_coupon', $data, array('couponId' => $couponId));
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    /* ---------------------------------------- Webservices for Mobile ------------------------------------------------ */

    /*
     * validate_access() --> Checks if user have valid access.
     * @param: param1 array --> category info, param2 bool true/false.
     * @return: bool true/false
     */

    public function validate_access($field_details) {
        if (!empty($field_details)) {
            $accessToken = $this->encryption->decrypt($field_details['accessToken']);
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

                if ($access_details['uniqueId'] == $field_details['uniqueId'] &&
                        $access_details['deviceType'] == $field_details['deviceType']) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /*
     * isCouponSaved() --> Check is same coupon exist with coupon id, unique id and device type.
     * @param: param1 array --> coupon info.
     * @return: bool 1/0 (true/false)
     */

    public function isCouponSaved($coupon_details) {
        if (!empty($coupon_details)) {
            $this->db->where("couponId", $coupon_details['couponId']);
            $this->db->where("uniqueId", $coupon_details['uniqueId']);
            $this->db->where("deviceType", $coupon_details['deviceType']);
            $this->db->where("is_deleted", 0);
            $query = $this->db->get('wrh_saved_coupon');

            if ($query->num_rows() > 0) {
                return 1;
            }
        }
        return 0;
    }

    /*
     * listCoupons() --> Return all coupons by either category id, vendor id or both in response.
     * @param: param1 array --> coupon info, param2 bool true/false
     * @return: object --> {data, status, responseMessage}
     */

    public function listCoupons($field_details, $is_admin = FALSE) {
        $categoryId = isset($field_details['categoryId']) ? $field_details['categoryId'] : NULL;
        $vendorId = isset($field_details['vendorId']) ? $field_details['vendorId'] : NULL;

        /* if (!$categoryId && !$vendorId) {
          return array(
          'data' => NULL,
          'status' => 0,
          'responseMessage' => 'Atleast category id or vendor id is required.'
          );
          } */

        if ($this->validate_access($field_details) === TRUE || $is_admin == TRUE) {
            if ($categoryId && !$vendorId) {
                $select = "cat.categoryId, cat.categoryName, coupon.*";
                $joinParam1 = "wrh_category AS cat";
                $joinParam2 = "cat.categoryId = coupon.categoryId";
                $where = "cat.categoryId = " . $categoryId . " AND cat.is_deleted = 0";
            } else if (!$categoryId && $vendorId) {
                $select = "v.vendorId, v.vendorName, coupon.*";
                $joinParam1 = "wrh_vendor AS v";
                $joinParam2 = "v.vendorId = coupon.vendorId";
                $where = "v.vendorId = " . $vendorId . " AND v.is_deleted = 0";
            } else if ($categoryId && $vendorId) {
                $select = "v.vendorId, v.vendorName, cat.categoryId, cat.categoryName, coupon.*";
                $joinParam1 = "wrh_category AS cat";
                $join2Param1 = "wrh_vendor AS v";
                $joinParam2 = "cat.categoryId = coupon.categoryId";
                $join2Param2 = "v.vendorId = coupon.vendorId";
                $where = "cat.categoryId = " . $categoryId . " AND cat.is_deleted = 0 AND v.vendorId = " . $vendorId . " AND v.is_deleted = 0";
            } else {
                $select = "coupon.*";
            }

            $limit = 10;
            $index = $field_details['index'] * $limit - $limit;
            $index = $index <= 0 ? 0 : $index;

            $this->db->select($select);
            $this->db->from("wrh_coupon AS coupon");
            $this->db->join("wrh_redeem_coupon AS rc", "rc.couponId = coupon.couponId ", 'left');
            if (!(!$categoryId && !$vendorId)) {
                $this->db->join($joinParam1, $joinParam2, 'inner');
                $this->db->where($where);
            }
            if ($categoryId && $vendorId) {
                $this->db->join($join2Param1, $join2Param2, 'inner');
            }

            $this->db->where("coupon.is_deleted", 0);

            $dt = date('Y-m-d H:i:s', time());

            $this->db->where('coupon.startDate <=', $dt);
            $this->db->where('coupon.expiryDate >', $dt);
            $this->db->where('rc.uniqueId IS NULL OR rc.uniqueId !=', $field_details['uniqueId']);
            $this->db->where('rc.deviceType IS NULL OR rc.deviceType !=', $field_details['deviceType']);
            if ($categoryId) {
                $this->db->limit($limit, $index);
            }
            $query = $this->db->get();

//            $query = $this->db->get_compiled_select();
//            echo $query;
//            exit;

            if ($query->num_rows() > 0) {
                $res_coupon_details = $query->result_array();

                foreach ($res_coupon_details as $key => $value) {
                    $field_details['couponId'] = $value['couponId'];
                    $res_coupon_details[$key]['isSaved'] = $this->isCouponSaved($field_details);

                    unset($res_coupon_details[$key]['is_deleted']);
                    if ($categoryId && !$vendorId) {
                        unset($res_coupon_details[$key]['vendorId']);
                    } else if (!$categoryId && $vendorId) {
                        unset($res_coupon_details[$key]['categoryId']);
                    }
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
                    'responseMessage' => 'Coupons not available.'
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
     * couponsByCategory() --> Return all coupons by category id in response.
     * @param: param1 array --> category info, param2 bool true/false
     * @return: object --> {data, status, responseMessage}
     */

    public function couponsByCategory($category_details, $is_admin = FALSE) {
        if ($this->validate_access($category_details) === TRUE || $is_admin == TRUE) {
            $limit = 10;
            $catgoryId = $category_details['categoryId'];
            $index = $category_details['index'] * $limit - $limit;
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

            if ($query->num_rows() > 0) {
                $res_coupon_details = $query->result_array();

                foreach ($res_coupon_details as $key => $value) {
                    $category_details['couponId'] = $value['couponId'];
                    $res_coupon_details[$key]['isSaved'] = $this->isCouponSaved($category_details);

                    unset($res_coupon_details[$key]['is_deleted']);
                    unset($res_coupon_details[$key]['vendorId']);
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
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'Forbidden request.'
            );
        }

        return $response;
    }

    /*
     * couponsByVendor() --> Return all coupons by vendor id in response.
     * @param: param1 array --> vendor info, param2 bool true/false
     * @return: object --> {data, status, responseMessage}
     */

    public function couponsByVendor($vendor_details, $is_admin = FALSE) {
        if ($this->validate_access($vendor_details) === TRUE || $is_admin == TRUE) {
            $limit = 10;
            $vendorId = $vendor_details['vendorId'];
            $index = $vendor_details['index'] * $limit - $limit;
            $index = $index <= 0 ? 0 : $index;

            $this->db->select("v.vendorId, v.vendorName, coupon.*");
            $this->db->from("wrh_coupon AS coupon");
            $this->db->join("wrh_vendor AS v", "v.vendorId = coupon.vendorId", 'inner');
            $this->db->where("v.vendorId", $vendorId);
            $this->db->where("v.is_deleted", 0);
            $this->db->where("coupon.is_deleted", 0);

            $dt = new DateTime('now');
            $dt = $dt->format('Y-m-d H:i:s');

            $this->db->where('coupon.startDate <=', $dt);
            $this->db->where('coupon.expiryDate >', $dt);
            $this->db->limit($limit, $index);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $res_coupon_details = $query->result_array();

                foreach ($res_coupon_details as $key => $value) {
                    $vendor_details['couponId'] = $value['couponId'];
                    $res_coupon_details[$key]['isSaved'] = $this->isCouponSaved($vendor_details);

                    unset($res_coupon_details[$key]['is_deleted']);
                    unset($res_coupon_details[$key]['categoryId']);
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
                    'responseMessage' => 'Coupons not available for this vendor.'
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
     * couponDetails() --> Return coupons info by coupon id in response.
     * @param: param1 array --> coupon info
     * @return: object --> {data, status, responseMessage}
     */

    public function couponDetails($coupon_details) {
        if ($this->validate_access($coupon_details) === FALSE) {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'Forbidden request.'
            );
        } else {
            $this->db->where("couponId", $coupon_details['couponId']);

            $dt = date('Y-m-d H:i:s', time());
            $this->db->where('startDate <=', $dt);
            $this->db->where('expiryDate >', $dt);

            $this->db->where("is_deleted", 0);
            $query = $this->db->get('wrh_coupon');

            if ($query->num_rows() > 0) {
                $res_coupon_details = $query->row_array();
                $res_coupon_details['isSaved'] = $this->isCouponSaved($coupon_details);

                unset($res_coupon_details['is_deleted']);
                $response = array(
                    'data' => $res_coupon_details,
                    'status' => 1,
                    'responseMessage' => 'success'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Coupon not found.'
                );
            }
        }

        return $response;
    }

    /*
     * saveCoupon() --> Return saved coupons info by coupon id in response.
     * @param: param1 array --> coupon info.
     * @return: object --> {data, status, responseMessage}
     */

    public function saveCoupon($coupon_details) {
        if ($this->validate_access($coupon_details) === FALSE) {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'Forbidden request.'
            );
        } else {
            $this->db->where("couponId", $coupon_details['couponId']);

            $dt = date('Y-m-d H:i:s', time());
            $this->db->where('startDate <=', $dt);
            $this->db->where('expiryDate >', $dt);

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
                $coupon_details['couponSavedAt'] = date('Y-m-d H:i:s', time());

                unset($coupon_details['accessToken']);
                unset($coupon_details['deviceToken']);
                $this->db->insert("wrh_saved_coupon", $coupon_details);

                $response = array(
                    'data' => $coupon_details,
                    'status' => 1,
                    'responseMessage' => 'Coupon has been saved successfully.'
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

    /*
     * discardCoupon() --> Return discarded coupons info by coupon id in response.
     * @param: param1 array --> coupon info.
     * @return: object --> {data, status, responseMessage}
     */

    public function discardCoupon($coupon_details) {
        if ($this->validate_access($coupon_details, true) === FALSE) {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'Forbidden request.'
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
                    'responseMessage' => 'Coupon has been discarded successfully.'
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

    /*
     * countRedeemCoupons() --> Return total no. of coupons.
     * @param: param1 array --> coupon info.
     * @return: int --> count of coupon records.
     */

    public function countRedeemCoupons($coupon_details) {
        $this->db->where("couponId", $coupon_details['couponId']);
        $this->db->where("is_deleted", 0);
        $res = $this->db->get('wrh_redeem_coupon')->result_array();
        return count($res);
    }

    /*
     * redeemCoupon() --> Return redeemed coupon info by coupon id in response.
     * @param: param1 array --> coupon info.
     * @return: object --> {data, status, responseMessage}
     */

    public function redeemCoupon($coupon_details) {
        if ($this->validate_access($coupon_details, true) === FALSE) {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'Forbidden request.'
            );
        } else {
            $this->db->where("couponId", $coupon_details['couponId']);

            $dt = date('Y-m-d H:i:s', time());
            $this->db->where('startDate <=', $dt);
            $this->db->where('expiryDate >', $dt);

            $this->db->select("couponLimit");
            $this->db->where("is_deleted", 0);
            $query = $this->db->get('wrh_coupon');

            if ($query->num_rows() <= 0) {
                return array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Coupon not found.'
                );
            }

            $redeemCouponCount = $this->countRedeemCoupons($coupon_details);
            $res_coupon_details = $query->result_array();
            $couponLimit = $res_coupon_details[0]['couponLimit'];

            if ($couponLimit > $redeemCouponCount) {
                unset($coupon_details["deviceToken"]);
                unset($coupon_details["accessToken"]);

                $coupon_details["redeemedAt"] = date('Y-m-d H:i:s', time());
                $this->db->insert("wrh_redeem_coupon", $coupon_details);

                if ($this->db->affected_rows() > 0) {
                    $response = array(
                        'data' => $coupon_details,
                        'status' => 1,
                        'responseMessage' => 'Coupon redeemed successfully.'
                    );
                }
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Coupon limit has been reached.'
                );
            }
        }

        return $response;
    }

}
