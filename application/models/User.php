<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 31/12/19
 * Time: 12:28 AM
 */

class User extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    public function addUser($input) {
        try {
            $this->db->insert('qms_users', $input);
            return $this->db->insert_id();
        } catch (\Exception $exception) {

        }
    }

    public function updateUser($input, $where) {
        try {
            $this->db->where($where);
            $this->db->update("qms_users", $input);
            return true;
        } catch (\Exception $exception) {
            /*echo $exception->getMessage();
            die;*/
            return false;
        }
    }

    public function getUserDetail($user_id) {
        $user = [];
        try {
            $user = $this->db->select('*')->from('qms_users')->where(array("is_active" => 1, "user_id" => $user_id))->get()->row();
        } catch (\Exception $exception) {

        }

        return $user;
    }

    public function getUsersCount() {
        $user_count = 0;
        try {
            $this->db->from('qms_users');
            $user_count = $this->db->count_all('qms_users');
        } catch (\Exception $exception) {
            //Log Error here
        }

        return $user_count;
    }


}