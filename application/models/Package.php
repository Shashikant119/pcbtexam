<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 21/12/19
 * Time: 9:52 PM
 */

class Package extends CI_Model
{
    function __construct() {
        parent::__construct();
    }
public function getPackageCount()
    {
        
        $count = $this->db->query("SELECT COUNT(*) AS c FROM qms_packages")->row()->c;
        return $count;
    }
    public function getAllPackages($user_id = 0) {
        $packages = [];
        try {
            $packages = $this->db->select('*')
                ->from('qms_packages');
                if ($user_id > 0) {
                    $packages = $packages->join('user_package', 'qms_packages.package_id = user_package.package_id')
                         ->where(array("user_package.user_id" => $user_id,'package_type'=>'Paid'));
                   
                }
            $packages = $packages->where(array('is_active' => 1))
                ->order_by('package_duration', 'ASC')
                ->get()->result();
               // echo $this->db->last_query();die;
        } catch (\Exception $exception) {

        }
        return $packages;
    }

    public function addPackage($input) {
        //echo "<pre>";print_r($input);die;
        try {
            $this->db->insert('qms_packages', $input);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function addUserPackage($input) {
        try {
            $this->db->insert_batch('user_package', $input);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getUserPackages($user_id) {
        $packages = [];
        try {
            $packages = $this->db->select('package_id, package_start, package_end')
                ->from('user_package')
                ->where(array('user_id' => $user_id, 'status' => 1))
                ->get()->result();
        } catch (\Exception $exception) {

        }
        return $packages;
    }

    public function deleteUserPackage($user_id) {
        try {
            $this->db->where(array("user_id" => $user_id));
            $this->db->delete("user_package");
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getPackageById($package_id) {
        try {
            $package = $this->db->select('*')->from('qms_packages')
                ->where(array("package_id" => $package_id, 'is_active' => 1))
                ->get()->row();
            return $package;
        } catch (\Exception $exception) {
            return [];
        }
    }

}