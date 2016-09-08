<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WrhServices_model extends CI_Model {
    /*
     * addUniqueId() --> Add unique id, device type, device token and access token.
     * @return: object --> {data, status, responseMessage}
     */

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

}
