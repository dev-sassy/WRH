<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SubscriberServices_model extends CI_Model {
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

    public function subscribersList($subscriber_details) {
        if ($this->validate_access($subscriber_details) === TRUE) {
            $query = $this->db->get('wrh_subscribers');

            if ($query->num_rows() > 0) {
                $response = array(
                    'data' => $query->result_array(),
                    'status' => 1,
                    'responseMessage' => "Success"
                );
            } else {
                $response = array(
                    'data' => array(),
                    'status' => 0,
                    'responseMessage' => "No subscribers found."
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

    public function subscribeUser($subscriber_details) {
        $query = $this->db->get_where('wrh_subscribers', array('subscriberEmailId' => $subscriber_details['subscriberEmailId']));

        if ($query->num_rows() > 0) {
            return array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => "Email already exist."
            );
        }

        $subscriber_details['subscribedAt'] = date('Y-m-d H:i:s', time());
        $this->db->insert('wrh_subscribers', $subscriber_details);

        if ($this->db->affected_rows() > 0) {
            return array(
                'data' => $subscriber_details,
                'status' => 1,
                'responseMessage' => "Email subscribed successfully."
            );
        }

        return array(
            'data' => NULL,
            'status' => 0,
            'responseMessage' => "Something went wrong. Please try again."
        );
    }

    public function unsubscribeUser($subscriber_details) {
        if ($this->validate_access($subscriber_details) === TRUE) {
            $query = $this->db->get_where('wrh_subscribers', array('subscriberEmailId' => $subscriber_details['subscriberEmailId']));

            if ($query->num_rows() > 0) {
                $this->db->delete('wrh_subscribers', array('subscriberEmailId' => $subscriber_details['subscriberEmailId']));

                if ($this->db->affected_rows()) {
                    $response = array(
                        'data' => array("subscriberEmailId" => $subscriber_details['subscriberEmailId']),
                        'status' => 1,
                        'responseMessage' => "You have unsubscribed email."
                    );
                } else {
                    $response = array(
                        'data' => NULL,
                        'status' => 0,
                        'responseMessage' => "Something went wrong. Please try again."
                    );
                }
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => "Email Id not found. Please check your mail id."
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
