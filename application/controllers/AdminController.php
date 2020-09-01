<?php

/**

 * Created by PhpStorm.

 * User: amitpandey

 * Date: 30/12/19

 * Time: 11:42 PM

 */



defined('BASEPATH') OR exit('No direct script access allowed');



class AdminController extends CI_Controller

{

    function __construct()

    {

        parent::__construct();

        $is_admin_login = $this->session->userdata('admin_login');

        if (!$is_admin_login) {

            redirect('admin');

        }



        $this->load->model('User_model');

        $this->load->model('Quiz_model');

        $this->load->model('Package');

        $this->load->model('Auth');

       

        $this->load->model('User');

        $this->load->model('AnswerSheet');

    }



    public function show_add_user_form() {

        $data = array();

        $data["packages"] = $this->Package->getAllPackages();

        $this->load->view('admin/user/add-user', $data);

    }

   public function controlAnswerSheetView() {

         

        $data = array();

        $data["result"] = $this->AnswerSheet->allAnswerSheet();

        //echo "<pre>";print_r($data["result"]);die;

        $this->load->view('admin/answerSheet', $data);

    }

    public function setResultViewpermission($id,$val) {

         

        $this->AnswerSheet->updateView($id,$val);

        redirect('index.php/setViewpermission');

    }



    public function add_user()

    {



        if ($this->input->server('REQUEST_METHOD') !== 'POST') {

            $this->session->set_flashdata('msg', "Please try again later");

            redirect(base_url('add-user'));

        }



        // setting validation rule

        $this->form_validation->set_rules('name', 'Name', 'required');

        $this->form_validation->set_rules('email_id', 'Email', 'required');

        $this->form_validation->set_rules('mobile', 'Mobile', 'required');

        $this->form_validation->set_rules('dob', 'dob', 'required');

        $this->form_validation->set_rules('user_type', 'User Type', 'required');



        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('msg', "Please fill all required field");

            redirect(base_url('add-user'));

        }



        $name = $this->input->post('name');

        $email = $this->input->post('email_id');

        $mobile = $this->input->post('mobile');

        $dob = date('Y-m-d', strtotime($this->input->post('dob')));

        $address = $this->input->post('address');

        $user_type = $this->input->post('user_type');



        $username = "";

        if ($user_type == 1) {

            $username = $this->input->post('username');

        }



        if (empty($this->input->post('password'))) {

            $password = $this->Auth->generatePassword();

        } else {

            $password = $this->input->post('password');

        }



        $data = array(

            'username' => $user_type == 1 ? $username : $email,

            'password' => md5($password),

            'user_type' => $user_type,

            'name' => $name,

            'email' => $email,

            'mobile' => $mobile,

            'dob' => $dob,

            'address' => $address

        );



        $user_id = $this->User->addUser($data);



        if ($user_id) {

            if ($user_type == 2) {

                $username = 'PCBT' . str_pad($user_id, 5, "0", STR_PAD_LEFT);

                $this->User->updateUser(array('username' => $username), array('user_id' => $user_id));

            }



            $this->session->set_flashdata('msg', 'User added successfully.');

            $this->session->set_flashdata('temp_username', $username);

            $this->session->set_flashdata('temp_password', $password);

        }



        $packages = $this->input->post('quiz_packages');



        if (empty($packages)) {

            redirect(base_url('user-management'));

        }



        date_default_timezone_set('Asia/Kolkata');

        $currentTime = date('Y-m-d h:i:s', time());

        $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));

        $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));



        $package_data = [];

        $i = 0;

        foreach ($packages as $package) {

            $temp_data = array(

                'user_id' => $user_id,

                'package_id' => $package,

                'package_start' => $start_date[$i],

                'package_end' => $end_date[$i],

                'status' => 1,

                'assigned_by' => 'admin',

                'enterydate' => $currentTime,

            );

            $i++;

            array_push($package_data, $temp_data);

        }



        $added_status = $this->Package->addUserPackage($package_data);



        if ($added_status) {

            $this->session->set_flashdata('msg', 'User added and Package assigned successfully.');

        }



        redirect(base_url('user-management'));

    }



    public function edit_user($user_id) {

        $data = array();

        $data["user"] = $this->User->getUserDetail($user_id);

        $data["packages"] = $this->Package->getAllPackages();

        $assigned_package = $this->Package->getUserPackages($user_id);

        $temp_package = [];

        foreach ($assigned_package as $package) {

            $temp_package[$package->package_id] = $package;

        }



        $data["assigned_packages"] = $temp_package;

        $data["assigned_packages_id"] = array_keys($temp_package);



        $this->load->view('admin/user/edit-user', $data);

    }

