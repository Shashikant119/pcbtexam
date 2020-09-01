<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 02/12/19
 * Time: 11:36 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class QuizController extends CI_Controller
{
    function __construct() {
        parent::__construct();

        $user_type = $this->session->userdata('admin_login');
        if (!$user_type) {
            redirect( base_url('admin'));
        }

        $this->load->model('Quiz');
        $this->load->model('QuestionBank');
    }

    public function index()
    {
        $data = array();
        $by_status = $this->input->get('by_status');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');

        $data['quizes'] = $this->Quiz->getAllQuizes($by_status, $from_date, $to_date);
        $this->load->view('admin/quiz_management', $data);
    }

    public function create() {
        $data = array();
        $data['packages'] = $this->Quiz->get_all_package();
        $this->load->view('admin/add-quiz', $data);
    }

    public function store() {

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('add-quiz');
        }

        //setting validation rule
        $this->form_validation->set_rules('quiz_name', 'Quiz Name', 'required');
        $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('end_time', 'End Time', 'required');
        $this->form_validation->set_rules('marks_per_question', 'Marks', 'required');
        $this->form_validation->set_rules('duration', 'Duration', 'required');
        $this->form_validation->set_rules('max_attempts', 'max_attempts', 'required');
        $this->form_validation->set_rules('min_pass_percentage', 'Minimum Pass Percentage', 'required');
        $this->form_validation->set_rules('negative_marks_per_question', 'Negative marks', 'required');

        // run form validation
        if ($this->form_validation->run() === FALSE) {
            $data = array();
            $data['packages'] = $this->Quiz->get_all_package();
            $this->load->view('admin/add-quiz', $data);
        }

        $quiz_packages = $this->input->post('quiz_packages');

        $input = array ( 'quiz_title' => $this->input->post('quiz_name'),
            'start_time' => $this->input->post('start_time'),
            'end_time' => $this->input->post('end_time'),
            'duration' => $this->input->post('duration'),
            'marks_per_question' => $this->input->post('marks_per_question'),
            'max_attempts_allowed' => $this->input->post('max_attempts'),
            'min_pass_percentage' => $this->input->post('min_pass_percentage'),
            'negative_marks_per_question' => $this->input->post('negative_marks_per_question'),
            'question_explanation' => $this->input->post('question_explanation'),
            'common_merit_link' => $this->input->post('common_merit_link'),
            'pdf_paper_link' => $this->input->post('pdf_paper_link'),
            'cbt_practice_link' => $this->input->post('cbt_practice_link'
        ),
            'show_answersheet'=>$this->input->post('show_answersheet'),
        );
           $input["image"]='';
          if($_FILES['package_image']['name']){
               
                $f=$_FILES['package_image']['name'];
                $file_name=$this->do_upload_field($f,'package_image','./assets/images/quiz');
                $input["image"]=$file_name;
            }
       
        $quiz_id = $this->Quiz->addQuiz($input);

        if ($quiz_id && !empty($quiz_packages)) {
            $input = array();
            foreach ($quiz_packages as $package) {
                $input[] = array("quiz_id" => $quiz_id, "package_id" => $package);
            }

            $this->Quiz->addQuizPackage($input);
        }

        redirect('quiz-management');
    }

    public function edit($quiz_id) {
        $data = array();
        $data["quiz"] = $this->Quiz->getQuizById($quiz_id);
        $data['packages'] = $this->Quiz->get_all_package();
        $this->load->view('admin/edit-quiz', $data);
    }

    public function update() {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('edit-quiz');
        }

        // setting validation rule
        $this->form_validation->set_rules('quiz_name', 'Quiz Name', 'required');
        $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('end_time', 'End Time', 'required');
        $this->form_validation->set_rules('marks_per_question', 'Marks', 'required');
        $this->form_validation->set_rules('duration', 'Duration', 'required');
        $this->form_validation->set_rules('max_attempts', 'max_attempts', 'required');
        $this->form_validation->set_rules('min_pass_percentage', 'Minimum Pass Percentage', 'required');
        $this->form_validation->set_rules('negative_marks_per_question', 'Negative marks', 'required');

        // run form validation
        if ($this->form_validation->run() === FALSE) {
            $data = array();
            $data['packages'] = $this->Quiz->get_all_package();
            $data["quiz"] = $this->Quiz->getQuizById($this->input->post('quiz_id'));
            $this->load->view('admin/add-quiz', $data);
        }

        $quiz_packages = $this->input->post('quiz_packages');
        $start_date = date("Y-m-d H:i:s", strtotime($this->input->post('start_time')));
        $end_date = date("Y-m-d H:i:s", strtotime(trim($this->input->post('end_time'))));

        $input = array ( 'quiz_title' => $this->input->post('quiz_name'),
            'start_time' => $start_date,
            'end_time' => $end_date,
            'duration' => $this->input->post('duration'),
            'marks_per_question' => $this->input->post('marks_per_question'),
            'max_attempts_allowed' => $this->input->post('max_attempts'),
            'min_pass_percentage' => $this->input->post('min_pass_percentage'),
            'negative_marks_per_question' => $this->input->post('negative_marks_per_question'),
            'question_explanation' => $this->input->post('question_explanation'),
            'common_merit_link' => $this->input->post('common_merit_link'),
            'pdf_paper_link' => $this->input->post('pdf_paper_link'),
            'cbt_practice_link' => $this->input->post('cbt_practice_link'),
            'show_answersheet'=>$this->input->post('show_answersheet'),
        );
        $quiz_id=$this->input->post('quiz_id');
        $quiz_image=$this->db->get_where('qms_quiz',['quiz_id'=> $quiz_id])->row()->image;
         $input["image"]=$quiz_image;
          if($_FILES['package_image']['name']){
               
                $f=$_FILES['package_image']['name'];
                $file_name=$this->do_upload_field($f,'package_image','./assets/images/quiz');
                $input["image"]=$file_name;
            }
        $where = array("quiz_id" => $this->input->post('quiz_id'));
        $this->Quiz->updateQuiz($input, $where);

        $quiz_id = $this->input->post('quiz_id');
       // echo "<pre>";print_r($quiz_packages);die;
        if (!empty($quiz_packages)) {
            $input = array();
            foreach ($quiz_packages as $package) {
                $input[] = array("quiz_id" => $quiz_id, "package_id" => $package);
            }

            $this->Quiz->updateQuizPackage($input, $quiz_id);
        }
        else
        {

            $this->db->where('quiz_id',$quiz_id)->delete('quiz_package');
        }

        redirect('quiz-management');
    }

    public function delete($quiz_id) {

        if($quiz_id > 0)
        {
            $where = array('quiz_id' => $quiz_id);
            $this->db->where(array('quiz_id' => $quiz_id))->delete('qms_quiz');
             $this->db->where(array('quiz_id' => $quiz_id))->delete('quiz_package');
            $this->session->set_flashdata('msg', 'Quiz deleted successfully.');
        } else {
            $this->session->set_flashdata('msg', 'Unable to delete quiz, please try again later');
        }
        redirect('quiz-management/');
    }

    // shows the details of chosen quiz
    public function show($quiz_id) {
        $data = array();
        $data["quiz"] = $this->Quiz->getQuizById($quiz_id);
        $data['packages'] = $this->Quiz->get_all_package();
        $data['added_questions'] = $this->QuestionBank->getQuizQuestions($quiz_id);
        $this->load->view('admin/show-quiz', $data);
    }

    public function add_question($quiz_id) {
        $data = array();
        $data["quiz"] = $this->Quiz->getQuizById($quiz_id);
        $data['questions'] = $this->QuestionBank->getQuestions();
        $data['added_question_ids'] = $this->Quiz->getQuizQuestionsId($quiz_id);
        $this->load->view('admin/quiz/add-quiz-question', $data);
    }

    public function add_question_to_quiz() {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Something went wrong, please try again later"]);
        }

        // setting validation rule
        $this->form_validation->set_rules('quiz_id', 'Quiz Id', 'required');
        $this->form_validation->set_rules('question_id', 'Question Id', 'required');

        // run form validation
        if ($this->form_validation->run() === FALSE) {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Unable to add question to this quiz"]);
        }

        $input = array();
        $input["quiz_id"] = $this->input->post('quiz_id');
        $input["question_id"] = $this->input->post('question_id');
        $res = $this->Quiz->addQuestionToThisQuiz($input);

        if ($res) {
            header('Content-Type: application/json');
            echo json_encode(["success" => true, "message" => "Question added to this quiz successfully"]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Unable to add question to this quiz"]);
        }
    }

    public function remove_quiz_question() {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Something went wrong, please try again later"]);
        }

        // setting validation rule
        $this->form_validation->set_rules('quiz_id', 'Quiz Id', 'required');
        $this->form_validation->set_rules('question_id', 'Question Id', 'required');

        // run form validation
        if ($this->form_validation->run() === FALSE) {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Some error occurred, please try again later"]);
        }

        $input = array();
        $input["quiz_id"] = $this->input->post('quiz_id');
        $input["question_id"] = $this->input->post('question_id');
        $res = $this->Quiz->removeQuizQuestion($input);

        if ($res) {
            header('Content-Type: application/json');
            echo json_encode(["success" => true, "message" => "Question removed from this quiz"]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Unable to remove the question, try again later"]);
        }
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