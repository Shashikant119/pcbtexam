<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $is_admin_login = $this->session->userdata('admin_login');
        if (!$is_admin_login) {
            redirect('admin');
        }
        $this->load->helper('custome_helper');
        $this->load->model('User_model');
        $this->load->model('Quiz_model');
    }

    public function index()
    {
        $data = array();
        $data['stats'] = $this->User_model->get_dashboard_data();
        //echo "<pre>";print_r($data['stats']);die;
        $this->load->view('admin/dashboard', $data);
    }
 public function payment_history()
    {
        $data = array();
        $data['payments'] =$this->db->order_by('pay_id','DESC')->get('razor_pay')->result();
        $this->load->view('admin/payment_history', $data);
    }
  // pdf process
    public function downloadUserPackageMapping(){
        // $this->result['contest_list'] = $this->Mastermodel->getContestList();
        $this->data = array();
        $this->data['data'] = $this->User_model->getUserPackageMapping();
       
        $html = $this->load->view('admin/download-user-package-mapping', $this->data, true);
        $margin_top = 45;
        $margin_bottom = 20;
        $mpdf = new \Mpdf\Mpdf([ 'mode' => 'utf-8']);
        $mpdf->showWatermarkImage = true;
        $mpdf->SetFont('k010');
        $mpdf->WriteHTML($html);
        date_default_timezone_set('Asia/Kolkata');
        $file_name = 'user_assigned_packages'.date('Y-m-d').".pdf";
        $mpdf->Output($file_name,'D');
    }

    public function user_list()
    {
        $data = array();
        $users = $this->User_model->get_all_user();
        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($user->is_active == '1')
                    $data['active_users'][] = $user;
                else
                    $data['deactive_users'][] = $user;
            }
        }
        $this->load->view('admin/user_management', $data);
    }
    // pdf process
    public function user_listpdf()
    {
        $data = array();
        $users = $this->User_model->get_all_userpdf();
        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($user->is_active == '1')
                    $data['active_users'][] = $user;
                else
                    $data['deactive_users'][] = $user;
            }
        }

        $margin_top = 45;
        $margin_bottom = 20;
        $mpdf = new \Mpdf\Mpdf([ 'mode' => 'utf-8']);
        $html = $this->load->view('pdf/user_managementpdf', $data, true);
        $mpdf->showWatermarkImage = true;
        $mpdf->SetFont('k010');
        $mpdf->WriteHTML($html);
        date_default_timezone_set('Asia/Kolkata');
        $file_name = 'active_users'.date('Y-m-d').".pdf";
        $mpdf->Output($file_name,'D');
    }

    // print process
    public function user_listprint()
    {
        $data = array();
        $users = $this->User_model->get_all_userprint();
        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($user->is_active == '1')
                    $data['active_users'][] = $user;
                else
                    $data['deactive_users'][] = $user;
            }
        }
        $this->load->view('pdf/user_managementpdf', $data);
    }

    public function add_update_user()
    {
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //if edit
            $edit_id = intval($this->input->post('req_id'));

            //setting validation rule
            $this->form_validation->set_rules('user_name', 'Name', 'required');
            $this->form_validation->set_rules('emailid', 'Email', 'required');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required');
            $this->form_validation->set_rules('dob', 'dob', 'required');
            $this->form_validation->set_rules('address', 'address', 'required');
            //  $this->form_validation->set_rules('startdate', 'startdate', 'required');
            //  $this->form_validation->set_rules('enddate', 'enddate', 'required');
            //  $this->form_validation->set_rules('quiz_packages', 'quiz_packages', 'required');

            /*
            if ($edit_id == 0) {
                $this->form_validation->set_rules('password', 'Password', 'required');
            }
            */
            if ($this->form_validation->run() !== FALSE) {

                $dob = date('Y-m-d', strtotime($this->input->post('dob')));

                $password = md5(date('dmY', strtotime($dob)));
                $data = array('username' => $this->input->post('emailid'),
                    'password' => $password,
                    'user_type' => 2,
                    'name' => $this->input->post('user_name'),
                    'email' => $this->input->post('emailid'),
                    'mobile' => $this->input->post('mobile'),
                    'dob' => $dob,
                    'address' => $this->input->post('address')
                );

                if ($edit_id > 0) {
                    $dob = date('Y-m-d', strtotime($this->input->post('dob')));
                    if ($this->input->post('password')) {
                        $data = array(
                            'user_type' => 2,
                            'name' => $this->input->post('user_name'),
                            'email' => $this->input->post('emailid'),
                            'mobile' => $this->input->post('mobile'),
                            'dob' => $dob,
                            'password' => md5($this->input->post('password')),
                            'address' => $this->input->post('address')
                        );
                    } else {
                        $data = array(
                            'user_type' => 2,
                            'name' => $this->input->post('user_name'),
                            'email' => $this->input->post('emailid'),
                            'mobile' => $this->input->post('mobile'),
                            'dob' => $dob,
                            'address' => $this->input->post('address')
                        );
                    }


                    date_default_timezone_set('Asia/Kolkata');
                    $currentTime = date('d-m-Y h:i:s A', time());
                    $arrayName = array('user_id' => $edit_id,);
                    $package = $this->input->post('quiz_packages');
                    $startdate = $this->input->post('startdate');
                    $enddate = $this->input->post('enddate');
                    $this->User_model->delete_useruserpackage('user_package', $arrayName);
                    $i = 0;
                    foreach ($package as $pack) {

                        $data2 = array(
                            'user' => $edit_id,
                            'Packages' => $pack,
                            'package_start' => $startdate[$i],
                            'end_enddate' => $enddate[$i],
                            'status' => 1,
                            'enterydate' => $currentTime,
                        );
                        $i++;
                        $packageid = $this->User_model->add_user_package($data2);
                        //   echo  $this->db->last_query();
                    }
                    /*
                    $password = $this->input->post('password');
                    if(!empty($password)) {
                        $data_ar['password'] = md5($password);
                    }
                    */

                    $where_ar = array('user_id' => $edit_id);
                    $this->User_model->update_user($where_ar, $data);
                    //$this->db->last_query();
                    //  die;
                    $this->session->set_flashdata('msg', 'User updated successfully.');
                } else {
                    //$data_ar['password'] = md5($this->input->post('password'));
                    //$this->User_model->add_user($data);

                    $user_id = $this->User_model->add_user($data);
                    $package = $this->input->post('quiz_packages');

                    date_default_timezone_set('Asia/Kolkata');
                    $currentTime = date('d-m-Y h:i:s A', time());
                    $startdate = $this->input->post('startdate');
                    $enddate = $this->input->post('enddate');
                    $i = 0;
                    foreach ($package as $pack) {

                        $data2 = array(
                            'user' => $user_id,
                            'Packages' => $pack,
                            'package_start' => $startdate[$i],
                            'end_enddate' => $enddate[$i],
                            'status' => 1,
                            'enterydate' => $currentTime,
                        );
                        $i++;
                        $packageid = $this->User_model->add_user_package($data2);
                    }

                    if ($user_id) {
                        $username = 'PCBT' . str_pad($user_id, 5, "0", STR_PAD_LEFT);
                        $this->User_model->update_user(array('user_id' => $user_id), array('username' => $username));
                        //redirect('/User/registrationSuccess?msg='.$username, 'refresh');
                        $this->session->set_flashdata('msg', 'User added successfully.');
                    }
                }
            }
            redirect('user-management/');
        }

        $get_id = intval($this->uri->segment(2));
        if ($get_id > 0) {
            $data['edit_data'] = $this->User_model->get_user($get_id)[0];
        }
        $data['packages'] = $this->Quiz_model->get_all_package();
        $data['selectpack'] = $this->Quiz_model->get_allselected_package($get_id);
        $this->load->view('admin/add_update_user', $data);
    }

    public function status_user()
    {
        $user_id = intval($this->uri->segment(2));
        // $status = intval($this->uri->segment(3));
        $this->User_model->delete_user($user_id);
        $this->session->set_flashdata('msg', 'User Delete successfully.');
        redirect('user-management/');
    }

    public function packagedetails($id)
    {
        $arrayName = array('userpackage.user' => $id);
        $data['packuser'] = $this->User_model->selectdatajoin('userpackage', '*', $arrayName);
        $this->session->set_flashdata('msg', "User package list");
        $this->load->view('admin/packagedetails', $data);
    }

    public function updateEndDate()
    {
      
              $userid=$this->input->post('user');
               $packid=$this->input->post('pack');
              $endDate=$this->input->post('end');
              $end=date("Y-m-d",strtotime($endDate));
              $this->db->where(['user_id'=>$userid,'package_id'=>$packid])->update('user_package',['package_end'=>$end]);
              echo 'done';
        
    }
    public function appreciation_list()
    {
      $data['appreciations']=$this->db->get('user_feedback')->result();
      $this->load->view('admin/feedback_list',$data);
        
    }
