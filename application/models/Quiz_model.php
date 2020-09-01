<?php

class Quiz_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
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
                        ->from('user_package')
                        ->where(array('status' => 1,'user_id' => $get_id))
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

    public function add_quiz($data) {
        $this->db->insert('qms_quiz', $data);
        return $this->db->insert_id();
    }

    public function update_quiz($where_ar, $data) {
        $this->db->where($where_ar);
        $this->db->update('qms_quiz', $data);
    }

    public function get_all_quiz($by_status = '', $from_date = '', $to_date = '') {
    	$query = $this->db->select('qq.*, (SELECT GROUP_CONCAT(package_name) FROM qms_packages WHERE FIND_IN_SET (package_id, qq.quiz_packages)) AS packages')
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
    }

    public function get_quiz($quiz_id) {
        $query = $this->db->select('*')
                          ->from('qms_quiz')
                          ->where( array('quiz_id' => $quiz_id))
                          ->get();
        return $query->result();
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
    
    public function get_last_month_topper() {
        $month = date('m', strtotime('-1 months'));
        $year = date('Y', strtotime('-1 months'));
        $month = 05;
        $query = "SELECT qms_answer.answer_id, qms_users.name, qms_users.zone,
                  (SELECT COUNT(answer_detail_id) AS correct_count FROM qms_answer_details WHERE is_correct = 1 AND answer_id = qms_answer.answer_id) AS correct_count
                  FROM qms_answer
                  INNER JOIN qms_answer_details ON qms_answer.answer_id = qms_answer_details.answer_id
                  INNER JOIN qms_users ON qms_answer.user_id = qms_users.user_id WHERE MONTH(qms_answer.submit_date) = '$month' AND YEAR(qms_answer.submit_date) = '$year'
                  GROUP BY qms_answer.answer_id ORDER BY correct_count DESC LIMIT 10";
        $res = $this->db->query($query);
        return $res->result_array();
    }

}