<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 28/12/19
 * Time: 11:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/autoload.php';
class UserController extends CI_Controller
{
  function __construct() {
    parent::__construct();
       /* $user_type =$this->session->userdata('login');
        if (!$user_type) {
            redirect(base_url());
          }*/

          $this->load->model('User_model');
          $this->load->model(['User','Notification']);
          $this->load->helper('url');
          $this->load->model('Auth');
          $this->load->library('google');
          $this->load->library('facebook'); 
          $this->initialize_google_client();
          //$this->load->model('oAuth'); /****For checking if uer exist for oAth***/
        }
        public function initialize_google_client()
        {


          $this->google_client = new Google_Client();

            //Set the OAuth 2.0 Client ID
          $this->google_client->setClientId('1030069090761-ga4cj6sab1hv9qvtiu8odo6a1teoj190.apps.googleusercontent.com');

            //Set the OAuth 2.0 Client Secret key
          $this->google_client->setClientSecret('1xfZiwH_cUB0eHu_12iLmQ11');

            //Set the OAuth 2.0 Redirect URI
          $this->google_client->setRedirectUri('https://pcbtexamportal.com/google_register');

            //
          $this->google_client->addScope('email');

          $this->google_client->addScope('profile');
          $this->google_client->addScope('https://www.googleapis.com/auth/user.birthday.read');
          $this->google_client->addScope('https://www.googleapis.com/auth/user.addresses.read');

          $this->google_client->addScope('https://www.googleapis.com/auth/user.phonenumbers.read');


        }
        public function user_profile() {
          if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue!!! </div>");
            redirect(base_url());
          }

