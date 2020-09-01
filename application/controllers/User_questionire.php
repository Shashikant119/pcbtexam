<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once APPPATH . 'libraries/Razorpay.php';
use Razorpay\Api\Api;
class User_questionire extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this
		->load
		->model('Quiz_model');
		$this
		->load
		->model('User_model');
		$this
		->load
		->model('QuestionBank');
		$this
		->load
		->model('User');
		$this
		->load
		->model('Package');

		$this
		->load
		->helper('url');
		$this
		->load
		->helper('custome_helper');
		date_default_timezone_set("Asia/Kolkata");
	}

	public function index(){
		redirect(base_url());
	}

	public function logout(){
		$this
		->session
		->sess_destroy();
		redirect(base_url());
	}

	public function dashboard(){
		if (!$this
			->session
			->userdata('login')){
			$url = $_SERVER['HTTP_REFERER'];
			$this
			->session
			->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue!!! </div>");
			redirect($url);
		}

		$where = array(
			'user_id' => $this
			->session
			->userdata('loginid')
		);
		$data['user'] = $this
		->User_model
		->getLoginUserData($where);
		$this
		->load
		->view('common/header', $data);
		$this
		->load
		->view('dashboard');
		$this
		->load
		->view('common/footer');

	}

	public function subscribenowmypackage($id){
		if (!$this
			->session
			->userdata('login')){
			$url = $_SERVER['HTTP_REFERER'];
			$this
			->session
			->set_flashdata('msg', "<div class='alert alert-danger'>Please login to start test </div>");
			redirect($url);
		}

		$con = array(
			'package_id' => $id
		);
		$packagedata = $this
		->User_model
		->getAlldata('qms_packages', '*', $con, 'package_id', 'asc');
		if ($packagedata[0]->package_type == 'Free'){

			date_default_timezone_set('Asia/Kolkata');
			$currentTime = date('d-m-Y ', time());
			$enddate = date('d-m-Y', strtotime('+' . $packagedata[0]->package_duration . ' days'));

			$data = array(
				'user_id' => $this
				->session
				->userdata('loginid') ,
				'package_id' => $id,
				'package_start' => $currentTime,
				'package_end' => $enddate,
				'status' => '1',
				'enterydate' => $currentTime,

			);
			$this
			->User_model
			->add_user_package($data);
		}
		else{
			redirect('index.php/ccAvenue/' . $id);
		}
		$this
		->session
		->set_flashdata('msg', "<div class='alert alert-success'>Packages Added successfully </div>");

		redirect('packages');
	}

	public function verify_username_old(){
		$response['status'] = '0';
		$this
		->form_validation
		->set_rules('username', 'Username', 'trim|required');
		if ($this
			->form_validation
			->run() !== false){
			$username = $this
			->input
			->post('username', true);
			$user_data = $this
			->User_model
			->exist_username($username);
			if (count($user_data) > 0){
				$user_data = $user_data[0];
                //  print_r($user_data);die;
				if ($user_data->is_active == 1)
				{
                    //creating otp
					$otp = $this
					->User_model
					->create_otp($username);
                    //Load email library
					$this
					->load
					->library('email');
					$this
					->email
					->initialize(array(
						'protocol' => 'smtp',
						'smtp_host' => 'smtp.sendgrid.net',
						'smtp_user' => 'getcoins',
						'smtp_pass' => 'finesoft@123',
						'smtp_port' => 587,
						'crlf' => "\r\n",
						'newline' => "\r\n"
					));
					$this
					->email
					->from('noreply@insightlcs.com', 'ECONNECT');
					$this
					->email
					->to('chandnikumari58@gmail.com');
					$this
					->email
					->set_mailtype("html");
					$this
					->email
					->subject('ONCQUIEST Questionire OTP');
					$this
					->email
					->message('<p>Dear User,</p><p>Your OTP for ONCQUIEST Questionire is <strong>' . $otp . '</strong></p>');
					if ($this
						->email
						->send()) $response['send_status'] = 'success';
						else $response['send_status'] = 'failed';
						$response['status'] = '1';
						$response['res'] = $user_data->name;
						$response['otp'] = $otp;
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
			else{
				$response['res'] = 'Please enter valid email.';
			}
			echo json_encode($response);
			die;
		}

		public function verify_username(){
			$response['status'] = '0';
			$this
			->form_validation
			->set_rules('username', 'Username', 'trim|required');
			if ($this
				->form_validation
				->run() !== false){
				$username = $this
				->input
				->post('username', true);
				$user_data = $this
				->User_model
				->exist_username($username);
				if (count($user_data) > 0)
				{
					$user_data = $user_data[0];
                //  print_r($user_data);die;
					if ($user_data->is_active == 1)
					{
                    //creating otp
						$otp = $this
						->User_model
						->create_otp($username);
                    //Load email library
						$this
						->load
						->library('email');
						$this
						->email
						->initialize(array(
							'protocol' => 'smtp',
							'smtp_host' => 'smtp.sendgrid.net',
							'smtp_user' => 'getcoins',
							'smtp_pass' => 'finesoft@123',
							'smtp_port' => 587,
							'crlf' => "\r\n",
							'newline' => "\r\n"
						));
						$this
						->email
						->from('noreply@insightlcs.com', 'ECONNECT');
						$this
						->email
						->to('chandnikumari58@gmail.com');
						$this
						->email
						->set_mailtype("html");
						$this
						->email
						->subject('ONCQUIEST Questionire OTP');
						$this
						->email
						->message('<p>Dear User,</p><p>Your OTP for ONCQUIEST Questionire is <strong>' . $otp . '</strong></p>');
						if ($this
							->email
							->send()) $response['send_status'] = 'success';
							else $response['send_status'] = 'failed';
							$response['status'] = '1';
							$response['res'] = $user_data->name;
							$response['otp'] = $otp;
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
				die;
			}

			public function verify_otp(){
				$response['status'] = '0';
				$this
				->form_validation
				->set_rules('username', 'Username', 'trim|required');
				$this
				->form_validation
				->set_rules('otp', 'OTP', 'trim|required|numeric');
				if ($this
					->form_validation
					->run() !== false)
				{
					$username = $this
					->input
					->post('username', true);
					$otp = $this
					->input
					->post('otp', true);
					$otp_data = $this
					->User_model
					->check_otp($username, $otp);
					if (count($otp_data) > 0)
					{
						$otp_data = $otp_data[0];
						if ($otp_data->is_used == 0)
						{
							$this
							->User_model
							->update_otp(array(
								'otp_id' => $otp_data->otp_id
							) , array(
								'is_used' => 1
							));
							$user_details = $this
							->User_model
							->get_user_by_username($username) [0];
							$this
							->session
							->set_userdata('userid', $user_details->user_id);

							$response['status'] = '1';
							$response['redirect'] = base_url() . 'my-quiz';
						}
						else
						{
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
				die;
			}

			public function show_quiz(){
				$this->is_valid_user();
				$data['quiz_data'] = $this
				->Quiz_model
				->get_active_quiz();
				$user_id = $this
				->session
				->userdata('userid');
				if ($this->alredy_submitted($data['quiz_data'][0]->quiz_id, $user_id))
				{
					$data['show_quiz'] = false;
				}
				else
				{
					$data['show_quiz'] = true;
				}
				$data['draft_answer'] = $this->get_user_draft_answer($user_id, $data['quiz_data'][0]->quiz_id);
				$this
				->load
				->view('common/header', $data);
				$this
				->load
				->view('quiz_list');

				$this
				->load
				->view('common/footer');

			}

			public function show_quiz_question(){
				$this->is_valid_user();
				$quiz_id = $this
				->uri
				->segment(2);
				$data['quiz_data'] = $this
				->Quiz_model
				->get_quiz_questions_for_user($quiz_id);
        // echo $this->db->last_query();die;
        //load draft answer
				$data['draft_answer'] = array();
				if (count($data['quiz_data']) > 0)
				{
					$user_id = $this
					->session
					->userdata('userid');
					$data['draft_answer'] = $this->get_user_draft_answer($user_id, $data['quiz_data'][0]->quiz_id);
				}
				$this
				->load
				->view('common/header', $data);
				$this
				->load
				->view('question_paper');

				$this
				->load
				->view('common/footer');

			}

			public function save_draft_user_answer(){
				$this->is_valid_user();
				if ($this
					->input
					->server('REQUEST_METHOD') === 'POST')
				{
					$quizid = intval($this
						->input
						->post('quizid'));
					$user_id = $this
					->session
					->userdata('userid');

					if ($quizid > 0 && !$this->alredy_submitted($quizid, $user_id))
					{
						$ans_row_ar = array();
						$answer_id = $this
						->Quiz_model
						->add_temp_quiz_answer(array(
							'user_id' => $user_id,
							'quiz_id' => $quizid
						));
						$attmpted = 0;
						foreach ($this
							->input
							->post() as $key => $answer)
						{
							if (strpos($key, 'question_') === 0)
							{
								if (!empty($answer))
								{
									$attmpted++;
									$question = explode('_', $key) [1];
									$ans_row_ar[] = array(
										'answer_id' => $answer_id,
										'question_id' => $question,
										'user_answer' => $answer
									);
								}
							}
						}

						if (count($ans_row_ar) > 0)
						{
							$this
							->Quiz_model
							->add_temp_quiz_answer_details($ans_row_ar);
						}
					}
				}
			}

			public function save_user_answer(){
				$this->is_valid_user();
				if ($this
					->input
					->server('REQUEST_METHOD') === 'POST'){
					$quizid = intval($this
						->input
						->post('quizid'));
					$user_id = $this
					->session
					->userdata('userid');
					if ($quizid > 0 && !$this->alredy_submitted($quizid, $user_id)){
						$quiz_question = $this
						->Quiz_model
						->get_quiz_questions($quizid);
						$attmpted = 0;
						$correct = 0;
						$ans_row_ar = array();
						$answer_id = $this
						->Quiz_model
						->add_quiz_answer(array(
							'user_id' => $user_id,
							'quiz_id' => $quizid
						));
						foreach ($this
							->input
							->post() as $key => $answer){
							if (strpos($key, 'question_') === 0){
								if (!empty($answer)){
									$attmpted++;
									$question = explode('_', $key) [1];
									$is_correct = NULL;
                            //checking correct answer
									foreach ($quiz_question as $questions){
										if ($questions->question_id == $question){
											if ($questions->correct_option == $answer){
												$is_correct = 1;
												$correct++;
											}
											else $is_correct = 0;
											break;
										}
									}
                            //user answer data
									$ans_row_ar[] = array(
										'answer_id' => $answer_id,
										'question_id' => $question,
										'user_answer' => $answer,
										'is_correct' => $is_correct
									);
								}
							}
						}
						if (count($ans_row_ar) > 0) $this
							->Quiz_model
						->add_quiz_answer_details($ans_row_ar);

						$quiz_marks = $this
						->Quiz_model
						->get_quiz($quizid);
						$quiz_marks = $quiz_marks[0];
						$data['month_toppers'] = $this
						->Quiz_model
						->get_last_month_topper();
						$data['tot_question'] = count($quiz_question);
						$data['marks'] = ($correct * intval($quiz_marks->marks_per_question));
						$data['attmpted'] = $attmpted;
						$data['correct_ans'] = $correct;
						$data['result_link'] = $answer_id;
						$this
						->load
						->view('common/header', $data);
						$this
						->load
						->view('quiz_result');
						$this
						->load
						->view('common/footer');

					}
					else{
						$data['msg'] = 'Quiz already submitted.';
						$this
						->load
						->view('quiz_error', $data);
					}
				}
			}

			public function get_user_result_old(){
				$this->is_valid_user();
				$answer_id = $this
				->uri
				->segment(2);
				$result = $this
				->Quiz_model
				->get_user_quiz_answer_details($answer_id);

				$this
				->load
				->library('excel');
				$object = new PHPExcel();
        //header style
				$style_top_head = array(
					'font' => array(
						'bold' => true,
						'color' => array(
							'rgb' => '0000FF'
						) ,
						'size' => 13
					)
				);
				$style_head = array(
					'font' => array(
						'bold' => true,
						'size' => 11
					)
				);
				$object->setActiveSheetIndex(0);
				$object->getActiveSheet()
				->setCellValue('A1', 'ONCQUEST Quiz : Result');
				$object->getActiveSheet()
				->getStyle('A1')
				->applyFromArray($style_top_head);
				$object->getActiveSheet()
				->mergeCells('A1:G1');

				$table_columns = array(
					"Question",
					"Option 1",
					"Option 2",
					"Option 3",
					"Option 4",
					"Your Answer" /*, "Result"*/
				);
				$column = '0';
				foreach ($table_columns as $field){
					$object->getActiveSheet()
					->setCellValueByColumnAndRow($column, 2, $field);
					$column++;
				}
				$object->getActiveSheet()
				->getStyle('A2:F2')
				->applyFromArray($style_head);

				$excel_row = 3;
				foreach ($result as $row){
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(0, $excel_row, $row->question);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(1, $excel_row, $row->option_1);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(2, $excel_row, $row->option_2);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(3, $excel_row, $row->option_3);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(4, $excel_row, $row->option_4);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(5, $excel_row, $row->{$row->user_answer});

					$excel_row++;
				}

				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$file_name = 'quiz-result-' . date('d-m-Y');
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="' . $file_name . '.xls"');
				header('Cache-Control: max-age=0');
				$object_writer->save('php://output');
			}

			public function get_user_result(){
				$this->is_valid_user();
				$answer_id = $this
				->uri
				->segment(2);
				$result = $this
				->Quiz_model
				->get_user_quiz_answer_details($answer_id);

				$this
				->load
				->library('excel');
				$object = new PHPExcel();
				$style_top_head = array(
					'font' => array(
						'bold' => true,
						'color' => array(
							'rgb' => '0000FF'
						) ,
						'size' => 13
					)
				);
				$style_head = array(
					'font' => array(
						'bold' => true,
						'size' => 11
					)
				);
				$object->setActiveSheetIndex(0);
				$object->getActiveSheet()
				->setCellValue('A1', 'ONCQUEST Quiz : Result');
				$object->getActiveSheet()
				->getStyle('A1')
				->applyFromArray($style_top_head);
				$object->getActiveSheet()
				->mergeCells('A1:G1');

				$table_columns = array(
					"Question",
					"Option 1",
					"Option 2",
					"Option 3",
					"Option 4",
					"Your Answer" /*, "Result"*/
				);
				$column = '0';
				foreach ($table_columns as $field)
				{
					$object->getActiveSheet()
					->setCellValueByColumnAndRow($column, 2, $field);
					$column++;
				}
				$object->getActiveSheet()
				->getStyle('A2:F2')
				->applyFromArray($style_head);

				$excel_row = 3;
				foreach ($result as $row)
				{
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(0, $excel_row, $row->question);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(1, $excel_row, $row->option_1);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(2, $excel_row, $row->option_2);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(3, $excel_row, $row->option_3);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(4, $excel_row, $row->option_4);
					$object->getActiveSheet()
					->setCellValueByColumnAndRow(5, $excel_row, $row->{$row->user_answer});
            //$is_correct = $row->is_correct == 1 ? 'Correct' : 'Incorrect';
            //$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $is_correct);
					$excel_row++;
				}

				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$file_name = 'quiz-result-' . date('d-m-Y');
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="' . $file_name . '.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $object_writer->save('php://output');
    }

    private function alredy_submitted($quiz, $user_id)
    {
    	$result = $this
    	->Quiz_model
    	->get_user_quiz_answer($quiz, $user_id);
    	if (count($result) > 0) return true;
    	else return false;
    }

    private function is_valid_user()
    {
    	$user_id = intval($this
    		->session
    		->userdata('userid'));
    	if ($user_id > 0)
    	{
            //ok

    	}
    	else
    	{
    		redirect(base_url());
    	}
    }

    private function get_user_draft_answer($user_id, $quiz_id)
    {
    	return $this
    	->Quiz_model
    	->get_temp_user_quiz_answer($user_id, $quiz_id);
    }
    /***********CCAVENUE intergration**********************/
    public function ccAvenueResponse()
    {
    	include_once (APPPATH . 'third_party/ccavenue/Crypto.php');
    	$workingKey = '258D4EFC784119A29F7B39B4BE193F9B';
    	$encResponse = $_POST["encResp"];
    	$rcvdString = decrypt($encResponse, $workingKey);

    	$user_id = $this
    	->session
    	->userdata('loginid');
    	$order_status = "";
    	$decryptValues = explode('&', $rcvdString);
        //echo "<pre>";print_r($decryptValues);die;
    	$dataSize = sizeof($decryptValues);
    	for ($i = 0;$i < $dataSize;$i++)
    	{
    		$information = explode('=', $decryptValues[$i]);
    		if ($i == 3) $order_status = $information[1];
    	}

    	if ($order_status === "Success")
    	{
    		$info = [];
    		foreach ($decryptValues as $value)
    		{
    			$val = explode('=', $value);
    			$info[$val[0]] = $val[1];
    		}
    		date_default_timezone_set("Asia/Kolkata");
    		$orderid = $info['order_id'];
    		$x = [];
    		$x['bank_ref_no'] = $info['bank_ref_no'];
    		$x['payment_status'] = $info['order_status'];
    		$x['payment_response'] = json_encode($info);
    		$x['tracking_id'] = $info['tracking_id'];
    		$x['payment_date'] = date('Y-m-d H:i:s');
    		$this
    		->db
    		->where(['order_id' => $orderid, 'user_id' => $user_id])->update('qms_payment_history', $x);
    		$con = array(
    			'package_id' => $x['order_id']
    		);
    		$packagedata = $this
    		->User_model
    		->getAlldata('qms_packages', '*', $con, 'package_id', 'asc');
    		if ($packagedata[0]->package_type != 'Free')
    		{
    			date_default_timezone_set('Asia/Kolkata');
    			$currentTime = date('Y-m-d');
    			$valid_days = $packagedata[0]->package_duration;
    			$enddate = date('Y-m-d', strtotime('+ ' . $valid_days . ' days'));

    			$data = array(
    				'user_id' => $user_id,
    				'package_id' => $x['order_id'],
    				'package_start' => $currentTime,
    				'package_end' => $enddate,
    				'status' => '1',
    				'enterydate' => date("Y-m-d") ,
    			);
    			$this
    			->User_model
    			->add_user_package($data);
    		}
    		$resp['msg'] = 'Thanks for subscribing package';
    		$this
    		->load
    		->view('ccavenue_reponse', $resp);

    	}
    	else if ($order_status === "Aborted")
    	{
    		$info = [];
    		foreach ($decryptValues as $value)
    		{
    			$val = explode('=', $value);
    			$info[$val[0]] = $val[1];
    		}
    		date_default_timezone_set("Asia/Kolkata");
    		$orderid = $info['order_id'];
    		$this
    		->db
    		->where(['order_id' => $orderid, 'user_id' => $user_id])->update('qms_payment_history', ['payment_status' => 'Aborted']);
    		$resp['error'] = "<br>You have aborted the transaction";
    		$this
    		->load
    		->view('ccavenue_reponse', $resp);

    	}
    	else if ($order_status === "Failure")
    	{
    		$info = [];
    		foreach ($decryptValues as $value)
    		{
    			$val = explode('=', $value);
    			$info[$val[0]] = $val[1];
    		}
    		date_default_timezone_set("Asia/Kolkata");
    		$orderid = $info['order_id'];
    		$this
    		->db
    		->where(['order_id' => $orderid, 'user_id' => $user_id])->update('qms_payment_history', ['payment_status' => 'Failed']);
    		$resp['error'] = "<br>Payment Failed .";
    		$this
    		->load
    		->view('ccavenue_reposne', $resp);
    	}
    	else
    	{
    		$info = [];
    		foreach ($decryptValues as $value)
    		{
    			$val = explode('=', $value);
    			$info[$val[0]] = $val[1];
    		}
    		date_default_timezone_set("Asia/Kolkata");
    		$orderid = $info['order_id'];
    		$this
    		->db
    		->where(['order_id' => $orderid, 'user_id' => $user_id])->update('qms_payment_history', ['payment_status' => 'Failed']);
    		$resp['error'] = "<br>Security Error. Illegal access detected";
    		$this
    		->load
    		->view('ccavenue_reponse', $resp);
    	}

    }
    public function ccAvenue($package_id)
    {
    	include_once (APPPATH . 'third_party/ccavenue/Crypto.php');
    	$pck_row = $this
    	->Package
    	->getPackageById($package_id);

    	$amount = $pck_row->package_price;
    	$user_id = $this
    	->session
    	->userdata('loginid');
    	$userinfo = $this
    	->User
    	->getUserDetail($user_id);
    	$orderid = uniqid();
    	$insert = ['user_id' => $user_id, 'order_id' => $orderid, 'amount' => $amount, 'payment_response' => NULL, 'payment_status' => 'Pending', 'tracking_id' => NULL, 'bank_ref_no' => NULL];
    	$this
    	->db
    	->insert('qms_payment_history', $insert);
    	$x['billing_name'] = $userinfo->name;
    	$x['billing_email'] = $userinfo->email;
    	$x['billing_state'] = '';
    	$x['billing_address'] = $userinfo->address;
    	$x['billing_zip'] = '';
    	$x['billing_city'] = '';
    	$x['billing_country'] = 'India';
    	$x['billing_tel'] = $userinfo->mobile;
    	$x['amount'] = $amount;
    	$x['tid'] = rand(100, 10000);
    	$x['merchant_id'] = '239255';
    	$x['order_id'] = $orderid;
    	$x['currency'] = 'INR';
    	$x['language'] = 'EN';
    	$x['redirect_url'] = "https://pcbtexamportal.com/ccAvenueResponse";
    	$x['cancel_url'] = "https://pcbtexamportal.com/ccAvenueResponse";
    	$merchant_data = '';
    	$access_code = 'AVSM88GK92BQ85MSQB';
    	$working_key = '258D4EFC784119A29F7B39B4BE193F9B';
    	foreach ($x as $key => $value)
    	{
    		$merchant_data .= $key . '=' . urlencode($value) . '&';
    	}
    	$s['encrypted_data'] = encrypt($merchant_data, $working_key);
    	$s['access_code'] = $access_code;
    	$this
    	->load
    	->view('ccavenue_redirect', $s);
    }
    /***********BULK PAYMENT CCAVENUE**************************/
    public function show_bulk_payment()
    {
    	if (!$this
    		->session
    		->userdata('login'))
    	{
    		$url = $_SERVER['HTTP_REFERER'];
    		$this
    		->session
    		->set_flashdata('msg', "<div class='alert alert-danger'>please login to continue! </div>");
    		redirect($url);
    	}
    	$view = $this
    	->input
    	->get('view', true) == "table" ? "table" : "grid";
    	$where = array(
    		'user_id' => $this
    		->session
    		->userdata('user_id')
    	);
    	$data['user'] = $this
    	->User_model
    	->getLoginUserData($where);
    	$data['packages'] = $this
    	->Package
    	->getAllPackages(0);
    	$this
    	->load
    	->view('common/header', $data);
    	$this
    	->load
    	->view('package/bulk_payment');
    	$this
    	->load
    	->view('common/user_footer');
    }

    public function bulk_payment()
    {
    	include_once (APPPATH . 'third_party/ccavenue/Crypto.php');

    	$packids = $this
    	->input
    	->post('packids');
    	$packs = json_decode($packids, true);
    	$amount = 0.0;
    	$pack_str = '';
    	foreach ($packs as $r)
    	{
    		$pack_row = $this
    		->Package
    		->getPackageById($r);
    		$amount += $pack_row->package_price;
    		$pack_str .= $r . "_";
    	}
    	$this
    	->session
    	->set_userdata('packs', $packids);
    	$user_id = $this
    	->session
    	->userdata('loginid');
    	$userinfo = $this
    	->User
    	->getUserDetail($user_id);
    	$orderid = uniqid();
    	$insetr = ['user_id' => $user_id, 'order_id' => $orderid, 'amount' => $amount, 'payment_response' => NULL, 'payment_status' => 'Pending', 'tracking_id' => NULL, 'bank_ref_no' => NULL, 'payment_date' => date('Y-m-d H:i:s') ];
    	$this
    	->db
    	->insert('qms_payment_history', $insert);
    	$x['billing_name'] = $userinfo->name;
    	$x['billing_email'] = $userinfo->email;
    	$x['billing_state'] = '';
    	$x['billing_address'] = $userinfo->address;
    	$x['billing_zip'] = '';
    	$x['billing_city'] = '';
    	$x['billing_country'] = 'India';
    	$x['billing_tel'] = $userinfo->mobile;
    	$x['amount'] = $amount;
    	$x['tid'] = rand(100, 10000);
    	$x['merchant_id'] = '239255';
    	$x['order_id'] = $orderid;
    	$x['currency'] = 'INR';
    	$x['language'] = 'EN';
    	$x['redirect_url'] = "https://pcbtexamportal.com/bulk-payment-response";
    	$x['cancel_url'] = "https://pcbtexamportal.com/bulk-payment-response";
    	$merchant_data = '';
    	$access_code = 'AVSM88GK92BQ85MSQB';
    	$working_key = '258D4EFC784119A29F7B39B4BE193F9B';
    	foreach ($x as $key => $value)
    	{
    		$merchant_data .= $key . '=' . urlencode($value) . '&';
    	}
    	$s['encrypted_data'] = encrypt($merchant_data, $working_key);
    	$s['access_code'] = $access_code;
    	$this
    	->load
    	->view('ccavenue_redirect', $s);
    }

    public function bulk_payment_response()
    {
    	include_once (APPPATH . 'third_party/ccavenue/Crypto.php');
    	date_default_timezone_set("Asia/Kolkata");
    	$workingKey = '258D4EFC784119A29F7B39B4BE193F9B';
        //$workingKey='85131596600AAE716310A3373816BBB5';
    	$encResponse = $_POST["encResp"];
    	$rcvdString = decrypt($encResponse, $workingKey);

    	$user_id = $this
    	->session
    	->userdata('loginid');
    	$order_status = "";
    	$decryptValues = explode('&', $rcvdString);
        //echo "<pre>";print_r($decryptValues);die;
    	$dataSize = sizeof($decryptValues);
    	for ($i = 0;$i < $dataSize;$i++)
    	{
    		$information = explode('=', $decryptValues[$i]);
    		if ($i == 3) $order_status = $information[1];
    	}
        //echo $order_status;die;
    	if ($order_status === "Success")
    	{
    		$info = [];
    		foreach ($decryptValues as $value)
    		{
    			$val = explode('=', $value);
    			$info[$val[0]] = $val[1];
    		}
    		$pack_ar = [];
    		$orderid = $info['order_id'];
    		$packids = json_decode($this
    			->session
    			->userdata('packs') , true);

    		foreach ($packids as $t)
    		{
    			if ($t) array_push($pack_ar, $t);
    		}

    		$x = [];
    		$x['bank_ref_no'] = $info['bank_ref_no'];
    		$x['payment_status'] = $info['order_status'];
    		$x['payment_response'] = json_encode($info);
    		$x['tracking_id'] = $info['tracking_id'];
    		$x['payment_date'] = date('Y-m-d H:i:s');
    		$this
    		->db
    		->where(['order_id' => $orderid, 'user_id' => $user_id])->update('qms_payment_history', $x);
            // echo "<pre>";print_r($x);die;
    		if (count($pack_ar) > 0)
    		{
    			foreach ($pack_ar as $r)
    			{
    				if (isUserPackage($user_id, $r))
    				{
    					continue;
    				}
    				$con = array(
    					'package_id' => $r
    				);
    				$packagedata = $this
    				->User_model
    				->getAlldata('qms_packages', '*', $con, 'package_id', 'asc');
    				if ($packagedata[0]->package_type != 'Free')
    				{
    					date_default_timezone_set('Asia/Kolkata');
    					$currentTime = date('Y-m-d H:i:s');
    					$valid_days = $packagedata[0]->package_duration;
    					$enddate = date('Y-m-d', strtotime('+ ' . $valid_days . ' days'));
    					$data = array(
    						'user_id' => $user_id,
    						'package_id' => $r,
    						'package_start' => $currentTime,
    						'package_end' => $enddate,
    						'status' => '1',
    						'enterydate' => date("Y-m-d") ,
    					);
    					$this
    					->User_model
    					->add_user_package($data);
    				}
    			}
    		}
    		$this
    		->session
    		->unset_userdata('packs');
    		$resp['msg'] = 'Thanks for subscribing package';
    		$this
    		->load
    		->view('ccavenue_reponse', $resp);

    	}
    	else if ($order_status === "Aborted")
    	{
    		$info = [];
    		foreach ($decryptValues as $value)
    		{
    			$val = explode('=', $value);
    			$info[$val[0]] = $val[1];
    		}
    		$orderid = $info['order_id'];
    		$this
    		->db
    		->where(['order_id' => $orderid, 'user_id' => $user_id])->update('qms_payment_history', ['payment_status' => 'Aborted']);
    		$resp['error'] = "<br>You have aborted the transaction";
    		$this
    		->load
    		->view('ccavenue_reponse', $resp);

    	}
    	else if ($order_status === "Failure")
    	{
    		$info = [];
    		foreach ($decryptValues as $value)
    		{
    			$val = explode('=', $value);
    			$info[$val[0]] = $val[1];
    		}

    		$orderid = $info['order_id'];
    		$this
    		->db
    		->where(['order_id' => $orderid, 'user_id' => $user_id])->update('qms_payment_history', ['payment_status' => 'Failed']);
    		$resp['error'] = "<br>Payment Failed .";
    		$this
    		->load
    		->view('ccavenue_reponse', $resp);
    	}
    	else
    	{
    		$info = [];
    		foreach ($decryptValues as $value)
    		{
    			$val = explode('=', $value);
    			$info[$val[0]] = $val[1];
    		}

    		$orderid = $info['order_id'];
    		$this
    		->db
    		->where(['order_id' => $orderid, 'user_id' => $user_id])->update('qms_payment_history', ['payment_status' => 'Failed']);
    		$resp['error'] = "<br>Security Error. Illegal access detected";
    		$this
    		->load
    		->view('ccavenue_reponse', $resp);
    	}

    }

    public function paymentSuccess()
    {
    	$packid = $this
    	->input
    	->post('product_id');
    	$packprice = getPackPrice($packid);
    	$razor_orderid = $this
    	->input
    	->post('razorpay_order_id');
    	$server_orderid = $this
    	->input
    	->post('server_order_id');
        // echo "<pre>";print_r($_POST);die;
    	if ($server_orderid == $razor_orderid)
    	{
    		$data = [

    			'payment_id' => $this
    			->input
    			->post('razorpay_payment_id') , 'pack_id' => $this
    			->input
    			->post('product_id') , 'date' => date("Y-m-d H:i:s") , 'status' => 'Success'];
    			$this
    			->db
    			->where(['order_id' => $razor_orderid, 'user_id' => $this
    				->session
    				->userdata('loginid') ]);
    			$this
    			->db
    			->update('razor_pay', $data);
    			echo $this
    			->db
    			->last_query();
    			$con = array(
    				'package_id' => $this
    				->input
    				->post('product_id')
    			);
    			$packagedata = $this
    			->User_model
    			->getAlldata('qms_packages', '*', $con, 'package_id', 'asc');
    			if ($packagedata[0]->package_type != 'Free')
    			{
    				date_default_timezone_set('Asia/Kolkata');
    				$currentTime = date('Y-m-d');
    				$valid_days = $packagedata[0]->package_duration;
    				$enddate = date('Y-m-d', strtotime('+ ' . $valid_days . ' days'));

    				$data = array(
    					'user_id' => $this
    					->session
    					->userdata('loginid') ,
    					'package_id' => $packid,
    					'package_start' => $currentTime,
    					'package_end' => $enddate,
    					'status' => '1',
    					'enterydate' => date("Y-m-d") ,
    				);
    				$this
    				->User_model
    				->add_user_package($data);
    			}
    			echo "success";
    		}
    		else echo "";

    	}

    	public function bulkpaymentSuccess()
    	{
    		$razor_orderid = $this
    		->input
    		->post('razorpay_payment_id');
    		$server_orderid = $this
    		->input
    		->post('server_order_id');
    		if ($server_orderid === $razor_orderid)
    		{
    			$data = ['payment_id' => $this
    			->input
    			->post('razorpay_payment_id') , 'pack_id' => $this
    			->input
    			->post('product_id') , 'date' => date("Y-m-d H:i:s") ];
    			$this
    			->db
    			->where(['order_id' => $razor_orderid, 'user_id' => $this
    				->session
    				->userdata('loginid') , 'amount' => $this
    				->input
    				->post('amount') ]);
    			$this
    			->db
    			->update('razor_pay', $data);

    			$pack_ar = json_decode($this
    				->input
    				->post('product_id') , true);
    			$amtsum = 0;
    			foreach ($pack_ar as $r)
    			{
    				$packprice = getPackPrice($r);
    				$amtsum += $packprice;
    			}
    			if ($amtsum == $this
    				->input
    				->post('amount'))
    			{
    				if (count($pack_ar) > 0)
    				{
    					foreach ($pack_ar as $r)
    					{
    						if (isUserPackage($this
    							->session
    							->userdata('loginid') , $r))
    						{
    							continue;
    						}
    						$con = array(
    							'package_id' => $r
    						);
    						$packagedata = $this
    						->User_model
    						->getAlldata('qms_packages', '*', $con, 'package_id', 'asc');
    						if ($packagedata[0]->package_type != 'Free')
    						{
    							date_default_timezone_set('Asia/Kolkata');
    							$currentTime = date('Y-m-d H:i:s');
    							$valid_days = $packagedata[0]->package_duration;
    							$enddate = date('Y-m-d', strtotime('+ ' . $valid_days . ' days'));
    							$data = array(
    								'user_id' => $this
    								->session
    								->userdata('loginid') ,
    								'package_id' => $r,
    								'package_start' => $currentTime,
    								'package_end' => $enddate,
    								'status' => '1',
    								'enterydate' => date("Y-m-d") ,

    							);
    							$this
    							->User_model
    							->add_user_package($data);
    						}
    					}
    				}
    				echo "success";
    			}
    			else echo '';
    		}
    	}
    	public function orderId()
    	{
    		$api = new Api('rzp_live_jwsPSDG8TDC9I1', 'UeNqHvZaSYYwFiJwH7oXVVEs');
    		$amount = $this
    		->input
    		->post('amount');
    		$packid = $this
    		->input
    		->post('product_id');
    		$order = $api
    		->order
    		->create(array(
    			'receipt' => uniqid() ,
    			'amount' => $amount,
    			'currency' => 'INR'
        )); // Creates order
    		$orderId = $order['id'];
    		$data = ['user_id' => $this
    		->session
    		->userdata('loginid') , 'order_id' => $orderId, 'amount' => ($amount / 100) , 'pack_id' => $packid, 'date' => date("Y-m-d H:i:s") ];
    		$this
    		->db
    		->insert('razor_pay', $data);
    		echo $orderId;
    	}
    }

