<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 30/11/19
 * Time: 12:18 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryController extends CI_Controller
{
    function __construct() {
        parent::__construct();
       $user_type = $this->session->userdata('admin_login');
        if (!$user_type) {
            redirect( base_url('admin'));
        }


        $this->load->model('Category');
    }

    public function index() {
        $data = array();
        $data["categories"] = $this->Category->getCategories();
        $this->load->view('admin/categories', $data);
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            // setting validation rule
            $this->form_validation->set_rules('category_name', 'Category Name', 'required');

            if ($this->form_validation->run() !== FALSE)
            {
                $input = array ( 'category_name' => $this->input->post('category_name'));
                $this->Category->add_category($input);
            }

            redirect('categories');
        }
    }

    public function update() {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            // setting validation rule
            $this->form_validation->set_rules('category_name', 'Category Name', 'required');
            $this->form_validation->set_rules('category_id', 'Category ID', 'required');

            if ($this->form_validation->run() !== FALSE)
            {
                $input = array ( 'category_name' => $this->input->post('category_name'));
                $where = array('id' => $this->input->post('category_id'));

                $res = $this->Category->update_category($input, $where);
                if ($res) {
                    header('Content-Type: application/json');
                     echo json_encode(array("success" => true, "message" => "Category updated successfully"));
                } else {
                    return json_encode(["success" => false, "message" => "Category updated successfully"]);
                }
            }
        }
    }

    public function delete($category_id) {
        $this->Category->delete_category($category_id);
        redirect('categories');
    }
}