public function assigned_pack($user_id)

{

        $assigned_package = $this->Package->getUserPackages($user_id);

        $temp_package = [];

        foreach ($assigned_package as $package) {

            $temp_package[$package->package_id] = $package;

        }



        $data["assigned_packages"] = $temp_package;

        $assigned_packages_id = array_keys($temp_package);

       return $assigned_packages_id;

}

    public function update_user() {



        if ($this->input->server('REQUEST_METHOD') !== 'POST') {

            $this->session->set_flashdata('msg', "Please try again later");

            redirect(base_url('add-user'));

        }



       //echo "<pre>";print_r($_POST);die;

        $this->form_validation->set_rules('name', 'Name', 'required');

        $this->form_validation->set_rules('email_id', 'Email', 'required');

        $this->form_validation->set_rules('mobile', 'Mobile', 'required');

        $this->form_validation->set_rules('dob', 'dob', 'required');

        $this->form_validation->set_rules('user_type', 'User Type', 'required');

        $this->form_validation->set_rules('user_id', 'User Type', 'required');



        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('msg', "Please fill all required field");

            redirect(base_url('add-user'));

        }



        $user_id = $this->input->post('user_id');

        $name = $this->input->post('name');

        $email = $this->input->post('email_id');

        $mobile = $this->input->post('mobile');

        $dob = date('Y-m-d', strtotime($this->input->post('dob')));

        $address = $this->input->post('address');

        $user_type = $this->input->post('user_type');



        if ($user_type == 1) {

            $username = $this->input->post('username');

            $data["username"] = $username;

        }



        $data = array(

            'name' => $name,

            'email' => $email,

            'mobile' => $mobile,

            'dob' => $dob,

            'address' => $address

        );



        $password = $this->input->post('password');

        if (!empty($password)) {

            $data["password"] = md5($password);

        }

        $data["pdf_encrypt"] =$password;

        $this->User->updateUser($data, array("user_id" => $user_id));



        if ($password) {

            // $this->session->set_flashdata('temp_username', $username);

            $this->session->set_flashdata('temp_password', $password);

        }



        $added_status = false;

        if ($user_type == 2) {

            $packages = $this->input->post('quiz_packages');



            $this->Package->deleteUserPackage($user_id);



            if (empty($packages)) {

                redirect(base_url('user-management'));

            }



            date_default_timezone_set('Asia/Kolkata');

            $currentTime = date('Y-m-d h:i:s', time());

            $start_date = $this->input->post('start_date');

            $end_date = $this->input->post('end_date');

          // echo "<pre>";print_r($_POST);die;

            $package_data = [];

            $i = 0;



            foreach ($packages as $package) {

                 $strtD=$this->input->post('start_date_'.$package);

                 $endD=$this->input->post('end_date_'.$package);

                    $temp_data = array(

                    'user_id' => $user_id,

                    'package_id' => $package,

                    'package_start' =>date('Y-m-d',strtotime($strtD)),

                    'package_end' => date('Y-m-d', strtotime($endD)),

                    'status' => 1,
                     
                    'assigned_by' => 'admin',

                    'enterydate' => $currentTime,

                );

                $i++;

                array_push($package_data, $temp_data);

            }

      

            $added_status = $this->Package->addUserPackage($package_data);

        }



        if ($added_status) {

            $this->session->set_flashdata('msg', 'User updated and Package assigned successfully.');

        } else {

            $this->session->set_flashdata('msg', 'User updated successfully');

        }



        redirect(base_url('user-management'));

    }



}