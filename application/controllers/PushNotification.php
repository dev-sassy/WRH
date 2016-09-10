<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PushNotification extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();
        $this->load->model('wrhServices_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     */

    public function index() {
        
    }

    public function androidNotifications() {
        $nofications = $this->wrhServices_model->androidNotifications();

        $notifications_count = count($nofications);

        if ($notifications_count == 1) {
            $target = $nofications['deviceToken'];
        } else {
            $target = $nofications;
        }

        $todays_nofications = $this->wrhServices_model->fetchTodaysNotifications();

        if ($todays_nofications) {
            foreach ($todays_nofications as $notifications) {
                $this->sendMessage($target, $notifications['notification_message']);
            }
        }
    }

    public function iosNotifications() {
        print_r($this->wrhServices_model->iosNotifications());
    }

    public function sendMessage($target, $message) {
        //FCM api URL
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AIzaSyAJmWkhVPsnoEbOMr6BkCGE_SwJxmnnkjA';
        $fields = array();
        $fields['notification'] = array("title" => "TIMES LUXURIA", "body" => $message);
        $fields['data'] = array("message" => $message);

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
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

}