public function edit_feedback($id)
    {
      $data['appreciation']=$this->db->get_where('user_feedback',['id'=>$id])->row();
      $this->load->view('admin/edit_feedback',$data);
        
    }
public function update_feedback()
    {
        $id=$this->input->post('id');
        $words=$this->input->post('feedback');
        $star=$this->input->post('rating');
          $state=$this->input->post('state');
          $data=[
               'feedback'=>$words,
               'rating'=>$star,
               'state'=>$state

          ];
        $this->db->where(['id'=>$id])->update('user_feedback',$data);
         $this->session->set_flashdata('msg', 'Record updated successfully.');
        redirect('admin-appreciation');
        
    }
    public function delete_feedback($id)
    {
      
           $this->db->where('id',$id)->delete('user_feedback');
            $this->session->set_flashdata('msg', 'Record deleted successfully.');
          redirect('admin-appreciation');
    }


    public function existEmailCheck()
    {
        $email = $this->input->post('email');
        $skip = intval($this->input->post('skip'));
        $res = $this->User_model->exist_user_email($email, $skip);
        if (count($res) > 0) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    public function change_admin_password()
    {
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $password = $this->input->post('password');
            $password1 = $this->input->post('password1');
            if ($password == $password1) {
                $user_id = intval($this->session->userdata('user_id'));
                $password1 = md5($password1);
                $this->User_model->update_user(array('user_id' => $user_id), array('password' => $password1));
                $this->session->set_flashdata('msg', 'Password changed successfully.');
            }
        }
        $this->load->view('admin/change_password', $data);
    }
  public function clear_cache()
    {
        $q=$this->db->query("SELECT `id` FROM qms_user_test WHERE `submitted`=1 AND `result_prepared`=1 AND EXISTS (SELECT * FROM qms_ongoing_test WHERE qms_user_test.`id` = qms_ongoing_test.`user_test_id`)")->result();
        if(!empty($q))
        {
            foreach($q as $r)
            {
                $this->db->where('user_test_id',$r->id)->delete('qms_ongoing_test');
            }
         }
         //echo $this->db->last_query();die;
        $this->load->view('admin/dashboard', $data);
    }
}
