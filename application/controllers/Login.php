<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();
        $this->load->model('login_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     * --> Load login page, create user session if not logged-in.
     */

    public function index() {
        // Check for session if user logged-in.
        if ($this->session->userdata('USERNAME') !== NULL && $this->session->userdata('USERNAME') !== '') {
            redirect(base_url() . 'coupons', 'refresh');
        }
        $this->load->model('login_model');

        $check_login["status"] = '';

        if ($this->input->post('chk_login')) {
            $check_login = $this->login_model->chk_login();
            if ($check_login["isSuccess"]) {
                $this->session->set_userdata('USERNAME', $this->input->post('username'));
                redirect(base_url() . 'coupons');
            }
        }

        $this->load->view('login_view', $check_login);
    }

    /*
     * logout() --> Destroy the user session.
     * --> Redirect to login page.
     */

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'login', 'refresh');
    }

    /*
     * Function Name : change_password()
     * Purpose : Change password of doctor
     */

    function change_password() {
        if ($this->session->userdata('USERNAME')) {
            $data['title'] = "Change Password";
            $data['js'] = array("customs/change_pass");
            if ($this->input->post('update')) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                $this->form_validation->set_rules('re_password', 'Confirm Password', 'trim|required|matches[password]');
                if ($this->form_validation->run() === TRUE) {
                    $res = $this->login_model->change_pass();
                    if ($res > 0) {
                        $this->session->set_flashdata('success_message', 'Your password has been changed. Please login to your account.');
                        $this->logout();
                    } else {
                        $this->session->set_flashdata('error_message', 'Old password and new password can not be same.');
                        redirect(base_url() . 'login/change_password', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', validation_errors());
                    redirect(base_url() . 'login/change_password', 'refresh');
                }
            }
            $data['content'] = $this->load->view("change_pass", $data, true);
            $this->load->view("default_layout", $data);
        } else {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    function chk_for_old_pass() {
        $user_name = $this->session->userdata('USERNAME');
        $input_pass = $this->input->post('old_password');
        $data = $this->login_model->chk_for_old_pass($user_name, $input_pass);

        echo $data;
        exit;
    }

    function edit_profile() {
        if ($this->session->userdata('USERNAME')) {
            $this->load->helper('form');
            $data['asd'] = $this->login_model->edit_p_profile();
            $data['title'] = "Edit Profile";
            $data['js'] = array("customs/edit_profile");

            if ($this->input->post('update_asd')) {
                $this->load->library('form_validation');

                $this->form_validation->set_rules('firstname', 'First name', 'trim|required|min_length[2]|max_length[20]|regex_match[/^[a-zA-Z]+$/]');
                $this->form_validation->set_rules('lastname', 'Last name', 'trim|required|min_length[2]|max_length[20]|regex_match[/^[a-zA-Z]+$/]');

                if ($this->form_validation->run() === TRUE) {
                    $data['status'] = $this->login_model->update_admin();
                    if ($data['status']) {
                        $this->session->set_flashdata('success_message', 'Profile updated successfully.');
                        redirect(base_url() . 'login/edit_profile', 'refresh');
                    } else {
                        $this->session->set_flashdata('error_message', 'Please try again latter.');
                        redirect(base_url() . 'login/edit_profile', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error_message', validation_errors());
                    redirect(base_url() . 'login/edit_profile', 'refresh');
                }
            }
            $data['content'] = $this->load->view("edit_profile", $data, true);
            $this->load->view("default_layout", $data);
        } else {
            redirect(base_url() . 'login', 'refresh');
        }
    }

}
