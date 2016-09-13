<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry_model extends CI_Model {

    function fetchInquiry() {
        $this->db->order_by('inquiryId', 'desc');
        $q = $this->db->get('wrh_inquiry');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
    }

    /*
     * validate_access() --> Checks if user have valid access.
     * @param: param1 array --> category info, param2 bool true/false.
     * @return: bool true/false
     */

    public function validate_access($inquiry_details, $finfo = NULL) {
        if (!empty($inquiry_details)) {
            $accessToken = $this->encryption->decrypt($inquiry_details['accessToken']);
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

                if ($access_details['uniqueId'] == $inquiry_details['uniqueId'] &&
                        $access_details['deviceType'] == $inquiry_details['deviceType']) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    public function addInquiry($inquiry_details) {
        if ($this->validate_access($inquiry_details) === TRUE) {
            $data = array(
                "inquiryName" => $inquiry_details['inquiryName'],
                "inquiryEmail" => $inquiry_details["inquiryEmail"],
                "inquirySubject" => $inquiry_details["inquirySubject"],
                "inquiryMessage" => $inquiry_details["inquiryMessage"],
                "inquiryPhone" => $inquiry_details["inquiryPhone"],
                "inquiredAt" => date('Y-m-d h:m:s'),
            );

            $this->db->insert('wrh_inquiry', $data);

            if ($this->db->affected_rows() > 0) {
                $message = $this->load->view('mail/contact_mail', $inquiry_details, true);
                $this->send_mail(FROM_EMAIL, $inquiry_details["inquiryEmail"], 'New Contact Inquiry', $message);
                $message = $this->load->view('mail/admin_contact_mail', $inquiry_details, true);
                $this->send_mail(FROM_EMAIL, TO_EMAIL, 'New Contact Inquiry', $message);
                $response = array(
                    'data' => true,
                    'status' => 1,
                    'responseMessage' => 'success'
                );
            } else {
                $response = array(
                    'data' => NULL,
                    'status' => 0,
                    'responseMessage' => 'Try Again.'
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

    function send_mail($from, $to, $sub, $msg) {
        $this->load->library('email');
        //$this->email->clear();
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from($from, 'H.B.M.C');
        $this->email->to(trim($to));
        $this->email->subject($sub);
        $this->email->message($msg);
        $this->email->send();
    }

}
