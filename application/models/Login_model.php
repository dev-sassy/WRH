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
            $status = "Invalid user name or password. Please check your login details.";
        }

        return array(
            'status' => $status,
            'isSuccess' => $flag
        );
    }

    function change_pass() {
        $data = array("password" => md5($this->input->post('password')));
        $this->db->where('username', $this->session->userdata('USERNAME'));
        $this->db->update('wrh_users', $data);
        return $this->db->affected_rows();
    }

    function chk_for_old_pass($user_name, $input_pass) {
        $this->db->where('username', $user_name);
        $this->db->where('password', md5($input_pass));
        $q = $this->db->get('wrh_users');
        if ($q->num_rows() == 1) {
            return 'valid';
        } else {
            return 'Invalid Password';
        }
    }

    function edit_p_profile() {
        $this->db->where("username", $this->session->userdata('USERNAME'));
        $q = $this->db->get("wrh_users");
        if ($q->num_rows() >= 1) {
            return $q->result_array();
        }
    }

    function update_admin() {
        $firstname = trim($this->input->post('firstname'));
        $lastname = trim($this->input->post('lastname'));
        $data = array("fname" => $firstname, "lname" => $lastname);
        $this->db->where('username', $this->session->userdata('USERNAME'));
        $this->db->update("wrh_users", $data);
        return 1;
    }

}