          $where = array('user_id' => $this->session->userdata('user_id'));
          $data['user'] = $this->User_model->getLoginUserData($where);
          $this->load->view('common/header', $data);
          $this->load->view('user/profile');
          $this->load->view('common/user_footer');
        }

        public function edit_profile() {
          if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue!!! </div>");
            redirect(base_url());
          }
          $where = array('user_id' => $this->session->userdata('user_id'));
          $data['user'] = $this->User_model->getLoginUserData($where);
          $this->load->view('common/header', $data);
          $this->load->view('user/edit-profile');
          $this->load->view('common/user_footer');
        }

        public function update_profile() {

          if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue!!! </div>");
            redirect(base_url());
          }
          $user_data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'address' => $this->input->post('address'),
            'dob' => date("Y-m-d",strtotime($this->input->post('dob'))),
          );
          $user_data ['profile_pic']='';
         //echo "<pre>";print_r($_FILES);die;
          if($_FILES['profile_pic']['name'])
          {
            $f_name=$_FILES['profile_pic']['name'];
            $file_name=$this->do_upload_field($f_name,'profile_pic');
            $user_data ['profile_pic']=$file_name;
          }


          $where = array('user_id' => $this->session->userdata('user_id'));
          $this->User->updateUser($user_data, $where);
        //echo $this->db->last_query();die;
          redirect('user-profile');
        }

        public function change_password() {
          if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue</div>");
            redirect(base_url());
          }

          $where = array('user_id' => $this->session->userdata('user_id'));
          $data['user'] = $this->User_model->getLoginUserData($where);
          $this->load->view('common/header', $data);
          $this->load->view('user/change-password');
          $this->load->view('common/user_footer');
        }

        public function update_password() {

          if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue</div>");
            redirect(base_url());
          }

          if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            $url = $_SERVER["HTTP_REFERER"];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Something went wrong, please try again later</div>");
            redirect($url);
          }

          $password = $this->input->post('password');
          $confirm_password = $this->input->post('confirm_password');

          if ($password != $confirm_password) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>New Password and confirm new password should be the same</div>");
            redirect('update-password');
          }

          $user_id = intval($this->session->userdata('user_id'));
          $original_pwd=$password;
          $password = md5($password);
          $this->User->updateUser(array("password" => $password,'pdf_encrypt'=>$original_pwd), array('user_id' => $user_id));
          $this->session->set_flashdata('msg', "<div class='alert alert-success'>Password changed successfully</div>");
          redirect('user-profile');
        }

        public function create_user() {



       /* if ($this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please logout first to create new account</div>");
            redirect('user-profile');
        }
*/
        //$data['google_login_url'] = $this->google->get_login_url();
        $this->load->view('user/register', $data);
      }

      public function register($loginVia='') {

        if ($this->session->userdata('login')) {
          $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please logout first to create new account</div>");
          redirect('user-profile');
        }

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
          $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Something went wrong, please try again later</div>");
          redirect('create-account');
        }
        if(!$loginVia)
        {

         $this-> normal_register();
       }
       elseif($loginVia=='fb')
       {

         redirect('index.php/fb_register');
       }
       else
       {
         redirect('index.php/google_register');
       }

       
     }
     public function normal_register() {
       $this->form_validation->set_rules('user_role', 'User role', 'required');
       $this->form_validation->set_rules('name', 'Name', 'required');
       $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
       $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
       $this->form_validation->set_rules('mobile', 'Mobile', 'required');
       $this->form_validation->set_rules('address', 'Address', 'required');

        // run form validation
       if ($this->form_validation->run() === FALSE) {

        $this->load->view('user/register');
        exit;
      }

      $name = $this->input->post('name');
      $email = $this->input->post('email');
      $user_role = $this->input->post('user_role');
      $dob = date('Y-m-d', strtotime($this->input->post('dob')));
      $mobile = $this->input->post('mobile');
      $address = trim($this->input->post('address'));
      $auth_provider=$this->input->post('auth_provider');
      $auth_uid=$this->input->post('auth_uid');
      
      // if ($this->Auth->isEmailExists($email)) {

      //   $this->session->set_flashdata('msg', "<div class='alert alert-danger'>This email already exists, please provide different email</div>");
      //   $this->load->view('user/register');
      // } 
      //else {
     // $password  = $this->Auth->generatePassword();
      $password = mt_rand(1000,9999);
      $data["password"] = $password;

      $registration_data = array('username' => $name,
        'password' => md5($password),
        'pdf_encrypt' => $password,
        'user_type' => $user_role,
        'role' => $user_role,
        'name' => $name,
        'email' => $email,
        'mobile' => $mobile,
        'dob' => $dob,
        'address' => $address
      );

      $user_id = $this->Auth->registerUser($registration_data);

      if($user_id) {
        $username = 'INNO' . str_pad($user_id, 5, "0", STR_PAD_LEFT);
        $this->User->updateUser(array('username' => $username), array('user_id' => $user_id));
        $data["username"] = $username;
        $to_email = $email;
        $message = '<p>Dear User,</p><p>Your Username: <strong>'. $username .'</strong></p>';
        $message .= '<p>Your Password: <strong>'. $password .'</strong></p>';

        $message .= '<p>Regards</p>';
        $message .= '<p>InnoKnova Team</p>';

        $number=$mobile;
        $smsSend=true;
        $smsMessage='Dear User Your InnoKnova login credentials are as follows.Username:-'.$username.' and Password :'.$password;
      //   if($number){
      //    $resp=$this->Notification->sendSMS($number,$smsMessage);

      //    if ($resp['ErrorCode']=='000') {
      //     $smsSend=true;
      //     } 

      // }
        $subject='InnoKnova Registration';
        $status = $this->Notification->sendEmail($to_email,$subject, $message);
        if ($status) {
          $smsmsg=($smsSend)?'  and mobile number':'';
          $this->session->set_flashdata('msg', "<div class='alert alert-success'>Your login credetials sent to your registered email".$smsmsg."</div>");
        } else {
          $this->session->set_flashdata('msg', "<div class='alert alert-danger'>You are registered , but unable to mail the login details at the moment</div>");
        }

        $this->session->set_flashdata('msg', "");
        $this->load->view('user/registration-success', $data);
      } else {
        $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Unable to register right now, please try again later</div>");
        redirect('index.php/create-account');
      }
    //}
    }
    public function social_reg($data) {

      $name = $data['name'];
      $email =$data['email'];
      $auth_provider=$data['auth_provider'];
      $auth_uid=$data['auth_uid'];

      if ($this->Auth->isEmailExists($email)) {
        $this->session->unset_userdata('fb_access_token');
        $this->session->set_flashdata('msg', "<div class='alert alert-danger '>Sorry,this email already exists</div>");
        redirect('create-account');
      } else 
      {
        $password = $this->Auth->generatePassword();
        $data["password"] = $password;

        $registration_data = array('username' => $email,
          'password' => md5($password),
          'pdf_encrypt' => $password,
          'user_type' => 2,
          'name' => $name,
          'email' => $email,
          'mobile' =>isset($data['phone'])?$data['phone']:'',
          'dob' =>isset($data['dob'])?$data['dob']:'',
          'address' =>isset($data['address'])?$data['address']:'',
          'oath_provider'=>$auth_provider,
          'oath_uid'=>$auth_uid
        );
        //echo "<pre>";print_r($registration_data);die;
        $user_id = $this->Auth->registerUser($registration_data);
           // echo $this->db->last_query();die;
          //echo $user_id;die;
        if($user_id) {
          $username = 'PCBT' . str_pad($user_id, 5, "0", STR_PAD_LEFT);
          $this->User->updateUser(array('username' => $username), array('user_id' => $user_id));
          $data["username"] = $username;
          $to_email = $email;
          $message = '<p>Dear User,</p><p>Your Username: <strong>'. $username .'</strong></p>';
          $message .= '<p>Your Password: <strong>'. $password .'</strong></p>';

          $message .= '<p>Regards</p>';
          $message .= '<p>PCBT Team</p>';


          $smsSend=false;

          $subject='PCBT Registration';
          $status = $this->Notification->sendEmail($to_email,$subject, $message);
          if ($status) {
            $smsmsg=($smsSend)?'  and mobile number':'';
            $this->session->set_flashdata('msg', "<div class='alert alert-success'>Your login credetials sent to your registered email".$smsmsg."</div>");
          } else {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>You are registered , but unable to mail the login details at the moment</div>");
          }

          $this->session->set_flashdata('msg', "");
          $this->load->view('user/registration-success', $data);
        } else {
          $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Unable to register right now, please try again later</div>");
          redirect('create-account');
        }
      }
    }
    public function registerViaFb() {   
      $this->user=$this->oAuth;
      $userData = array(); 

        // Authenticate user with facebook 
      if($this->facebook->is_authenticated())
      { 
        $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,address,birthday,name'); 
        if($fbUser){
          $userData['auth_provider'] = 'Facebook'; 
          $userData['auth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';;
          $userData['email']    = !empty($fbUser['email'])?$fbUser['email']:'';;
          $userData['name']    = !empty($fbUser['name'])?$fbUser['name']:'';; 

          $this->social_reg($userData); 
        }
        else
        {
          $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Error in registering via Facebook</div>");
          redirect('index.php/create-account');
        }
      }
      else{ 

        $data['authURL'] =  $this->facebook->login_url();
          // echo $data['authURL'];die;
        redirect($data['authURL']); 
      } 

    } 
    public function registerViaGoogle() 
    {
      //echo $_GET["code"];die;
      if(isset($_GET["code"]))
      {  

        $token = $this->google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

        if(!isset($token['error']))
        {
          $this->user=$this->oAuth;
          $this->google_client->setAccessToken($token['access_token']);
          $_SESSION['access_token'] = $token['access_token'];

          $handle = curl_init();
          $msg= curl_escape($handle, $msg);
          $url = "https://people.googleapis.com/v1/people/me";
          $url.="?personFields=birthdays,phoneNumbers,addresses&access_token=".$_SESSION['access_token'];


          curl_setopt($handle, CURLOPT_URL, $url);
          // Set the result output to be a string.
          curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

          $output = curl_exec($handle);

          if (curl_errno($handle)) {
            $error_msg = curl_error($handle);
          }
          curl_close($handle);

          $resp= json_decode($output,true);

          $year= isset($resp['birthdays'][0]['date']['year'])?$resp['birthdays'][0]['date']['year']:'';

          $mon= $resp['birthdays'][0]['date']['month'];
          $day= $resp['birthdays'][0]['date']['day'];

          $birtday='';$phone='';$address='';
          if($year)
           $birtday=$day."-". $mon."-".$year;
       //echo $birtday;die;
         $phone= isset($resp['phoneNumbers'][0]['value'])?$resp['phoneNumbers'][0]['value']:'';
         $address= isset($resp['addresses'][0]['city'])?$resp['addresses'][0]['city']:'';
         $google_service = new Google_Service_Oauth2($this->google_client);
         $data = $google_service->userinfo->get();

         $userData['auth_provider'] = 'Google'; 
         $userData['auth_uid']    = !empty($data['id'])?$data['id']:'';;
         $userData['email']    = !empty($data['email'])?$data['email']:'';;
         $userData['name']    = !empty($data['name'])?$data['name']:'';
         $userData['dob']=$birtday;
         $userData['address']=$address;
         $userData['phone']=$phone;
         $this->social_reg($userData); 
       }
       else
       {
         $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Error in registering via Google</div>");
         redirect('index.php/create-account');
       }
     }

     else
       redirect($this->google_client->createAuthUrl());
   }
   public function fb_logout() { 

    $this->facebook->destroy_session(); 
        // Remove user data from session 
    $this->session->unset_userdata('userData'); 
    $this->session->unset_userdata('fb_access_token');
    $this->session->sess_destroy();  
    redirect(base_url()); 
  }
  public function google_logout()
  {

    $this->google_client->revokeToken();


    session_destroy();

    //redirect page to index.php
    redirect(base_url());

  }

  function feedback()
  {

   $userid=$this->session->userdata('loginid');
   if($userid)
   {   
      //echo "<pre>";print_r($_POST);die;
    date_default_timezone_set('Asia/Kolkata');
    $this->form_validation->set_rules('feedback', 'Feedback', 'required');
    $this->form_validation->set_rules('state', 'State', 'required');
    if ($this->form_validation->run()) {

      if($_FILES['profile_pic']['name'])
      {
        $f_name=$_FILES['profile_pic']['name'];
        $file_name=$this->do_upload_field($f_name,'profile_pic');
        $this->db->where('user_id',$userid)
        ->update('qms_users',['profile_pic'=>$file_name]);
      }
      $post=$this->input->post();
      $post['user_id']=$userid;
      $post['date']=date("Y-m-d");
      if(!$post['id'])
       $this->db->insert('user_feedback',$post);
     else{
      $this->db->where('id',$post['id'])
      ->update('user_feedback',$post);

    }
                   // echo $this->db->last_query();die; 
    $this->session->set_flashdata('msg','!! Thanks for providing your valuable feedback !!');
    redirect('index.php/appreciation-list');
  }
  else {
          //echo validation_errors();die;
    $where = array('user_id' => $this->session->userdata('user_id'));
    $data['user'] = $this->User_model->getLoginUserData($where);
    $this->load->view('common/header', $data);
    $this->load->view('user/feedback');
    $this->load->view('common/user_footer');
  }
}
else
  redirect(base_url());
}

public function edit_feedback()
{
  $id=$this->input->post('id');
  //echo $id;
  $data['f']=$this->db->get_where('user_feedback',['id'=>$id])->row();
  //echo $this->db->last_query();die;
  //echo "<pre>";print_r( $data['f']);die;
  $this->load->view('common/header', $data);
  $this->load->view('user/edit-feedback');
  $this->load->view('common/user_footer');
}
public function delete_feedback()
{
  $id=$this->input->post('id');
  $this->db->where('id',$id)->delete('user_feedback');
  $this->session->set_flashdata('msg','!!Successfully deleted!!');
  redirect('index.php/feedback-list');
}
public function payment()
{
  $uid=$this->session->userdata('user_id');
  
  $data['payments']=$this->db->select('*')
  ->from('razor_pay')
  ->where('user_id',$uid)
  ->get()->result();
             //  echo "<pre>";print_r($data['payments']);die;
  $where = array('user_id' => $this->session->userdata('user_id'));
  $data['user'] = $this->User_model->getLoginUserData($where);

  $this->load->view('common/header', $data);
  $this->load->view('user/payment');
  $this->load->view('common/user_footer');
}
public function feedback_list()
{
  $uid=$this->session->userdata('user_id');
  
  $data['ap']=$this->db->select('*')
  ->from('user_feedback')

  ->where('user_feedback.user_id',$uid)
  ->get()->result();
  $where = array('user_id' => $this->session->userdata('user_id'));
  $data['user'] = $this->User_model->getLoginUserData($where);

  $this->load->view('common/header', $data);
  $this->load->view('user/appreciation_list');
  $this->load->view('common/user_footer');
}
public function do_upload_field($file,$field,$path=''){
 $new_name=time().$file;
        //$config['file_name'] = $new_name;
 if($path==''){
  $config = array(
    'upload_path' => "./uploads/",
    'allowed_types' => "gif|jpg|png|jpeg|pdf",
    'overwrite' => TRUE,
    'max_size' => "2048000",
    'file_name'=>$new_name
  );
}
else{
  $config = array(
    'upload_path' => "./uploads/".$path,
    'allowed_types' => "gif|jpg|png|jpeg|pdf",
    'overwrite' => TRUE,
    'max_size' => "2048000",
    'file_name'=>$new_name
  );
}
$this->load->library('upload',$config);
$this->upload->initialize($config);
if($this->upload->do_upload($field))
{
  $upload_data = $this->upload->data(); 
  $file_name = $upload_data['file_name'];
  return $file_name;
}
else
{
  $error = array('error' => $this->upload->display_errors());
  return '';
}
} 
}