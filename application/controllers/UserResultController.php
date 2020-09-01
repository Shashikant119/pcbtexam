<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 19/12/19
 * Time: 9:27 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class UserResultController extends CI_Controller
{
    function __construct() {
        parent::__construct();

       /* if (!$this->session->userdata('login')) {
            redirect( base_url() );
        }
*/
        $this->load->model('Result');
        $this->load->model('Quiz');
        $this->load->model('QuestionBank');
        $this->load->model('User_model');
        $this->load->helper('url');
    }

    public function index() {
        $user_id = intval($this->session->userdata('user_id'));

        if (!$user_id) {
            $this->session->set_flashdata('msg', 'Please login first');
            redirect( base_url());
        }

        $data = array();
        $data["results"] = $this->Result->getUserResult($user_id);
        $where = array('user_id' => $this->session->userdata('user_id'));
        $data['user'] = $this->User_model->getLoginUserData($where);
        $this->load->view('common/header', $data);
        $this->load->view('result/index');
         $this->load->view('common/user_footer');
    
    }

    
    public function answer_sheet($result_id) {

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', 'Please login first');
            redirect( base_url());
        }

        $data = array();
        $user_id = $this->session->userdata('user_id');

        $where = array('user_id' => $user_id);
        $data['user'] = $this->User_model->getLoginUserData($where);

        $data["answer_sheet"] = $this->Result->getAnswerSheet($result_id);

        /*echo "<pre>";
        print_r($data["answer_sheet"]);
        die;*/
       $data['resultid']=$result_id;
        $data["result"] = $this->Result->getResult($result_id);

        if ($this->session->userdata("user_type") == 2) {
            $this->load->view('common/header', $data);
            $this->load->view('result/answer-sheet');
              $this->load->view('common/user_footer');
    
        } else {
            $this->load->view('admin/result/show', $data);
        }
    }

        public function practicepaper(){
           $this->load->view('result/practice_paper');
        }
    public function detailed_answer_sheet($result_id) {

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', 'Please login first');
            redirect( base_url());
        }

        $data = array();
        $user_id = $this->session->userdata('user_id');

        $where = array('user_id' => $user_id);
        $data['user'] = $this->User_model->getLoginUserData($where);

        $data["answer_sheet"] = $this->Result->getAnswerSheet($result_id);

        /*echo "<pre>";
        print_r($data["answer_sheet"]);
        die;*/

        $data["result"] = $this->Result->getResult($result_id);

        if ($this->session->userdata("user_type") == 2) {
            $this->load->view('common/header', $data);
            $this->load->view('result/detailed_answer_sheet');
              $this->load->view('common/user_footer');
    
        } else {
            $this->load->view('admin/result/show', $data);
        }
    }
 public function admin_answer_sheet($result_id) {

     // echo $result_id;die;
        $data = array();
       
        $data["answer_sheet"] = $this->Result->getAnswerSheet($result_id);
        $data['resultid']=$result_id;
  
        $data["result"] = $this->Result->getResult($result_id);
//echo $this->db->last_query();die;
            $this->load->view('admin/result/show', $data);
        
    }
    public function download_certificate($result_id) {
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', 'Please login first');
            redirect( base_url());
        }

        $data = array();
        $user_id = $this->session->userdata('user_id');

        $where = array('user_id' => $user_id);
        $data['user'] = $this->User_model->getLoginUserData($where);
      //echo "<pre>";print_r($data['user']);die;
        $data["answer_sheet"] = $this->Result->getAnswerSheet($result_id);

        $data["result"] = $this->Result->getResult($result_id);

        if (empty($data["answer_sheet"]) || empty($data["result"])) {
            $this->session->set_flashdata('msg', 'Could not complete your request to download certificate, please try again');
            redirect(base_url());
        }

        if (!$data["result"]->pdf_paper_link) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>You are not allowed to download the certificate</div>");
            redirect(base_url("my-progress/view/".$result_id));
        }
       
   //  $this->load->view('result/pdf-certificate', $data);die;

        $margin_top = 45;
        $margin_bottom = 20;
        $mpdf = new \Mpdf\Mpdf([ 'mode' => 'utf-8','margin_top' => $margin_top, 'margin_bottom' => $margin_bottom]);
       // $mpdf->showImageErrors = true;
        $html = $this->load->view('result/pdf-certificate', $data, true);
        $mpdf->SetWatermarkImage(base_url().'/assets/web/images/logo-new.jpg','.2',['150','200'],'P');
        $mpdf->showWatermarkImage = true;
         $mpdf->SetFont('k010');
        $mpdf->SetCompression(true);
        $mpdf->SetProtection(array(),$data['user']->pdf_encrypt);
        $mpdf->WriteHTML($html);
        date_default_timezone_set('Asia/Kolkata');
        $file_name = date('d-M-Y'). "_" .date('H:i:s').".pdf";
        //$mpdf->Output();
        $mpdf->Output($file_name,'D');
    }

    public function common_merit_list($quiz_id) {
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', 'Please login first');
            redirect( base_url());
        }

        $quiz = $this->Quiz->getQuizById($quiz_id);

        if (!$quiz->common_merit_link) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>The merit list selected result is not available right now, try again later.</div>");
            redirect(base_url('my-progress'));
        }

        $user_id = $this->session->userdata('user_id');
        $where = array('user_id' => $user_id);
        $data['user'] = $this->User_model->getLoginUserData($where);

        $data["results"] = $this->Result->getMeritList($quiz_id);
        if ($this->session->userdata("user_type") == 2) {
            $this->load->view('common/header', $data);
            $this->load->view('result/common-merit-list');
        } else {
            $this->load->view('admin/result/merit-list', $data);
        }
    }

}