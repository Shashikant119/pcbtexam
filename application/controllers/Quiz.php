<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

    function __construct() {
        parent::__construct();
       $user_type = $this->session->userdata('admin_login');
        if (!$user_type) {
            redirect( base_url('admin'));
        }

        
        $this->load->model('Quiz_model');
    }

	public function index()
	{
        $data = array();
        $by_status = $this->input->get('by_status');
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        
        $data['quizes'] = $this->Quiz_model->get_all_quiz($by_status, $from_date, $to_date);
		$this->load->view('admin/quiz_management', $data);
	}

    public function add_update_quiz()
    {
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') 
        {
            //setting validation rule
            $this->form_validation->set_rules('quiz_name', 'Quiz Name', 'required');
            $this->form_validation->set_rules('marks_per_question', 'Marks', 'required');
            $this->form_validation->set_rules('no_of_question', 'No Od Question', 'required');
            $this->form_validation->set_rules('duration', 'Duration', 'required');
            $this->form_validation->set_rules('max_attempts', 'max_attempts', 'required');
            $this->form_validation->set_rules('min_pas_percentage', 'min_pas_percentage', 'required');
            $this->form_validation->set_rules('neg_marks_per_question', 'neg_marks_per_question', 'required');

            if ($this->form_validation->run() !== FALSE) 
            {
                $edit_id = $this->input->post('req_id');
                $quiz_packages = implode(',', $this->input->post('quiz_packages'));

                $data_ar = array ( 'quiz_title' => $this->input->post('quiz_name'),
                                   'no_of_question' => $this->input->post('no_of_question'),
                                   'duration' => $this->input->post('duration'),
                                   'marks_per_question' => $this->input->post('marks_per_question'),
                                   'max_attempts' => $this->input->post('max_attempts'),
                                   'min_pas_percentage' => $this->input->post('min_pas_percentage'),
                                   'neg_marks_per_question' => $this->input->post('neg_marks_per_question'),
                                   'quiz_packages' => $quiz_packages
                            );

                if ($edit_id > 0) 
                {
                    $where_ar = array('quiz_id' => $edit_id);
                    $this->Quiz_model->update_quiz($where_ar, $data_ar);
                    $this->session->set_flashdata('msg', 'Quiz updated successfully.');
                } 
                else
                {
                    $this->Quiz_model->add_quiz($data_ar);
                    $this->session->set_flashdata('msg', 'Quiz added successfully.');
                }
            }
            redirect('quiz-management/');
        }
        
        $data['packages'] = $this->Quiz_model->get_all_package();
        $get_id = intval($this->uri->segment(2));
        if($get_id > 0) 
        {
            $data['edit_data'] = $this->Quiz_model->get_quiz($get_id)[0];
        }
        $this->load->view('admin/add_update_quiz', $data);
    }

    public function del_quiz() 
    {
        $get_id = intval($this->uri->segment(2));
        if($get_id > 0) 
        {
            $where_ar = array('quiz_id' => $get_id);
            $this->Quiz_model->update_quiz($where_ar, array('is_active' => 0));
            $this->session->set_flashdata('msg', 'Quiz deleted successfully.');
        }
        redirect('quiz-management/');
    }

    public function add_question()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') 
        {
            //setting validation rule
            $this->form_validation->set_rules('question_text', 'Question Name', 'required');
            $this->form_validation->set_rules('option_1', 'Option 1', 'required');
            $this->form_validation->set_rules('option_2', 'Option 2', 'required');
            $this->form_validation->set_rules('option_3', 'Option 3', 'required');
            $this->form_validation->set_rules('option_4', 'Option 4', 'required');
            $this->form_validation->set_rules('answer_option', 'Answer Option', 'required');
            $this->form_validation->set_rules('quiz_id_for_question', 'Quiz Id', 'required');

            if ($this->form_validation->run() !== FALSE) 
            {
                $data_ar = array ( 'quiz_id' => $this->input->post('quiz_id_for_question'),
                                   'question' => $this->input->post('question_text'),
                                   'option_1' => $this->input->post('option_1'),
                                   'option_2' => $this->input->post('option_2'),
                                   'option_3' => $this->input->post('option_3'),
                                   'option_4' => $this->input->post('option_4'),
                                   'correct_option' => $this->input->post('answer_option'),
                                   'ans_explanation' => $this->input->post('question_explanation')
                            );
                $this->Quiz_model->add_quiz_question($data_ar);
                $this->session->set_flashdata('msg', 'Question added successfully.');
            }
            // redirect('question-management/' . $this->input->post('quiz_id_for_question'));
            redirect('question-management');
        }
    }

    public function update_question()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') 
        {
            //setting validation rule
            $this->form_validation->set_rules('equestion_text', 'Question Name', 'required');
            $this->form_validation->set_rules('eoption_1', 'Option 1', 'required');
            $this->form_validation->set_rules('eoption_2', 'Option 2', 'required');
            $this->form_validation->set_rules('eoption_3', 'Option 3', 'required');
            $this->form_validation->set_rules('eoption_4', 'Option 4', 'required');
            $this->form_validation->set_rules('eanswer_option', 'Answer Option', 'required');
            $this->form_validation->set_rules('quiz_id_for_question', 'Quiz Id', 'required');
            $this->form_validation->set_rules('req_edit_id', 'Question Id', 'required');

            if ($this->form_validation->run() !== FALSE) 
            {
                $data_ar = array ( 'question' => $this->input->post('equestion_text'),
                                   'option_1' => $this->input->post('eoption_1'),
                                   'option_2' => $this->input->post('eoption_2'),
                                   'option_3' => $this->input->post('eoption_3'),
                                   'option_4' => $this->input->post('eoption_4'),
                                   'correct_option' => $this->input->post('eanswer_option'),
                                   'ans_explanation' => $this->input->post('equestion_explanation')
                            );

                $where_ar = array('quiz_id' => $this->input->post('quiz_id_for_question'), 
                                  'question_id' => $this->input->post('req_edit_id'));

                $this->Quiz_model->update_quiz_question($where_ar, $data_ar);
                $this->session->set_flashdata('msg', 'Question updated successfully.');
            }
            // redirect('question-management/' . $this->input->post('quiz_id_for_question'));
            redirect('question-management/');
        }
    }

    public function get_question_details()
    {
        $data['status'] = '0';
        $question_id = intval($this->input->post('qid'));
        $quiz_id = intval($this->input->post('quzid'));
        $result = $this->Quiz_model->get_quiz_question($question_id, $quiz_id);
        if(count($result) > 0)
        {
            $data['status'] = '1';
            $data['result'] = $result[0];
        }
        echo json_encode($data);
    }

    public function del_question() 
    {
        $question_id = intval($this->uri->segment(2));
        $quiz_id = intval($this->uri->segment(3));
        $where_ar = array('quiz_id' => $quiz_id, 'question_id' => $question_id);
        $this->Quiz_model->update_quiz_question($where_ar, array('is_active' => 0));
        $this->session->set_flashdata('msg', 'Question deleted successfully.');
        redirect('question-management/'. $quiz_id);
    }

    public function quiz_report()
    {
        $data = array();
        $res_quiz = intval($this->input->get('sby_quiz'));
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        
        $data['quizes'] = $this->Quiz_model->get_all_quiz();
        $data['report_data'] = $this->Quiz_model->get_quiz_report($res_quiz, $from_date, $to_date);
        $this->load->view('admin/quiz_report', $data);
    }
    
    public function quiz_report_details()
    {
        $data = array();
        $quiz_id = intval($this->uri->segment(2));
        $user_id = intval($this->uri->segment(3));
        
        $data['report_data'] = $this->Quiz_model->get_quiz_report_details($quiz_id, $user_id);
        $this->load->view('admin/quiz_report_details', $data);
    }
    
    public function upload_draw_question()
    {

    }

}
