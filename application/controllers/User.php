<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('User_model');
		$this->load->library('google');
    }

	/*public function index()
	{
		$data = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST') 
        {
            $dob = date('Y-m-d', strtotime($this->input->post('dob')));
            $password = md5( date('dmY', strtotime($dob)) );
            $data = array( 'username' => $this->input->post('email'),
                           'password' => $password,
                           'user_type' => 2,
                           'name' => $this->input->post('name'),
                           'email' => $this->input->post('email'),
                           'mobile' => $this->input->post('mobile'),
                           'dob' => $dob,
                           'address' => trim($this->input->post('address'))
                    );
            $user_id = $this->User_model->add_user($data);
            if($user_id) {
                $username = 'PCBT' . str_pad($user_id, 5, "0", STR_PAD_LEFT);
                $this->User_model->update_user(array('user_id' => $user_id), array('username' => $username));
                redirect('/User/registrationSuccess?msg='.$username, 'refresh');
            }
        }
		
		$data['google_login_url']=$this->google->get_login_url();
		$this->load->view('user_registration', $data);
	}*/
	
	/*public function registrationSuccess()
	{
	    $this->load->view('registration_success');
	}*/
	# Google login
	public function gLogin(){
		$google_data=$this->google->validate();
	
		$session_data=array(
			'name'=>$google_data['name'],
			'email'=>$google_data['email'],
			'sess_logged_in'=>1
		);
		# Check if user is already exist
		if($google_data['email'])
		{

			$checkUser = $this->User_model->checkUserByEmail($google_data['email']);
			if($checkUser)
			{
				$googleData = array( 'username' => $google_data['email'],
					   'password' => '',
					   'user_type' => 2,
					   'name' => $google_data['name'],
					   'email' => $google_data['email'],
					   'mobile' => '',
					   'dob' => '',
					   'address' => ''
				);
				$user_id = $this->User_model->add_user($googleData);
				if($user_id)
				{
					$username = 'PCBT' . str_pad($user_id, 5, "0", STR_PAD_LEFT);
					$this->User_model->update_user(array('user_id' => $user_id), array('username' => $username));
					$this->session->set_userdata($session_data);
					redirect('/User/registrationSuccess?msg='.$username, 'refresh');
				}
			}
			
			redirect(base_url());
		}
	}
    /*
    public function verify_username() 
    {
        $response['status'] = '0';
        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email');
        if ($this->form_validation->run() !== FALSE) 
        {
            $username = $this->input->post('username', true);
            $user_data = $this->User_model->exist_username($username);
            if(count($user_data) > 0) 
            {
                $user_data = $user_data[0];
                if($user_data->is_active == 1) 
                {
                    //creating otp
                    $otp = $this->User_model->create_otp($username);
                    
                    //Load email library
                    $this->load->library('email');
                    $this->email->from('', 'Identification');
                    $this->email->to($user_data->email);
                    $this->email->subject('ONCQUIEST Questionire OTP');
                    $this->email->message('<p>Dear User,</p><p>Your OTP for ONCQUIEST Questionire is <strong>'. $otp .'</strong></p>');
                    //Send mail
                    if($this->email->send())
                        $response['send_status'] = 'success';
                    else
                        $response['send_status'] = 'failed';
                    $response['status'] = '1';
                    $response['res'] = $user_data->name;
                    $response['otp_sent'] = $user_data->email;
                } 
                else 
                {
                    $response['res'] = 'Sorry! Your account is not active.';
                }    
            } 
            else 
            {
                $response['res'] = 'Sorry! Email does not exist.';
            }
        }
        else
        {
            $response['res'] = 'Please enter valid email.';
        }
        echo json_encode($response);
    }

    public function verify_otp()
    {
        $response['status'] = '0';
        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email');
        $this->form_validation->set_rules('otp', 'OTP', 'trim|required|numeric');
        if ($this->form_validation->run() !== FALSE) 
        {
            $username = $this->input->post('username', true);
            $otp = $this->input->post('otp', true);
            $otp_data = $this->User_model->check_otp($username, $otp);
            if(count($otp_data) > 0) 
            {
                $otp_data = $otp_data[0];
                if ($otp_data->is_used == 0) {
                    $this->User_model->update_otp( array('otp_id' => $otp_data->otp_id), array('is_used' => 1) );
                    $user_details = $this->User_model->get_user_by_username($username)[0];
                    $this->session->set_userdata('userid', $user_details->user_id);

                    $response['status'] = '1';
                    $response['redirect'] = base_url() . 'my-quiz';
                } else {
                    $response['res'] = 'Sorry! Your OTP has been expired.';
                }
            }
            else
            {
                $response['res'] = 'Sorry! You have entered invalid otp.';
            }
        }
        else
        {
            $response['res'] = 'Please enter OTP.';
        }
        echo json_encode($response);
    }

    public function show_quiz()
    {
        $this->is_valid_user();
        $data['quiz_data'] = $this->Quiz_model->get_active_quiz();
        $user_id = $this->session->userdata('userid');
        if( $this->alredy_submitted($data['quiz_data'][0]->quiz_id, $user_id) ) {
            $data['show_quiz'] = false;
        } else {
            $data['show_quiz'] = true;
        }
        $data['draft_answer'] = $this->get_user_draft_answer($user_id, $data['quiz_data'][0]->quiz_id);
        $this->load->view('quiz_list', $data);
    }

    public function show_quiz_question()
    {
        $this->is_valid_user();
        $quiz_id = $this->uri->segment(2);
        $data['quiz_data'] = $this->Quiz_model->get_quiz_questions_for_user($quiz_id);
        //load draft answer
        $data['draft_answer'] = array();
        if (count($data['quiz_data']) > 0) {
            $user_id = $this->session->userdata('userid');
            $data['draft_answer'] = $this->get_user_draft_answer($user_id, $data['quiz_data'][0]->quiz_id);
        }
        $this->load->view('question_paper', $data);
    }
    
    public function save_draft_user_answer()
    {
        $this->is_valid_user();
        if ($this->input->server('REQUEST_METHOD') === 'POST') 
        {
            $quizid = intval($this->input->post('quizid'));
            $user_id = $this->session->userdata('userid');
            
            if ( $quizid > 0 && !$this->alredy_submitted($quizid, $user_id) )
            {
                $ans_row_ar = array();
                $answer_id = $this->Quiz_model->add_temp_quiz_answer( array( 'user_id' => $user_id, 'quiz_id' => $quizid ) );
                foreach ($this->input->post() as $key => $answer)  
                {
                    if (strpos($key, 'question_') === 0) 
                    {
                        if(!empty($answer)) 
                        {
                            $attmpted++;
                            $question = explode('_', $key)[1];
                            $ans_row_ar[] = array (
                                                    'answer_id' => $answer_id,
                                                    'question_id' => $question,
                                                    'user_answer' => $answer
                                            );
                        }
                    }
                }
                
                if (count($ans_row_ar) > 0) 
                {
                    $this->Quiz_model->add_temp_quiz_answer_details($ans_row_ar);
                }    
            }
        }   
    }

    public function save_user_answer()
    {
        $this->is_valid_user();
        if ($this->input->server('REQUEST_METHOD') === 'POST') 
        {
            $quizid = intval($this->input->post('quizid'));
            $user_id = $this->session->userdata('userid');
            if ( $quizid > 0 && !$this->alredy_submitted($quizid, $user_id) )
            {
                $quiz_question = $this->Quiz_model->get_quiz_questions($quizid);
                $attmpted = 0;
                $correct = 0;
                $ans_row_ar = array();
                $answer_id = $this->Quiz_model->add_quiz_answer( array( 'user_id' => $user_id,
                                                                        'quiz_id' => $quizid
                                                                  ));
                foreach ($this->input->post() as $key => $answer)  
                {
                    if (strpos($key, 'question_') === 0) 
                    {
                        if(!empty($answer)) 
                        {
                            $attmpted++;
                            $question = explode('_', $key)[1];
                            $is_correct = NULL;
                            //checking correct answer
                            foreach ($quiz_question as $questions) {
                                if ($questions->question_id == $question) {
                                    if ($questions->correct_option == $answer) {
                                        $is_correct = 1;
                                        $correct++;
                                    } else
                                        $is_correct = 0;
                                    break;
                                }
                            }
                            //user answer data
                            $ans_row_ar[] = array (
                                                    'answer_id' => $answer_id,
                                                    'question_id' => $question,
                                                    'user_answer' => $answer,
                                                    'is_correct' => $is_correct
                                            );
                        }
                    }
                }
                if (count($ans_row_ar) > 0)
                    $this->Quiz_model->add_quiz_answer_details($ans_row_ar);

                $quiz_marks = $this->Quiz_model->get_quiz($quizid);
                $quiz_marks = $quiz_marks[0];
                //setting result page
                $data['month_toppers'] = $this->Quiz_model->get_last_month_topper();
                $data['tot_question'] = count($quiz_question);
                $data['marks'] = ( $correct * intval($quiz_marks->marks_per_question) );
                $data['attmpted'] = $attmpted;
                $data['correct_ans'] = $correct;
                $data['result_link'] = $answer_id;
                $this->load->view('quiz_result', $data);
            }
            else
            {
                $data['msg'] = 'Quiz already submitted.';
                $this->load->view('quiz_error', $data);
            }
        }   
    }

    public function get_user_result()
    {
        $this->is_valid_user();
        $answer_id = $this->uri->segment(2);
        $result = $this->Quiz_model->get_user_quiz_answer_details($answer_id);

        $this->load->library('excel');
        $object = new PHPExcel();
        //header style
        $style_top_head = array( 'font'  => array (
                                        'bold'  => true,
                                        'color' => array('rgb' => '0000FF'),
                                        'size'  => 13
                                     )
                               );
        $style_head = array( 'font'  => array (
                                        'bold'  => true,
                                        'size'  => 11
                                     )
                           );
        $object->setActiveSheetIndex(0);
        $object->getActiveSheet()->setCellValue('A1', 'ONCQUEST Quiz : Result');
        $object->getActiveSheet()->getStyle('A1')->applyFromArray($style_top_head);
        $object->getActiveSheet()->mergeCells('A1:G1');

        $table_columns = array("Question", "Option 1", "Option 2", "Option 3", "Option 4", "Your Answer");
        $column = '0';
        foreach($table_columns as $field) {
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
           $column++;
        }
        $object->getActiveSheet()->getStyle('A2:F2')->applyFromArray($style_head);

        $excel_row = 3;          
        foreach($result as $row) {
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->question);
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->option_1);
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->option_2);
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->option_3);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->option_4);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->{$row->user_answer});
           //$is_correct = $row->is_correct == 1 ? 'Correct' : 'Incorrect';
           //$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $is_correct);
           $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        $file_name = 'quiz-result-' . date('d-m-Y');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $file_name .'.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $object_writer->save('php://output');
    }

    private function alredy_submitted($quiz, $user_id)
    {
        $result = $this->Quiz_model->get_user_quiz_answer($quiz, $user_id);
        if (count($result) > 0)
            return true;
        else
            return false;
    }

    private function is_valid_user()
    {
        $user_id = intval($this->session->userdata('userid'));
        if($user_id > 0) {
            //ok
        } else {
            redirect( base_url() );
        }
    }
    
    private function get_user_draft_answer($user_id, $quiz_id) 
    {
        return $this->Quiz_model->get_temp_user_quiz_answer($user_id, $quiz_id);
    }
    */
}