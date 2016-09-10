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
			$this->load->view("default_layout", $data);	
		}else{
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
					if($data['status']){
						$this->session->set_flashdata('success_message', "Notification created successfully");
						redirect(base_url() . 'notifications', 'refresh');
					}else{
						$this->session->set_flashdata('error_message', "Please try again, notification not created");
						redirect(base_url() . 'notifications/addNotification', 'refresh');
					}
				}else{
					$this->session->set_flashdata('error_message', validation_errors());
					redirect(base_url() . 'notifications/addNotification', 'refresh');
				}
			}
			$data['content'] = $this->load->view("notification/add_notification", $data, true);
			$this->load->view("default_layout", $data);
		}else{
			redirect(base_url() . 'login', 'refresh');
		}
    }
	
	function del_notifications($id = null){
		if ($this->session->userdata('USERNAME')) {
			$data['status'] = $this->notification_model->del_notifications($id);
			if($data['status']){
				$this->session->set_flashdata('success_message', "Notification deleted successfully");
				redirect(base_url() . 'notifications', 'refresh');
			}else{
				$this->session->set_flashdata('error_message', "Please try again, notification not deleted");
				redirect(base_url() . 'notifications', 'refresh');
			}
		}else{
			redirect(base_url() . 'login', 'refresh');
		}
	}
	
	function edit_notifications($id = null){
		if ($this->session->userdata('USERNAME')) {
			$data['title'] = "Edit Notifications";
			$data['js'] = array("notification");
		 	$data['note_detail'] = $this->notification_model->edit_notifications($id);
			if($data['note_detail'][0]['created_on'] >= date('Y-m-d')){
				if ($this->input->post('add_note')) {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('description', 'description', 'trim|required');
					if ($this->form_validation->run() === TRUE) {
						$data['status'] = $this->notification_model->updateNotification($id);
						if($data['status']){
							$this->session->set_flashdata('success_message', "Notification updated successfully");
							redirect(base_url() . 'notifications', 'refresh');
						}else{
							$this->session->set_flashdata('error_message', "Please try again, notification not updated");
							redirect(base_url() . 'notifications/edit_notifications', 'refresh');
						}
					}else{
						$this->session->set_flashdata('error_message', validation_errors());
						redirect(base_url() . 'notifications/edit_notifications', 'refresh');
					}
				}
				$data['content'] = $this->load->view("notification/edit_notification", $data, true);
				$this->load->view("default_layout", $data);
			}else{
				redirect(base_url() . 'notifications' , 'refresh');
			}
			
		}else{
			redirect(base_url() . 'login', 'refresh');
		}
	}

}
