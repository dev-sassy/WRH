<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SubscriberServices_model extends CI_Model {

    public function subscribersList() {
        $query = $this->db->get('wrh_subscribers');

        if ($query->num_rows() > 0) {
            $response = array(
                'data' => $query->result_array(),
                'status' => 1,
                'responseMessage' => "Success"
            );
        } else {
            $response = array(
                'data' => [],
                'status' => 0,
                'responseMessage' => "No subscribers found."
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

        $query = $this->db->get_where('wrh_subscribers', array('subscriberEmailId' => $subscriber_details['subscriberEmailId']));

        if ($query->num_rows() > 0) {
            $this->db->delete('wrh_subscribers', array('subscriberEmailId' => $subscriber_details['subscriberEmailId']));
            
            return array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => "Email already exist."
            );
        }

        return array(
            'data' => NULL,
            'status' => 0,
            'responseMessage' => "Something went wrong. Please try again."
        );
    }

}
