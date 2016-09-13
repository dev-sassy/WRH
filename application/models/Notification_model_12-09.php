<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

    function fetchNotification() {
        $this->db->where("is_deleted", (int) 0);
        $this->db->order_by('notificationId', 'desc');
        $q = $this->db->get('wrh_notification');
        // Push Notification 
        /* $data = array('post_id'=>'12345','post_title'=>'A Blog post');
          $target = array('token1','token2','token3');
          $this->sendMessage($data, $target); */

        // Fetch Device Info
        /* $device_type = 'ANDROID';
          $user_list = $this->user_list_for_notification($device_type);
          echo "<pre>";
          print_r($user_list);die; */

        if ($q->num_rows() > 0) {
            return $q->result();
        }
    }

    public function user_list_for_notification($device_type) {
        $this->db->where('deviceType', $device_type);
        $this->db->where('is_deleted', (int) 0);
        $q = $this->db->get('wrh_access_token_list');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
    }

    public function sendMessage($data, $target) {
        //FCM api URL
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'PASTE_YOUR_SERVER_KEY_HERE';

        $fields = array();
        $fields['data'] = $data;
        if (is_array($target)) {
            $fields['registration_ids'] = $target;
        } else {
            $fields['to'] = $target;
        }
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        //echo $result;die;
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    function addNotification() {
        $time = strtotime($this->input->post('event_date'));
        $newformat = date('Y-m-d', $time);
        $data = array("notification_message" => trim($this->input->post('description')),
            "created_on" => $newformat);
        $this->db->insert('wrh_notification', $data);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
    }

    function del_notifications($id) {
        $data = array("is_deleted" => (int) 1);
        $this->db->where("notificationId", $id);
        $this->db->update('wrh_notification', $data);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
    }

    function edit_notifications($id) {
        $this->db->where('notificationId', $id);
        $q = $this->db->get('wrh_notification');
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
    }

    function updateNotification($id) {
        $time = strtotime($this->input->post('event_date'));
        $newformat = date('Y-m-d', $time);
        $data = array("notification_message" => trim($this->input->post('description')),
            "created_on" => $newformat);
        $this->db->where("notificationId", $id);
        $this->db->update('wrh_notification', $data);
        return 1;
    }

    public function notificationsList() {
        $this->db->where("created_on <=", date("Y-m-d"));
        $query = $this->db->get_where('wrh_notification', array('is_deleted' => 0));

        if ($query->num_rows() > 0) {
            $notification_details = $query->result_array();

            $response = array(
                'data' => $notification_details,
                'status' => 1,
                'responseMessage' => 'success'
            );
        } else {
            $response = array(
                'data' => NULL,
                'status' => 0,
                'responseMessage' => 'No notifications found.'
            );
        }

        return $response;
    }

}
