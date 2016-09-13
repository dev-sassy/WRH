<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WrhServices_model extends CI_Model {
    /*
     * addUniqueId() --> Add unique id, device type, device token and access token.
     * @return: object --> {data, status, responseMessage}
     */

    public function addUniqueId($access_details) {
        if (strtolower($access_details['deviceToken']) == 'null' || strtolower($access_details['deviceToken']) == NULL) {
            return array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => "Device token can not be null."
            );
        }

        $this->db->where("uniqueId", $access_details['uniqueId']);
        $this->db->where("deviceType", $access_details['deviceType']);
        $this->db->where("deviceToken", $access_details['deviceToken']);
        $this->db->where("is_deleted", 0);
        $query = $this->db->get('wrh_access_token_list');

        $key = $access_details['uniqueId'] . '--' . $access_details['deviceType'] . '--' . $access_details['deviceToken'] . '--' . microtime();
        $access_token = $this->encryption->encrypt($key);

        $access_details['accessToken'] = $access_token;
        $dt = date('Y-m-d H:i:s', time());
        $access_details['accessTokenTime'] = $dt;

        if ($query->num_rows() > 0) {
            $row_record = $query->row_array();
            $uniqueId = $row_record['uniqueId'];

            $this->db->where('uniqueId', $uniqueId);
            $this->db->update('wrh_access_token_list', array('is_deleted' => 1));
        }

        $this->db->insert('wrh_access_token_list', $access_details);

        if ($this->db->affected_rows() > 0) {
            $response = array(
                'data' => $access_details,
                'status' => 1,
                'responseMessage' => 'success'
            );
        } else {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'Execution failed.'
            );
        }

        return $response;
    }

    public function androidNotifications() {
        $this->db->select('deviceToken');
        $this->db->like('upper(deviceType)', 'ANDROID');
        $query = $this->db->get_where("wrh_access_token_list", array("is_deleted" => "0"));

        return $query->result_array();
    }

    public function iosNotifications() {
        $this->db->select('deviceToken');
        $this->db->like('upper(deviceType)', 'IOS');
        $query = $this->db->get_where("wrh_access_token_list", array("is_deleted" => "0"));

        return $query->result_array();
    }

    public function fetchTodaysNotifications() {
        $this->db->where("created_on", date('Y-m-d'));
        $this->db->where("is_deleted", 0);
        $query = $this->db->get("wrh_notification");

        return $query->result_array();
    }

}
