<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 02/12/19
 * Time: 11:35 PM
 */

class Quiz extends CI_Model
{

    function __construct() {
        parent::__construct();
    }
   
    public function getAllQuizes($by_status = '', $from_date = '', $to_date = '', $start_time = '', $end_time = '') {
        try {
            $query = $this->db->select('qq.*, (SELECT COUNT(*) FROM quiz_question WHERE quiz_question.quiz_id = qq.quiz_id) AS number_of_questions')
                ->from('qms_quiz AS qq')
                ->where('qq.is_active', 1);

            if(!empty($by_status)) {
                if($by_status == 'o') {
                    $query = $query->where('active_to >=', date('Y-m-d'));
                } else {
                    $query = $query->where('active_to <', date('Y-m-d'));
                }
            }

            if(!empty($from_date)) {
                $query = $query->where('active_from >=', date('Y-m-d', strtotime($from_date)));
            }

            if(!empty($to_date)) {
                $query = $query->where('active_to <=', date('Y-m-d', strtotime($to_date)));
            }

            $query = $query->order_by('quiz_id', 'DESC')->get();
            return $query->result();
        } catch (\Exception $exception) {
            return [];
        }
    }

    public function addQuiz($data) {
        try {
            $this->db->insert('qms_quiz', $data);
            $this->session->set_flashdata('msg', 'Quiz added successfully');
            return $this->db->insert_id();
        } catch (\Exception $exception) {
            $this->session->set_flashdata('error', 'Unable to add quiz, please try again later');
            return;
        }
    }

    public function addQuizPackage($input) {
        try {
            $this->db->insert_batch('quiz_package', $input);
            $this->session->set_flashdata('msg', 'Quiz added successfully');
        } catch (\Exception $exception) {
            $this->session->set_flashdata('error', 'Unable to add quiz');
            return;
        }
    }

    public function getQuizById($quiz_id) {
        $query = $this->db->select('*, (SELECT GROUP_CONCAT(package_id) FROM quiz_package WHERE qms_quiz.quiz_id = quiz_package.quiz_id) as quiz_packages')
            ->from('qms_quiz')
            ->where( array('qms_quiz.quiz_id' => $quiz_id, 'is_active' => 1))
            ->get()->row();
        return $query;
    }

    public function updateQuiz($input, $where) {
        try {
            $this->db->where($where);
            $this->db->update('qms_quiz', $input);
        
            $this->session->set_flashdata('msg', 'Quiz updated successfully.');
        } catch (\Exception $e) {
            $this->session->set_flashdata('error', 'Something went wrong, please try again later');
        }

        return;
    }

    public function updateQuizPackage($input, $quiz_id) {
        try {
            $this->db->delete('quiz_package', array("quiz_id" => $quiz_id));
            $this->db->insert_batch('quiz_package', $input);
            $this->session->set_flashdata('msg', 'Quiz updated successfully');
        } catch (\Exception $exception) {
            $this->session->set_flashdata('error', 'Unable to update quiz');
            return;
        }
    }

    // get all quiz questions
    public function getQuizQuestionsId($quiz_id) {
        $results = $this->db->select('question_id')
            ->where(array("quiz_id" => $quiz_id))
            ->from('quiz_question')->get()->result();
        $question_ids = array_column($results, 'question_id');
        return $question_ids;
    }

