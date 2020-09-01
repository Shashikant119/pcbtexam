<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 30/11/19
 * Time: 12:17 AM
 */

class Level extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    public function getLevels() {
        try {
            $levels = [];
            $levels = $this->db->select("*")->from('qms_levels')->get()->result();
        } catch (\Exception $exception) {
            //TODO: Log Exception here
        }

        return $levels;
    }

    public function add_level($input) {
        try {
            $this->db->insert('qms_levels', $input);
            $this->session->set_flashdata('msg', 'Level added successfully.');
        } catch (\Exception $e) {
            $this->session->set_flashdata('error', 'Something went wrong, please try again later');
        }
    }

    public function update_level($input, $where) {
        try {
            $this->db->where($where);
            $this->db->update('qms_levels', $input);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function delete_level($id) {
        try {
            $this->db->where('id', $id);
            $this->db->delete('qms_levels');
            $this->session->set_flashdata('msg', 'Level deleted successfully.');
        } catch (\Exception $exception) {
            $this->session->set_flashdata('error', 'Something went wrong please try again');
        }
    }

}