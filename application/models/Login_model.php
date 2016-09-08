<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
    /*
     * chk_login() --> Check if username & password is valid.     
     * @return: array(status, isSuccess) --> (string message, bool true/false)
     */

    public function chk_login() {
        $username = trim($this->input->post('username'));
        $password = md5(trim($this->input->post('password')));

        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('wrh_users');

        $status = NULL;
        $flag = FALSE;

        if ($query->num_rows() > 0) {
            $flag = TRUE;
        } else {
            $flag = FALSE;
            $status = "Invalid User Name Or Password. Please check your login details.";
        }

        return array(
            'status' => $status,
            'isSuccess' => $flag
        );
    }

}