    public function addQuestionToThisQuiz($input) {
        try {
            $this->db->insert('quiz_question', $input);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function removeQuizQuestion($input) {
        try {
            $this->db->delete('quiz_question', array("quiz_id" => $input["quiz_id"], "question_id" => $input["question_id"]));
            // ->where(array("quiz_id" => $input["quiz_id"], "question_id" => $input["question_id"]));
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

   public function getPackageQuiz($package_id, $user_id,$is_free=false) {
    $quiz = [];

        try {
            $quiz = $this->db->select('*, (SELECT COUNT(*) FROM quiz_question WHERE quiz_question.quiz_id = qms_quiz.quiz_id) AS number_of_questions')
                ->from('qms_quiz')
                ->join('quiz_package', 'qms_quiz.quiz_id = quiz_package.quiz_id')
                ->where('quiz_package.package_id',$package_id);
             if(!$is_free)
             {
                 $quiz = $this->db->join('user_package', 'quiz_package.package_id = user_package.package_id')->where('user_package.package_id',$package_id)->where('user_package.user_id' ,$user_id);
             }
             $quiz =$this->db->group_by("qms_quiz.quiz_id")
                ->get()->result();
         //echo $this->db->last_query();die;
             }
        catch (\Exception $exception) {

        }

        return $quiz;
    }

    //*****************************

    //quiz draft answer
    public function add_temp_quiz_answer($data) {
        $del_query = "DELETE FROM `tmp_qms_answer_details` WHERE answer_id = (SELECT answer_id FROM tmp_qms_answer WHERE user_id = ". $data['user_id'] ." AND quiz_id = ". $data['quiz_id'] .")";
        $this->db->query($del_query);
        $this->db->delete('tmp_qms_answer', $data);

        $this->db->insert('tmp_qms_answer', $data);
        return $this->db->insert_id();
    }

    public function add_temp_quiz_answer_details($data) {
        $this->db->insert_batch('tmp_qms_answer_details', $data);
    }

    public function get_temp_user_quiz_answer($user_id, $quiz_id) {
        $query = $this->db->select('*')
            ->from('tmp_qms_answer')
            ->join('tmp_qms_answer_details', 'tmp_qms_answer.answer_id = tmp_qms_answer_details.answer_id', 'left')
            ->where( array('tmp_qms_answer.user_id' => $user_id, 'tmp_qms_answer.quiz_id' => $quiz_id) )
            ->get();
        return $query->result();
    }

    //quiz answer
    public function add_quiz_answer($data) {
        $del_query = "DELETE FROM `tmp_qms_answer_details` WHERE answer_id = (SELECT answer_id FROM tmp_qms_answer WHERE user_id = ". $data['user_id'] ." AND quiz_id = ". $data['quiz_id'] .")";
        $this->db->query($del_query);
        $this->db->delete('tmp_qms_answer', $data);

        $this->db->insert('qms_answer', $data);
        return $this->db->insert_id();
    }

    public function add_quiz_answer_details($data) {
        $this->db->insert_batch('qms_answer_details', $data);
    }

    public function get_user_quiz_answer($quiz, $user_id) {
        $query = $this->db->select('*')
            ->from('qms_answer')
            ->join('qms_answer_details', 'qms_answer.answer_id = qms_answer_details.answer_id', 'left')
            ->where( array('qms_answer.user_id' => $user_id, 'qms_answer.quiz_id' => $quiz) )
            ->get();
        //echo $this->db->last_query(); die;
        return $query->result();
    }

    public function get_user_quiz_answer_details($quiz_answer_id) {
        $query = $this->db->select('qms_questions.question, qms_questions.option_1, qms_questions.option_2, qms_questions.option_3, qms_questions.option_4, qms_questions.correct_option, qms_answer_details.user_answer, qms_answer_details.is_correct')
            ->from('qms_answer')
            ->join('qms_answer_details', 'qms_answer.answer_id = qms_answer_details.answer_id', 'inner')
            ->join('qms_questions', 'qms_answer_details.question_id = qms_questions.question_id', 'inner')
            ->where( array('md5(qms_answer.answer_id)' => $quiz_answer_id) )
            ->get();
        return $query->result();
    }

    //quiz package
    public function get_all_package() {
        $query = $this->db->select('*')
            ->from('qms_packages')
            ->where(array('is_active' => 1))
            ->order_by('package_id', 'DESC')
            ->get();
        return $query->result();
    }


    public function get_allselected_package($get_id) {
        $query = $this->db->select('*')
            ->from('userpackage')
            ->where(array('status' => 1,'user' => $get_id))
            ->order_by('id', 'DESC')
            ->get();
        return $query->result();
    }
    public function add_package($data) {
        $this->db->insert('qms_packages', $data);
        return $this->db->insert_id();
    }

    public function get_package_details($pid) {
        $query = $this->db->select('*')
            ->from('qms_packages')
            ->where(array('package_id' => $pid))
            ->get();
        return $query->result();
    }

    public function update_package($where_ar, $data) {
        $this->db->where($where_ar);
        $this->db->update('qms_packages', $data);
    }

    //quiz functions
    public function get_active_quiz() {
        $query = $this->db->select('*')
            ->from('qms_quiz')
            ->order_by('quiz_id', 'DESC')
            ->limit(1)
            ->get();
        return $query->result();
    }

    public function get_quiz_questions_for_user($quiz_id) {
        $query = $this->db->select('*')
            ->from('qms_questions')
            ->where( array('is_active' => 1, 'md5(quiz_id)' => $quiz_id) )
            ->order_by('question_id', 'DESC')
            ->get();
        return $query->result();
    }

    public function update_quiz($where_ar, $data) {
        $this->db->where($where_ar);
        $this->db->update('qms_quiz', $data);
    }

    //quiz question functions
    public function add_quiz_question($data) {
        $this->db->insert('qms_questions', $data);
        return $this->db->insert_id();
    }

    public function update_quiz_question($where_ar, $data) {
        $this->db->where($where_ar);
        $this->db->update('qms_questions', $data);
    }

    public function get_quiz_questions($quiz_id) {
        $query = $this->db->select('*')
            ->from('qms_questions')
            ->where( array('is_active' => 1, 'quiz_id' => $quiz_id) )
            ->order_by('question_id', 'DESC')
            ->get();
        return $query->result();
    }

    public function get_quiz_question($question_id, $quiz_id) {
        $query = $this->db->select('*')
            ->from('qms_questions')
            ->where( array('question_id' => $question_id, 'quiz_id' => $quiz_id) )
            ->get();
        return $query->result();
    }

    public function get_quiz_report($quiz_id = 0, $from_date = '', $to_date = '')
    {
        if($quiz_id == 0) {
            $latest_quiz = $this->db->query("SELECT quiz_id FROM qms_quiz ORDER BY quiz_id DESC LIMIT 1");
            $latest_quiz = $latest_quiz->row();
            $quiz_id = $latest_quiz->quiz_id;
        }

        $cond = '';
        if(!empty($from_date)) {
            $from_date = date('Y-m-d', strtotime($from_date));
            $cond .= " AND qms_answer.submit_date >= '$from_date'";
        }
        if(!empty($to_date)) {
            $to_date = date('Y-m-d', strtotime($to_date . ' +1 day'));
            $cond .= " AND qms_answer.submit_date <= '$to_date'";
        }

        $query = "SELECT qms_users.user_id, '$quiz_id' AS quiz_id, qms_users.name, qms_users.branch_location, qms_users.zone, qms_answer.submit_date AS submission_date,
                  ( SELECT COUNT(*) AS total_attempt FROM qms_answer
                    INNER JOIN qms_answer_details ON qms_answer.answer_id = qms_answer_details.answer_id
                    WHERE qms_answer.user_id = qms_users.user_id AND qms_answer.quiz_id = $quiz_id
                  ) AS total_attempt,
                  ( SELECT COUNT(*) AS correct_ans FROM qms_answer
                    INNER JOIN qms_answer_details ON qms_answer.answer_id = qms_answer_details.answer_id
                    WHERE qms_answer_details.is_correct = 1 AND qms_answer.user_id = qms_users.user_id AND qms_answer.quiz_id = $quiz_id
                  ) AS correct_ans,
                  (SELECT COUNT(*) AS tot_question FROM qms_questions WHERE is_active = 1 AND quiz_id = $quiz_id) AS tot_question,
                  (SELECT marks_per_question FROM qms_quiz WHERE quiz_id = $quiz_id) AS marks_per_question,
                  (SELECT quiz_title FROM qms_quiz WHERE quiz_id = $quiz_id) AS quiz_title
                  FROM qms_answer
                  INNER JOIN qms_users ON qms_answer.user_id = qms_users.user_id
                  WHERE qms_answer.quiz_id = $quiz_id $cond GROUP BY qms_users.user_id ORDER BY qms_users.name ASC";
        $res = $this->db->query($query);
        return $res->result_array();
    }

    public function get_quiz_report_details($quiz_id, $user_id)
    {
        $query = "SELECT qms_questions.*,qms_answer_details.* FROM qms_answer
                  INNER JOIN qms_answer_details ON qms_answer.answer_id = qms_answer_details.answer_id
                  INNER JOIN qms_questions ON qms_answer_details.question_id = qms_questions.question_id
                  WHERE qms_questions.quiz_id = $quiz_id AND qms_answer.user_id = $user_id";
        $res = $this->db->query($query);
        return $res->result_array();
    }

    public function add_bulk_question($data) {
        $this->db->insert_batch('qms_questions', $data);
    }

}