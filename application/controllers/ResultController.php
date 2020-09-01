<?php

/**

 * Created by PhpStorm.

 * User: amitpandey

 * Date: 17/12/19

 * Time: 11:14 PM

 */



defined('BASEPATH') OR exit('No direct script access allowed');



class ResultController extends CI_Controller

{

    function __construct() {

        parent::__construct();

         $user_type = intval($this->session->userdata('admin_login'));



        if (!$user_type ) {

            redirect( base_url() . 'admin/' );

        }





        $this->load->model('Result');

        $this->load->model('Quiz');

        $this->load->model('QuestionBank');

    }



    public function index() {

        $data = array();

        $data['results'] = $this->Result->getAllResults();

        $data['quizes'] = $this->Quiz->getAllQuizes();

        $this->load->view('admin/result/index', $data);

    }


    // pdf process
    public function resultspdf()
    {
        $data = array();
        $data['results'] = $this->Result->getAllResult();
        $data['quizes'] = $this->Quiz->getAllQuizes();
         
        $html = $this->load->view('pdf/resultmpdf', $data, true);

        $margin_top = 45;
        $margin_bottom = 20;
        $mpdf = new \Mpdf\Mpdf([ 'mode' => 'utf-8']);
       
        $mpdf->showWatermarkImage = true;
        $mpdf->SetFont('k010');
        $mpdf->WriteHTML($html);
        date_default_timezone_set('Asia/Kolkata');
        $file_name = 'results'.date('Y-m-d').".pdf";
        $mpdf->Output($file_name,'D');
    }



    public function generate_report() {

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {

            redirect('report');

        }



        //setting validation rule

        $this->form_validation->set_rules('quiz_id', 'Quiz Name', 'required');



        // run form validation

        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('msg', 'Please select a valid quiz');

            redirect('report');

        }



        $quiz_id = $this->input->post('quiz_id');



        $quiz = $this->Quiz->getQuizById($quiz_id);



        if (empty($quiz)) {

            $this->session->set_flashdata('msg', 'Unable to find selected quiz');

            redirect('report');

        }



        $generated = $this->Result->generateReport($quiz_id);



        if ($generated) {

            $this->session->set_flashdata('msg', 'Report generated successfully');

        } else {

            $this->session->set_flashdata('msg', 'Unable to generate report');

            redirect('report');

        }



        redirect('report');

    }



    public function delete($id) {



     if (!$this->session->userdata('admin_login')) {

            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Unauthorized access!</div>");

            redirect(base_url());

        }



       

        $this->Result->deleteResult($id);



        $this->session->set_flashdata('msg', "<div class='alert alert-success'>Result deleted successfully</div>");

        redirect('report');

    }

}