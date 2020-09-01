<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 31/12/19
 * Time: 7:11 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterController extends CI_Controller
{
    function __construct() {
        parent::__construct();
        /*$user_type = intval($this->session->userdata('user_type'));

        if($user_type != 2) {
            redirect(base_url());
        }

        $this->load->model('OnlineExam');
        $this->load->model('QuestionBank');
        $this->load->model('User_model');
        $this->load->model('Result');
        $this->load->helper('url');*/
    }

}