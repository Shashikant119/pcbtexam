<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH.'third_party/Social_login/Social.php';
require_once FCPATH.'vendor/autoload.php';
class AuthController extends CI_Controller
{
    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('Auth');
        $this->load->model('Notification');
        $this->load->model('User');
        $this->load->model('User_model');
      
    }

    public function login() {

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $url = $_SERVER['HTTP_REFERER'];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please enter credentials to login</div>");
            redirect($url);
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $data['user'] = $this->User_model->validate_user($username, $password);
        if ($data['user']) {
            $this->session->set_userdata('login', 'true');
            $this->session->set_userdata('user_id', $data['user']->user_id);
            $this->session->set_userdata('user_type',2);
            $this->session->set_userdata('loginid', $data['user']->user_id);
            $this->session->set_userdata('email', $data['user']->email);
            $this->session->set_userdata('mobile', $data['user']->mobile);
             $this->session->set_userdata('name', $data['user']->name);
              $where = array('qms_users.user_id' => $this->session->userdata('user_id'), 'qms_users.is_active' => 1,'user_type'=>2);
            $data['user'] = $this->User_model->getdata($where);
            redirect(base_url('index.php/packages'));
        } else {
            $url = $_SERVER['HTTP_REFERER'];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please enter correct user id and password</div>");
            redirect($url);
        }
    }
public function admin_login() {

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');

        if ($this->form_validation->run() === FALSE) {
            $url = $_SERVER['HTTP_REFERER'];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please enter credentials to login</div>");
            redirect($url);
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');
       $q =$this->get_where('qms_users',['username'=>$username,'password'=>$password,'user_type'=>1]);
        if ($q->num_rows()>0) {
            $this->session->set_userdata('login', 'true');
              $this->session->set_userdata('admin_login', 'true');
            $this->session->set_userdata('user_id', $data['user']->user_id);
            $this->session->set_userdata('user_type',1);
            $this->session->set_userdata('loginid', $data['user']->user_id);
           
            redirect(base_url('dashboard'));
        } else {
            $url = $_SERVER['HTTP_REFERER'];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please enter correct user id and password</div>");
            redirect('admin');
        }
    }

    public function request_password() {
     if ($this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-warning'>You are logged in, Change password from profile.</div>");
            redirect(base_url('user-profile'));
        }

        if (!$this->input->server('REQUEST_METHOD') === 'POST') {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please try to request new password again later</div>");
           redirect(base_url());
        }
        if (empty($this->input->post('username')) ) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Fields can not be left blank</div>");
             redirect(base_url());
        }

        $value = $this->input->post('username');

        $field = (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value)) ? 'username' : 'email';

        $user = $this->Auth->getUser($value, $field);

        if (empty($user)) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please provide a registered username or email id</div>");
             redirect(base_url());
        }

        $password = $this->Auth->generatePassword();

        $this->User->updateUser(array("password" => md5($password),'pdf_encrypt'=>$password), array("user_id" => $user->user_id));

        $to_email = $user->email;
        $message = '<p>Dear User,</p><p>Your Username: <strong>'. $user->username .'</strong></p>';
        $message .= '<p>Your Password: <strong>'. $password .'</strong></p>';
       
        $message .= '<p>Regards</p>';
        $message .= '<p>PCBT Team</p>';

       $number=$user->mobile;
        $smsSend=false;
        $smsMessage='Dear User Your New PCBT login credentials are as follows.Username:-'.$user->username.' and Password :'.$password;
        if($number)
       {
           $resp=$this->Notification->sendSMS($number,$smsMessage);
           
           if ($resp['ErrorCode']=='000') {
            $smsSend=true;
           } 
         
      }
      $subject='New PCBT Login Credentials';
      $status = $this->Notification->sendEmail($to_email,$subject, $message);
      if ($status) {
        $smsmsg=($smsSend)?'  and mobile number':'';
            $this->session->set_flashdata('msg', "<div class='alert alert-success'>Your new login credentials sent to your registered email".$smsmsg."</div>");
        } else {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Unable to send the login credentials, please contact support team</div>");
        }
            
        redirect(base_url());
    }
public function logout()
    {
       // $this->facebook->destroy_session(); 
        $this->session->unset_userdata('user_login');
        $this->session->unset_userdata('login');
        redirect( base_url());
    }
     
   

}