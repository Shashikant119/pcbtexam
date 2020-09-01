<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 21/12/19
 * Time: 9:52 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class PackageController extends CI_Controller
{
    function __construct() {
        parent::__construct();

        $this->load->model('Package');
        $this->load->model('Quiz');
        $this->load->model('User_model');
        $this->load->helper(array('form', 'url','custome_helper'));
        $this->load->model('User');
    }

    public function index() {
        if (!$this->session->userdata('login')) {
            $url = $_SERVER['HTTP_REFERER'];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue! </div>");
            redirect($url);
        }

        $view = $this->input->get('view', true) == "table" ? "table" : "grid";

        $where = array('user_id' => $this->session->userdata('user_id'));
        $data['user'] = $this->User_model->getLoginUserData($where);
        $data['packages'] = $this->Package->getAllPackages(0);
       
        $this->load->view('common/header', $data);
            if ($view == "table") {
                $this->load->view('package/package-table');
            } else {
                $this->load->view('package/package-grid');
            }
             $this->load->view('common/user_footer');
        

    }

    public function admin_pack() {
        if (!$this->session->userdata('admin_login')) {
            $url = $_SERVER['HTTP_REFERER'];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue! </div>");
            redirect(base_url());
        }

        $view = $this->input->get('view', true) == "table" ? "table" : "grid";

       
        $data['packages'] = $this->Package->getAllPackages(0);
        $is_admin =$this->session->userdata('admin_login');
     // admin access
            $this->load->view('admin/package_management', $data);
        
    }
    public function my_packages() {
        if (!$this->session->userdata('login')) {
            $url = $_SERVER['HTTP_REFERER'];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue! </div>");
            redirect($url);
        }

        $user_type = intval($this->session->userdata('user_type'));

        if ($user_type == 1) {
            redirect(base_url() . "admin/");
        }

        $view = $this->input->get('view', true) == "table" ? "table" : "grid";

        $where = array('user_id' => $this->session->userdata('user_id'));
        $data['user'] = $this->User_model->getLoginUserData($where);
        $data['packages'] = $this->Package->getAllPackages($data['user']->user_id);
      // echo "<pre>";print_r($data['packages']);die;
        $this->load->view('common/header', $data);
        if ($view == "table") {
            $this->load->view('package/my-package-table');
        } else {
            $this->load->view('package/my-package-grid',$data);
        }
         $this->load->view('common/user_footer', $data);
    }

    public function add() {

        if (!$this->session->userdata('admin_login')) {
            $url = $_SERVER['HTTP_REFERER'];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue! </div>");
            redirect(base_url('admin'));
        }

        // only admin access
        /*$user_type = intval($this->session->userdata('user_type'));
        if ($user_type != 1) {
            redirect('error_404');
        }*/

        if (!$this->input->server('REQUEST_METHOD') === 'POST') {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Something went wrong, please try again later</div>");
        }

        // setting validation rule
        $this->form_validation->set_rules('package_name', 'Packages Name', 'required');

        // run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/all-packages');
        }


        $input = array ( 'package_name' => $this->input->post('package_name'),
            'package_type' => $this->input->post('package_type'),
            'package_price' => $this->input->post('package_price'),
            'package_duration' => $this->input->post('package_duration'),
            'total_cbt_test' => $this->input->post('total_cbt_test'),
            'mcq_in_cbt' => $this->input->post('mcq_in_cbt'),
            'frequency_of_cbt' => $this->input->post('frequency_of_cbt'),
        );

         $input["image"]='';
          if($_FILES['package_image']['name']){
               
                $f=$_FILES['package_image']['name'];
                $file_name=$this->do_upload_field($f,'package_image','./assets/images/packages');
                $input["image"]=$file_name;
            }
       
        $result = $this->Package->addPackage($input);
      //  echo $this->db->last_query();die;
        if ($result) {
            $this->session->set_flashdata('msg', 'Packages added successfully.');
        } else {
            $this->session->set_flashdata('msg', 'Unable to add package, try again later');
        }

        redirect('admin_package');
    }

    public function package_quiz($package_id) {
       
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please login to start test </div>");
            redirect(base_url());
        }

        $user_type = intval($this->session->userdata('user_type'));
        $user_id = $this->session->userdata('user_id');
        if ($user_type == 1) {
            redirect(base_url() . "admin/");
        }

        $view = $this->input->get('view', true) == "table" ? "table" : "grid";

        $where = array('qms_users.user_id' => $user_id, 'qms_users.is_active' => 1);
        $data['user'] = $this->User_model->getLoginUserData($where);
        $is_pack_free=isPackFree($package_id);
        $data['quiz_list'] = $this->Quiz->getPackageQuiz($package_id, $user_id,$is_pack_free);
        $data['package_id'] = $package_id;
       // echo "<pre>";print_r( $data['quiz_list']);die;
        $this->load->view('common/header', $data);
        if ($view == "grid") {
            $this->load->view('quiz/quiz-grid');
        } else {
            $this->load->view('quiz/quiz-table');
        }
         $this->load->view('common/user_footer', $data);
    }
  
  public function do_upload_field($file,$field,$path=''){
        $new_name=time().$file;
        $config = array(
        'upload_path' =>$path,
        'allowed_types' => "gif|jpg|png|jpeg|pdf",
        'overwrite' => TRUE,
        'max_size' => "2048000",
        'file_name'=>$new_name
         );
    
    
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