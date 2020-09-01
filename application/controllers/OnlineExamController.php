<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 24/12/19
 * Time: 5:46 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class OnlineExamController extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $user_type = intval($this->session->userdata('user_type'));

       /* if($user_type != 2) {
            redirect(base_url());
        }
*/
        $this->load->model('OnlineExam');
        $this->load->model('QuestionBank');
        $this->load->model('Package');
        $this->load->model('Quiz');
        $this->load->model('User_model');
        $this->load->model('Result');
        $this->load->helper('url');
    }

    public function instructions($package_id, $quiz_id)
    {
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please login to start test</div>");
            redirect(base_url());
        }

        // check if quiz belongs to current user
        $quiz_data = $this->OnlineExam->getQuizData($package_id, $quiz_id);

        if (empty($quiz_data->number_of_questions)) {
            $this->session->set_flashdata('msg', "<div class='alert alert-info'>Selected quiz has no questions, please select different quiz</div>");
            redirect(base_url('my-quiz')."/".$package_id);
        }

        $quiz_attempts = $this->OnlineExam->getAttemptsLeft($quiz_id);

        if (($quiz_data->max_attempts_allowed - $quiz_attempts->total_attempts) <= 0) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>You have reached maximum number of allowed attempts.</div>");
            redirect(base_url()."my-quiz/".$package_id);
        }

        $quiz_session_data = array(
            'duration' => $quiz_data->duration,
            'max_attempts' => $quiz_data->max_attempts_allowed,
            'quiz_id' => $quiz_data->quiz_id,
            'no_of_question' => $quiz_data->number_of_questions,
            'marks_per_question' => $quiz_data->marks_per_question,
            'min_pas_percentage' => $quiz_data->min_pass_percentage,
            'neg_marks_per_question' => $quiz_data->negative_marks_per_question,
            'quiz_title' => $quiz_data->quiz_title,
            'total_attempted' => $quiz_attempts->total_attempts,
            'no_of_attempt' => $quiz_attempts->max_number_of_attempts,
            'package_id' => $package_id,
        );

        $this->session->set_userdata($quiz_session_data);

        $where = array('qms_users.user_id' => $this->session->userdata('user_id'), 'qms_users.is_active' => 1);
        $data['user'] = $this->User_model->getLoginUserData($where);
        $data['quiz'] = $quiz_data;
        $data['attempts_left'] = $quiz_data->max_attempts_allowed - $quiz_attempts->total_attempts;

        $this->load->view('instructions', $data);
    }

    public function online_test()
    { 
        /*echo "hooo";die;
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please login first to start test</div>");
            redirect(base_url());
        }

        if ($this->input->post('instructions') != 'agree') {
            $url = $_SERVER["HTTP_REFERER"];
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Please read instructions and agree to our terms and conditions</div>");
            redirect($url);
        }*/

        $where = array('user_id' => $this->session->userdata('user_id'), "is_active" => 1);
        $data['user'] = $this->User_model->getLoginUserData($where);

        date_default_timezone_set('Asia/Kolkata');
        $current_date_time = date('Y-m-d H:i:s', time());
        $curent_time = date('H:i:s', time());

        $data["questions"] = $this->QuestionBank->getQuizQuestions($this->session->userdata('quiz_id'));
        $data["package"] = $this->Package->getPackageById($this->session->userdata('package_id'));
        $data["quiz"] = $this->Quiz->getQuizById($this->session->userdata('quiz_id'));

        if (empty($this->session->userdata('qms_user_test_id'))) {
            $start_test_data = array(
                'quiz_id' => $this->session->userdata('quiz_id'),
                'user_id' => $this->session->userdata('user_id'),
                'duration' => $this->session->userdata('duration'),
                'no_of_attempt' => $this->session->userdata('no_of_attempt') + 1,
                'submitted' => 0,
                'number_of_questions' => $this->session->userdata('no_of_question'),
                'started_time' => $curent_time,
                'entry_date_time' => $current_date_time,
            );

            $test_detail_insert_id = $this->OnlineExam->startTest($start_test_data);
            $this->session->set_userdata('qms_user_test_id', $test_detail_insert_id);
            $this->session->set_userdata('offset', 0);

            if (!empty($data['questions'])) {
                $questions = array();
                foreach ($data['questions'] as $key => $value) {
                    $question = array('question_id' => $value->question_id,
                        'question_status' => '0',
                        'selected_answer' => NULL,
                        'user_test_id' => $test_detail_insert_id,
                        'started_date_time' => $current_date_time,
                        'updated_date_time' => NULL,
                    );

                    array_push($questions, $question);
                }
             
                $this->OnlineExam->addTestQuestions($questions);

            }
        }
       $data['forsttime']=1;
        $this->load->view('quiz/online-quiz', $data);
    }

    public function save_and_next() {

        if (!$this->session->userdata('login')) {
            echo "<div class='alert alert-danger'>Please login first to start test</div>";
            die;
        }

        if ($this->input->post('selected_answer')) {
            $question_status = $this->input->post('mark_for_review') == "YES" ? "1" : "3";
        } else {
            $question_status = $this->input->post('mark_for_review') == "YES" ? "4" : "2";
        }
//echo $this->input->post('id');die;
        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date('Y-m-d H:i:s', time());
        $where = array('id' => $this->input->post('id'));
        $data = array(
            'question_status' => $question_status,
            'selected_answer' => $this->input->post('selected_answer'),
            'updated_date_time' => $currentTime
        );
     //  echo "<pre>";print_r($data);die;
        $this->OnlineExam->updateTestQuestion($data, $where);
     //  echo $this->db->last_query();die;
        $offset = $this->input->post('offset');
        $no_of_question = $this->session->userdata('no_of_question');
        $offset = ($offset + 1 < $no_of_question) ? $offset + 1 : $no_of_question - 1;
        $this->session->set_userdata('offset', $offset);
        $question = $this->OnlineExam->getTestQuestion($this->session->userdata('offset'), $this->input->post('id'));
         //echo $this->db->last_query();die;
        $this->get_question_view($question, $offset);
        die;
    }
     public function t($offset = 0, $question_id = 425) {
        $where = array('qms_ongoing_test.user_test_id' => 121);
        $question = $this->db->select('qms_questions.*')
            ->select('qms_ongoing_test.*')
            ->from('qms_questions')
            ->join('qms_ongoing_test', 'qms_questions.question_id = qms_ongoing_test.question_id')
            ->where($where)
            ->where('qms_ongoing_test.id >', $question_id)
            ->order_by('qms_ongoing_test.id','asc')
            ->limit(1, 0)
            ->get()->row();
      echo $this->db->last_query();die;
        if (!empty($question) && $question->question_status == 0) {
            $this->db->where(array('id' => $question->id));
            $this->db->update('qms_ongoing_test', array("question_status" => 2));
        }

        echo $question;
    }

  public function mark_for_review() {

        if (!$this->session->userdata('login')) {
            echo "<div class='alert alert-danger'>Please login first to start test</div>";
            die;
        }

        if ($this->input->post('selected_answer')) {
            $question_status = $this->input->post('mark_for_review') == "YES" ? "1" : "3";
        } else {
            $question_status = $this->input->post('mark_for_review') == "YES" ? "4" : "2";
        }

        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date('Y-m-d H:i:s', time());
        $where = array('id' => $this->input->post('id'));
        $data = array(
            'question_status' => $question_status,
            'selected_answer' => $this->input->post('selected_answer'),
            'updated_date_time' => $currentTime
        );

        $this->OnlineExam->updateTestQuestion($data, $where);

        $offset = $this->input->post('offset');
        $no_of_question = $this->session->userdata('no_of_question');
        $offset = ($offset + 1 < $no_of_question) ? $offset + 1 : $no_of_question - 1;
        $this->session->set_userdata('offset', $offset);

        $question = $this->OnlineExam->getTestQuestion($this->session->userdata('offset'), $this->input->post('id'));

        $this->get_question_view($question, $offset);
        die;
    }
    public function get_updated_question_status()
    {
        $questions = $this->OnlineExam->getAllQuestionStatus();
        if ($questions) {
            $im = 1;
            $data = [];
            foreach ($questions as $key => $value) {
                if ($value->question_status == 0) {
                    $data[$im] = "";
                    echo '<li id="qli-'.($im-1).'"><a href="#" onclick="change_question(' . $value->id . ', ' . ($im - 1) . ');">' . $im . '</a></li>';
                } else if ($value->question_status == 4) {
                    $data[$im] = "q-marked";
                    echo '<li id="qli-'.($im-1).'"><a href="#" class="q-marked" onclick="change_question(' . $value->id . ', ' . ($im - 1) . ');">' . $im . '</a></li>';
                } else if ($value->question_status == 2) {
                    $data[$im] = "q-orange";
                    echo '<li id="qli-'.($im-1).'"><a href="#" class="q-orange" onclick="change_question(' . $value->id . ', ' . ($im - 1) . ');">' . $im . '</a></li>';
                } else if ($value->question_status == 3) {
                    $data[$im] = "q-green";
                    echo '<li id="qli-'.($im-1).'"><a href="#" class="q-green" onclick="change_question(' . $value->id . ', ' . ($im - 1) . ');">' . $im . '</a></li>';
                } else if ($value->question_status == 1) {
                    $data[$im] = "ans-and-marked-li answered answered-purple-2 ansandmarked";
                    echo '<li id="qli-'.($im-1).'"><a href="#" class="ans-and-marked-li answered answered-purple-2 ansandmarked" style="background-position: -65px -176px !important;" onclick="change_question(' . $value->id . ', ' . ($im - 1) . ');">' . $im . '</a></li>';
                }

                $im++;
            }

            //echo json_encode($data);
        }
        die;
    }

    public function previous_question()
    {
       
       /* date_default_timezone_set('Asia/Kolkata');
        $currentTime = date('Y-m-d H:i:s', time());

        $data = array(
            'question_status' => ($this->input->post('selected_answer') ? "3" : "2"),
            'selected_answer' => $this->input->post('selected_answer'),
            'updated_date_time' => $currentTime
        );

        $where = array('id' => $this->input->post('id'));
        $this->OnlineExam->updateTestQuestion($data, $where);*/

        $offset = $this->input->post('offset');
        $offset = ($offset - 1 < 0) ? 0 : $offset - 1;
        $this->session->set_userdata('offset', $offset);

        $question = $this->OnlineExam->getPreviousQuestion($this->input->post('id'), $offset);

        $this->get_question_view($question, $offset);
        die;
    }

    public function question_by_id() {
        date_default_timezone_set('Asia/Kolkata');
        $currentTime = date('Y-m-d H:i:s', time());

        $data = array(
            'question_status' => ($this->input->post('selected_answer') ? "3" : "2"),
            'selected_answer' => $this->input->post('selected_answer'),
            'updated_date_time' => $currentTime
        );

        $where = array('id' => $this->input->post('id'));
        //$this->OnlineExam->updateTestQuestion($data, $where);

        $offset = $this->input->post('offset');
        $no_of_question = $this->session->userdata('no_of_question');
        $offset = ($offset < $no_of_question) ? $offset : $no_of_question - 1;
        $this->session->set_userdata('offset', $offset);

        $question = $this->OnlineExam->getQuestionById($this->input->post('next_question'));

        $this->get_question_view($question, $offset);
        die;
    }

    function get_question_status() {
        $test_id = $this->session->userdata('qms_user_test_id');

        if (!$test_id) {
            echo "Something went wrong, please try again later";
            die;
        }

        $questions = $this->OnlineExam->getAllQuestionStatus();
        if ($questions) {
            $not_visited = 0;
            $answered = 0;
            $not_answered = 0;
            $marked_for_review = 0;
            $answered_and_marked_for_review = 0;

            foreach ($questions as $question) {
                if ($question->question_status == 0) {
                    $not_visited++;
                } else if ($question->question_status == 1) {
                    $answered_and_marked_for_review++;
                } else if ($question->question_status == 2) {
                    $not_answered++;
                } else if ($question->question_status == 3) {
                    $answered++;
                } else if ($question->question_status == 4) {
                    $marked_for_review++;
                }
            }

            $data = array(
                'answered' => $answered,
                'not_answered' => $not_answered,
                'not_visited' => $not_visited,
                'marked_for_review' => $marked_for_review,
                'answered_and_marked_for_review' => $answered_and_marked_for_review
            );

            echo json_encode($data);
            die;
        }
    }

    public function get_question_view($question, $offset) {
        if ($question) {
            $this->session->set_userdata('current_question', $question->id);
             $str='';
               if($question->video_url)
                {
                    $url=base_url()."uploads/video/".$question->video_url;
                  $str.='<div class="white-popup mfp-hide" id="video"><video width="98%" height="100%" controls>
                          <source src="'.$url.'" type="video/mp4">
                        
                        Your browser does not support the video tag.
                        </video></div>';
                    $str.= '<a class="video-link" href="#video">Open Video</a><br>';
                }
               elseif($question->audio_url)
               {
                   $url=base_url()."uploads/audio/".$question->audio_url;
                  $str='<audio controls>
                               <source src="'.$url.'" type="audio/mpeg">
                            Your browser does not support the audio element.
                            </audio><br>';
               }
               elseif($question->image_url){
                   $url=base_url()."uploads/image/".$question->image_url;

                   $str= '<a class="image-link" href="'.$url.'">Open Image</a><br>';
               }
               $font='inherit';
               if($question->lang=='hi')
                 $font='k010';
            echo '<h4 style="margin-bottom: 10px;font-family:'.$font.'!important"><span class="quesnum">'.($offset + 1).' ) </span>' . $question->question . '</h4>'.$str.'
            <input  type="hidden" name="question_id" id="question_id" value="' . $question->id . '">
            <input  type="hidden" name="offset" id="offset" value="' . $offset. '">
             <form action="#" class="form-question">
           
                  <p>A)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_1" name="inlineRadioOptions" value="option_1" '. (($question->selected_answer == "option_1") ? "checked" : "" ).'/> &nbsp;&nbsp;' . $question->option_1 . '</p>
                 <p>B)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_2" name="inlineRadioOptions" value="option_2" '. (($question->selected_answer == "option_2") ? "checked" : "" ).'/> &nbsp;&nbsp;' . $question->option_2 . '</p>
                 <p>C)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_3" name="inlineRadioOptions" value="option_3" '. (($question->selected_answer == "option_3") ? "checked" : "" ).'/> &nbsp;&nbsp;' . $question->option_3 . '</p>
                 <p>D)&nbsp;&nbsp;&nbsp;<input type="radio" id="option_4" name="inlineRadioOptions" value="option_4" '. (($question->selected_answer == "option_4") ? "checked" : "" ).'/> &nbsp;&nbsp; ' . $question->option_4 . '</p>
               
            </form>';
        } else {
            echo '<div class="alert alert-warning" >Click On Any Jumping Numbering to See Your Question Paper !!</div>';
        }
    }

    public function submit_test()
    {
        if (!$this->session->userdata('login')) {
            echo "<div class='alert alert-danger'>Please login first</div>";
            die;
        }

        if (empty($this->session->userdata('qms_user_test_id'))) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Take a test first then try to submit.</div>");
            redirect(base_url());
        }

        $test_id = $this->session->userdata('qms_user_test_id');

        $this->OnlineExam->submitTest();

        $this->Result->prepareTestReport($test_id);

        $unset_test_session = array('duration',
            'max_attempts',
            'quiz_id',
            'no_of_question',
            'marks_per_question',
            'min_pas_percentage',
            'neg_marks_per_question',
            'quiz_title',
            'total_attempted',
            'qms_user_test_id',
            'offset',
            'current_question',
            'package_id',
            'no_of_attempt');
           
        $this->session->unset_userdata($unset_test_session);
        redirect('my-progress');
    }
}