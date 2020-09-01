<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 24/12/19
 * Time: 5:45 AM
 */

class OnlineExam extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    const QUESTION_NOT_VISITED = 0;
    const QUESTION_ANSWERED_AND_MARKED_FOR_REVIEW = 1;
    const QUESTION_NOT_ANSWERED = 2;
    const QUESTION_ANSWERED = 3;
    const QUESTION_NOT_ANSWERED_AND_MARKED_FOR_REVIEW = 4;

    const QUESTION_STATUS = [
        self::QUESTION_NOT_VISITED,
        self::QUESTION_ANSWERED_AND_MARKED_FOR_REVIEW,
        self::QUESTION_NOT_ANSWERED,
        self::QUESTION_ANSWERED,
        self::QUESTION_NOT_ANSWERED_AND_MARKED_FOR_REVIEW
    ];

    public function getQuizData($package_id, $quiz_id) {
        $quiz_detail = [];
        $is_free=$this->db->get_where('qms_packages',['package_id'=>$package_id])->row()->package_type;
        try {
            $user_id = $this->session->userdata('user_id');
            $quiz_detail = $this->db->select('*, (SELECT COUNT(*) FROM quiz_question WHERE quiz_question.quiz_id = qms_quiz.quiz_id) AS number_of_questions')
                ->from('qms_quiz')
                ->join('quiz_package', 'qms_quiz.quiz_id = quiz_package.quiz_id');
                
            if(!$is_free)
            {
             $quiz_detail=$this->db->join('user_package', 'quiz_package.package_id = user_package.package_id')->where(array('user_package.user_id' => $user_id, 'user_package.package_id' => $package_id)); 
             }
             $quiz_detail=$this->db ->where(array('qms_quiz.quiz_id' => $quiz_id));
            
               $quiz_detail=$this->db ->get()->row();
        } catch (\Exception $exception) {

        }

        return $quiz_detail;
    }

    public function getAttemptsLeft($quiz_id) {
        $quiz_attempts = [];
        try {
            $user_id = $this->session->userdata('user_id');
            $quiz_attempts = $this->db->select("COUNT(quiz_id) as total_attempts, MAX(no_of_attempts) as max_number_of_attempts")
                ->from('qms_results')
                ->where(array("qms_results.quiz_id" => $quiz_id, "qms_results.user_id" => $user_id))
                ->get()->row();

            //$total_attempted = (!empty($quiz->number_of_attempt) ? $quiz->number_of_attempt : 0);
        } catch (\Exception $exception) {

        }

        return $quiz_attempts;
    }

    public function startTest($data) {
        try {
            $this->db->insert('qms_user_test', $data);
            return $this->db->insert_id();
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function addTestQuestions($input) {
        try {
            $this->db->insert_batch("qms_ongoing_test", $input);
        } catch (\Exception $exception) {

        }
    }

    public function getQuizStartedTime() {
        $where = array("id" => $this->session->userdata('qms_user_test_id'));
        $test_time = $this->db->select("entry_date_time, duration")
            ->from("qms_user_test")
            ->where($where)
            ->get()->row();
        date_default_timezone_set('Asia/Kolkata');
        $current_time = date('Y-m-d H:i:s', time());
        $current_time = strtotime($current_time);
        $started_time = strtotime($test_time->entry_date_time);
        // $time_left = $test_time->duration;
        $time_spent = $current_time - $started_time;
        return $time_spent;

    }

    public function getTestQuestion($offset = 0, $question_id = 0) {
        $where = array('qms_ongoing_test.user_test_id' => $this->session->userdata('qms_user_test_id'));
        $question = $this->db->select('qms_questions.*')
            ->select('qms_ongoing_test.*')
            ->from('qms_questions')
            ->join('qms_ongoing_test', 'qms_questions.question_id = qms_ongoing_test.question_id')
            ->where($where)
            ->where('qms_ongoing_test.id >', $question_id)
            ->order_by('qms_ongoing_test.id','asc')
            ->limit(1, 0)
            ->get()->row();
//echo $this->db->last_query();die;
        if (!empty($question) && $question->question_status == 0) {
            $this->db->where(array('id' => $question->id));
            $this->db->update('qms_ongoing_test', array("question_status" => 2));
        }
        
        return $question;
    }

    public function getAllQuestionStatus() {
        $where = array('qms_ongoing_test.user_test_id' => $this->session->userdata('qms_user_test_id'));
        $query = $this->db->select('qms_ongoing_test.*')
            ->from('qms_ongoing_test')
            ->where($where)
            ->order_by('qms_ongoing_test.id','asc')
            ->get();
        return $query->result();
    }

    public function updateTestQuestion($input, $where) {
        try {
            $current_question = $this->db->select("selected_answer, question_status")
                ->from("qms_ongoing_test")
                ->where($where)
                ->get()->row();

            if (empty($current_question)) {
                return;
            }

            $this->db->where($where);
            $this->db->update("qms_ongoing_test", $input);

        } catch (\Exception $exception) {

        }
    }

    public function getPreviousQuestion($question_id, $offset) {
        $where = array('qms_ongoing_test.user_test_id'=>$this->session->userdata('qms_user_test_id'),);
        $question = $this->db->select('qms_questions.*')
            ->select('qms_ongoing_test.*')
            ->from('qms_questions')
            ->join('qms_ongoing_test', 'qms_questions.question_id = qms_ongoing_test.question_id')
            ->where($where)
            ->where('qms_ongoing_test.id <', $question_id)
            ->order_by('qms_ongoing_test.id','asc')
            ->limit(1, $offset)
            ->get()->row();

        if (!empty($question) && $question->question_status == 0) {
            $this->db->where(array('id' => $question->id));
            $this->db->update('qms_ongoing_test', array("question_status" => 2));
        }

        return $question;
    }

    public function getQuestionById($question_id) {
        $where = array('qms_ongoing_test.user_test_id' => $this->session->userdata('qms_user_test_id'), 'qms_ongoing_test.id' => $question_id);
        $question = $this->db->select('qms_questions.*')
            ->select('qms_ongoing_test.*')
            ->from('qms_questions')
            ->join('qms_ongoing_test', 'qms_questions.question_id = qms_ongoing_test.question_id')
            ->where($where)
            ->order_by('qms_ongoing_test.id','asc')
            //->limit(1, $offset)
            ->get()->row();

        if (!empty($question) && $question->question_status == 0) {
            $this->db->where(array('id' => $question->id));
            $this->db->update('qms_ongoing_test', array("question_status" => 2));
        }

        return $question;
    }

    public function submitTest() {
        $where = array('id' => $this->session->userdata('qms_user_test_id'));
        date_default_timezone_set('Asia/Kolkata');
        $submitted_date_time = date('Y-m-d H:i:s', time());
        $this->db->where($where);
        $this->db->update("qms_user_test", array("submitted" => 1, "submitted_date_time" => $submitted_date_time));
    }

}