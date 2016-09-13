<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();
        $this->load->model('notification_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     */

    public function index() {
        if ($this->session->userdata('USERNAME')) {
            $data['title'] = "View All Notifications";
            $data['noti_detail'] = $this->notification_model->fetchNotification();
            $data['noti_count'] = count($data['noti_detail']);
            $data['content'] = $this->load->view("notification/view_notification", $data, true);
            $data['js'] = array("customs/confirmation_modal");
            
            $this->load->view("default_layout", $data);
        } else {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    public function addNotification() {
        if ($this->session->userdata('USERNAME')) {
            $data['title'] = "Add Notifications";
            $data['js'] = array("notification");
            if ($this->input->post('add_note')) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('description', 'description', 'trim|required');
                if ($this->form_validation->run() === TRUE) {
                    $data['status'] = $this->notification_model->addNotification();
                    if ($data['status']) {
                        $this->session->set_flashdata('success_message', "Notification created successfully");
                        //send notification
                        $nofications = $this->notification_model->androidNotifications();
                        $notifications_count = count($nofications);

                        if ($notifications_count == 1) {
                            $target = $nofications[0]['deviceToken'];
                        } else {
                            foreach ($nofications as $val) {
                                $target[] = $val['deviceToken'];
                            }
                        }
                        $this->sendMessage($target, $this->input->post('description'), $this->input->post('title'));
                        redirect(base_url() . 'notifications', 'refresh');
                    } else {
                        $this->session->set_flashdata('error_message', "Please try again, notification not created");
                        redirect(base_url() . 'notifications/addNotification', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', validation_errors());
                    redirect(base_url() . 'notifications/addNotification', 'refresh');
                }
            }
            $data['content'] = $this->load->view("notification/add_notification", $data, true);
            $this->load->view("default_layout", $data);
        } else {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    public function sendMessage($target, $message, $title = "TIMES LUXURIA") {
        //FCM api URL
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AIzaSyDtC5UIYwY5nOiuIKj-UXgrR3JAMtyPbsI';
        $fields = array();
        $fields['notification'] = array("title" => $title, "body" => $message);
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
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . "/wrh/application/logs/pushnotification/send_android_" . date('Y-m-d') . ".txt", "a+");
        fwrite($file, "=============start : android======================\n\n");
        fwrite($file, date('Y-m-d H:i:s') . "\n\n");
        fwrite($file, json_encode($result) . "\n\n");
        fwrite($file, "Sent to \n\n");
        fwrite($file, json_encode($target) . "\n\n");
        fwrite($file, "=============end======================\n\n");
        return $result;
    }

    function del_notifications($id = null) {
        if ($this->session->userdata('USERNAME')) {
            $data['status'] = $this->notification_model->del_notifications($id);
            if ($data['status']) {
                $this->session->set_flashdata('success_message', "Notification deleted successfully");
                redirect(base_url() . 'notifications', 'refresh');
            } else {
                $this->session->set_flashdata('error_message', "Please try again, notification not deleted");
                redirect(base_url() . 'notifications', 'refresh');
            }
        } else {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    function edit_notifications($id = null) {
        if ($this->session->userdata('USERNAME')) {
            $data['title'] = "Edit Notifications";
            $data['js'] = array("notification");
            $data['note_detail'] = $this->notification_model->edit_notifications($id);
            if ($data['note_detail'][0]['created_on'] >= date('Y-m-d')) {
                if ($this->input->post('add_note')) {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('description', 'description', 'trim|required');
                    if ($this->form_validation->run() === TRUE) {
                        $data['status'] = $this->notification_model->updateNotification($id);
                        if ($data['status']) {
                            $this->session->set_flashdata('success_message', "Notification updated successfully");
                            redirect(base_url() . 'notifications', 'refresh');
                        } else {
                            $this->session->set_flashdata('error_message', "Please try again, notification not updated");
                            redirect(base_url() . 'notifications/edit_notifications', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('error_message', validation_errors());
                        redirect(base_url() . 'notifications/edit_notifications', 'refresh');
                    }
                }
                $data['content'] = $this->load->view("notification/edit_notification", $data, true);
                $this->load->view("default_layout", $data);
            } else {
                redirect(base_url() . 'notifications', 'refresh');
            }
        } else {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    public function notificationsList() {
        // Default response.
        $response = array(
            'data' => NULL,
            'status' => 0,
            'responseMessage' => 'Server refused to process request. Please try again later.'
        );
        $response = $this->notification_model->notificationsList();
        // Send JSON response.
        header('Content-type: application/json');
        echo json_encode(array('outputParam' => $response));
        exit;
    }

    public function aboutus() {
        $data['content'] = $this->notification_model->cms();
        $this->load->view('aboutus', $data);
    }

    public function editaboutus() {
        $data['title'] = 'About Us';
        $data['contentdata'] = $this->notification_model->cms();
        if ($this->input->post('description')) {
            $this->notification_model->updateaboutus($this->input->post('description'));
            $this->session->set_flashdata('success_message', "Record Updated successfully");
            redirect(base_url() . 'editaboutus', 'refresh');
        }
        $data['content'] = $this->load->view("editaboutus", $data, true);
        $this->load->view("default_layout", $data);
    }

}
