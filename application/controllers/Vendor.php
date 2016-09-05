<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public $upload_data = array();

    public function __construct() {
        parent:: __construct();

        if ($this->session->userdata('USERNAME') === NULL || $this->session->userdata('USERNAME') === '') {
            redirect(base_url(), 'refresh');
        }
        $this->load->model('vendorServices_model');
    }

    public function index() {
        $this->viewVendors();
    }

    public function viewVendors() {
        $data['vendors'] = $this->vendorServices_model->viewAllVendors();
        $data['vendor_count'] = count($data['vendors']);
        $data['title'] = "Vendor View";

        $data['content'] = $this->load->view("vendor/view_vendors", $data, true);
        $this->load->view("default_layout", $data);
    }

    function validate_image() {
        if ($_FILES && $_FILES['vendorImage']['size'] !== 0) {
            $upload_dir = './images/vendor';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $_FILES['vendorImage']['name'];
            $config['overwrite'] = FALSE;
            $config['max_size'] = 1024;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('vendorImage')) {
                $this->form_validation->set_message('validate_image', 'File size should be <= 1 MB.');
                return FALSE;
            } else {
                $this->upload_data = $this->upload->data();
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    public function addVendor() {
        $this->load->helper('form');

        if ($this->input->post('add_vendor')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('vendorName', 'Vendor name', "trim|required|min_length[2]|max_length[150]|regex_match[/^[a-zA-Z' ]+$/]");
            $this->form_validation->set_rules('vendorImage', 'Vendor image', "callback_validate_image");

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->vendorServices_model->addVendor($this->upload_data);
                if ($flag) {
                    $this->session->set_flashdata('success_message', 'Vendor added successfully.');
                    redirect(base_url() . 'vendor/viewVendors', 'refresh');
                } else {
                    $this->session->set_flashdata('error_message', 'Please try again.');
                    redirect(base_url() . 'vendor/addVendor', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'vendor/addVendor', 'refresh');
            }
        }

        $data['js'] = array("customs/vendor");
        $data['title'] = "Add Vendor";
        $data['content'] = $this->load->view("vendor/add_vendor", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function editVendor($vendorId) {
        $this->load->helper('form');

        if ($this->input->post('edit_vendor')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('vendorName', 'Vendor name', "trim|required|min_length[2]|max_length[150]|regex_match[/^[a-zA-Z' ]+$/]");
            $this->form_validation->set_rules('vendorImage', 'Vendor image', "callback_validate_image");

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->vendorServices_model->updateVendor($this->input->post('vendorId'), $this->upload_data);
                if ($flag) {
                    $this->session->set_flashdata('success_message', 'Vendor updated successfully.');
                    redirect(base_url() . 'vendor/viewVendors', 'refresh');
                } else {
                    $this->session->set_flashdata('error_message', 'Please try again.');
                    redirect(base_url() . 'vendor/editVendor/' . $vendorId, 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'vendor/editVendor/' . $vendorId, 'refresh');
            }
        }

        $data['vendor_details'] = $this->vendorServices_model->editVendor($vendorId);
        if (!$data['vendor_details']) {
            redirect(base_url() . 'vendor', 'refresh');
        }
        $data['js'] = array("customs/vendor");
        $data['title'] = "Update Vendor";
        $data['content'] = $this->load->view("vendor/edit_vendor", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function deleteVendor($vendorId) {
        $flag = $this->vendorServices_model->deleteVendor($vendorId);
        if ($flag) {
            $this->session->set_flashdata('success_message', 'Vendor deleted successfully.');
            redirect(base_url() . 'vendor/viewVendors');
        } else {
            $this->session->set_flashdata('error_message', 'Please try again.');
            redirect(base_url() . 'vendor');
        }
    }

}
