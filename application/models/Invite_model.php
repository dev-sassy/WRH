<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invite_model extends CI_Model {
    /*
     * validate_access() --> Checks if user have valid access.
     * @param: param1 array --> category info, param2 bool true/false.
     * @return: bool true/false
     */

    public function validate_access($field_details, $finfo = NULL) {
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

    public function viewInvites($invite_details, $is_admin = FALSE) {
        if ($this->validate_access($invite_details) === TRUE || $is_admin == TRUE) {
            $query = $this->db->get('wrh_invite');

            if ($query->num_rows() > 0) {
                $invite_details = $query->result_array();

                $response = array(
                    'data' => $invite_details,
                    'status' => 1,
                    'responseMessage' => 'success'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'No invitees found.'
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

    public function addInvite($invite_details) {
        if ($this->validate_access($invite_details) === TRUE || $is_admin == TRUE) {

            unset($invite_details['uniqueId']);
            unset($invite_details['deviceType']);
            unset($invite_details['deviceToken']);
            unset($invite_details['accessToken']);

            $this->db->insert('wrh_invite', $invite_details);

            if ($this->db->affected_rows()) {
                $invite_details = $this->db->get_where('wrh_invite', array('inviteId' => $this->db->insert_id()))->row_array();

                $response = array(
                    'data' => $invite_details,
                    'status' => 1,
                    'responseMessage' => 'Invitee added successfully.'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Something went wrong. Please try again.'
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
