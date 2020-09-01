<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 13/02/20
 * Time: 12:21 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $user_type =$this->session->userdata('admin_login');
        if (!$user_type) {
            redirect(base_url() . 'admin/');
        }

        $this->load->model('User');
        $this->load->model('Package');
        $this->load->model('Payment');
        $this->load->model('QuestionBank');
        $this->load->model('Quiz');
         $this->load->model('Category');
           
        $this->load->model('Quiz_model');
    }

    public function index()
    {
        $data = array();
        $data['total_users'] = $this->User->getUsersCount();
        $data['total_quizes'] = count($this->Quiz->getAllQuizes());
        $data['total_payments'] =$this->db->query("SELECT COUNT(*) AS c FROM razor_pay")->row()->c;
        $data['total_questions'] = $this->db->query("SELECT COUNT(*) AS c FROM qms_questions WHERE `is_active`=1")->row()->c;
        $data['total_packages'] = $this->db->query("SELECT COUNT(*) AS c FROM qms_packages WHERE `is_active`=1")->row()->c;
      
        $data['total_results'] = $this->db->query("SELECT COUNT(*) as c FROM qms_results")->row()->c;
         $data['total_category'] = count($this->Category->getCategories());
        $this->load->view('admin/dashboard', $data);
    }

}