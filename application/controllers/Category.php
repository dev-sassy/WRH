<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent:: __construct();
        $this->load->model('categoryServices_model');
    }

    public function index() {
        $this->viewCategories();
    }

    public function viewCategories() {
        $data['categories'] = $this->categoryServices_model->categoryList(array(), true);
        $data['categories'] = $data['categories']['data'];
        $data['cat_count'] = count($data['categories']);
        $data['title'] = "Category View";

        $data['content'] = $this->load->view("category/view_categories", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function addCategory() {
        $this->load->helper('form');

        if ($this->input->post('add_category')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('categoryName', 'Category name', 'trim|required|min_length[2]|max_length[50]');

            if ($this->form_validation->run() === TRUE) {
                $this->categoryServices_model->addCategory();
                redirect(base_url() . 'category/viewCategories');
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'category/addCategory', 'refresh');
            }
        }

        $data['title'] = "Add Category";
        $data['content'] = $this->load->view("category/add_category", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function editCategory($categoryId) {
        $this->load->helper('form');

        if ($this->input->post('edit_category')) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('categoryName', 'Category name', 'trim|required|min_length[2]|max_length[50]');

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->categoryServices_model->updateCategory($this->input->post('categoryId'));
                if ($flag) {
                    redirect(base_url() . 'category/viewCategories');
                } else {
                    redirect(base_url() . 'category');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'category/editCategory/' . $categoryId, 'refresh');
            }
        }

        $data['cat_details'] = $this->categoryServices_model->editCategory($categoryId);
        $data['title'] = "Edit Category";
        $data['content'] = $this->load->view("category/edit_category", $data, true);
        $this->load->view("default_layout", $data);
    }

    public function deleteCategory($categoryId) {
        $flag = $this->categoryServices_model->deleteCategory($categoryId);
        if ($flag) {
            redirect(base_url() . 'category/viewCategories');
        } else {
            redirect(base_url() . 'category');
        }
    }

}
