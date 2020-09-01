<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 30/11/19
 * Time: 12:17 AM
 */

class Category extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    public function getCategories() {
        try {
            $categories = [];
            $categories = $this->db->select("*")->from('qms_categories')->get()->result();
        } catch (\Exception $exception) {
            //TODO: Log Exception here
        }

        return $categories;
    }

    public function add_category($input) {
        try {
            $this->db->insert('qms_categories', $input);
            $this->session->set_flashdata('msg', 'Category added successfully.');
        } catch (\Exception $e) {
            $this->session->set_flashdata('error', 'Something went wrong, please try again later');
        }
    }

    public function update_category($input, $where) {
        try {
            $this->db->where($where);
            $this->db->update('qms_categories', $input);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function delete_category($id) {
        try {
            $this->db->where('id', $id);
            $this->db->delete('qms_categories');
            $this->session->set_flashdata('msg', 'Category deleted successfully.');
        } catch (\Exception $exception) {
            $this->session->set_flashdata('error', 'Something went wrong please try again');
        }
    }

}