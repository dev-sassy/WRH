<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public $upload_data = array(); // To store uploaded image data/info.

    /*
     * __construct() --> Default constructor.
     */

    public function __construct() {
        parent:: __construct();

        // Check for session if user logged-in.
        if ($this->session->userdata('USERNAME') === NULL || $this->session->userdata('USERNAME') === '') {
            redirect(base_url(), 'refresh');
        }
        $this->load->model('categoryServices_model');
    }

    /*
     * index() --> Default function whenever the controller is called.
     */

    public function index() {
        $this->viewCategories();
    }

    /*
     * viewCategories() --> View categories page is loaded. (Categories > View All Categories)
     */

    public function viewCategories() {
        $data['categories'] = $this->categoryServices_model->categoryList(array(), true);
        $data['categories'] = $data['categories']['data'];
        $data['cat_count'] = count($data['categories']);
        $data['title'] = "Category View";

        $data['content'] = $this->load->view("category/view_categories", $data, true);        
        $this->load->view("default_layout", $data);
    }

    /*
     * validate_image() --> Upload image & validate if it's an image file & <= 1MB.
     * @return: bool true/false
     */

    function validate_image() {
        if ($_FILES && $_FILES['categoryImage']['size'] !== 0) {
            $upload_dir = './images/category';

            if (!is_dir($upload_dir)) { // Create directory if not exists.
                mkdir($upload_dir, 0777, true);
            }
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $_FILES['categoryImage']['name'];
            $config['overwrite'] = FALSE;
            $config['max_size'] = 1024; // Default to 1MB.

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('categoryImage')) {
                $this->form_validation->set_message('validate_image', "File size should be <= 1 MB.");
                return FALSE;
            } else {
                $this->upload_data = $this->upload->data();
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    /*
     * addCategory() --> Load add category page. (Categories > Add Category)
     */

    public function addCategory() {
        $this->load->helper('form');

        if ($this->input->post('add_category')) {
            $this->load->library('form_validation');

            // Validate the value against permissible rules.
            $this->form_validation->set_rules('categoryName', 'Category name', "trim|required|is_unique[wrh_category.categoryName]|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z' ]+$/]");
            $this->form_validation->set_rules('categoryImage', 'Category image', "callback_validate_image");

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->categoryServices_model->addCategory($this->upload_data);
                if ($flag) {
                    $this->session->set_flashdata('success_message', 'Category added successfully.');
                    redirect(base_url() . 'category/viewCategories', 'refresh');
                } else {
                    $this->session->set_flashdata('error_message', 'Please try again.');
                    redirect(base_url() . 'category/addCategory', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'category/addCategory', 'refresh');
            }
        }

        $data['js'] = array("customs/category");
        $data['title'] = "Add Category";
        $data['content'] = $this->load->view("category/add_category", $data, true);
        $this->load->view("default_layout", $data);
    }

    /*
     * editCategory() --> Load edit category page from category view page.
     * @param: param1 int --> category id.
     */

    public function editCategory($categoryId) {
        $this->load->helper('form');

        if ($this->input->post('edit_category')) {
            $this->load->library('form_validation');

            // Validate the value against permissible rules.
            $this->form_validation->set_rules('categoryName', 'Category name', "trim|required|min_length[2]|max_length[50]|regex_match[/^[a-zA-Z' ]+$/]");
            $this->form_validation->set_rules('categoryImage', 'Categoryimage', "callback_validate_image");

            if ($this->form_validation->run() === TRUE) {
                $flag = $this->categoryServices_model->updateCategory($this->input->post('categoryId'), $this->upload_data);
                if ($flag) {
                    $this->session->set_flashdata('success_message', 'Category updated successfully.');
                    redirect(base_url() . 'category/viewCategories', 'refresh');
                } else {
                    $this->session->set_flashdata('error_message', 'Please try again.');
                    redirect(base_url() . 'category/editCategory/' . $categoryId, 'refresh');
                }
            } else {
                $this->session->set_flashdata('error_message', validation_errors());
                redirect(base_url() . 'category/editCategory/' . $categoryId, 'refresh');
            }
        }

        $data['cat_details'] = $this->categoryServices_model->editCategory($categoryId);
        if (!$data['cat_details']) { // Redirect to category page if user tries to insert other user id in URL, if not exists.
            redirect(base_url() . 'category', 'refresh');
        }
        $data['js'] = array("customs/category");
        $data['title'] = "Edit Category";
        $data['content'] = $this->load->view("category/edit_category", $data, true);
        $this->load->view("default_layout", $data);
    }

    /*
     * deleteCategory() --> Delete category from category view page.
     * @param: param1 int --> category id.
     */

    public function deleteCategory($categoryId) {
        $flag = $this->categoryServices_model->deleteCategory($categoryId);
        if ($flag) {
            $this->session->set_flashdata('success_message', 'Category deleted successfully.');
            redirect(base_url() . 'category/viewCategories');
        } else {
            $this->session->set_flashdata('error_message', 'Please try again.');
            redirect(base_url() . 'category');
        }
    }

}
