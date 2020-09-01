<?php

/**

 * Created by PhpStorm.

 * User: amitpandey

 * Date: 28/11/19

 * Time: 11:37 PM

 */



class QuestionBank extends CI_Model

{

    function __construct() {

        parent::__construct();

    }



    const MULTIPLE_CHOICE_SINGLE_ANSWER = "0";

    const MULTIPLE_CHOICE_MULTIPLE_ANSWER = "1";

    // const MATCH_THE_COLUMN = "2";

    const SHORT_ANSWER = "3";

    const LONG_ANSWER = "4";



    const QUESTION_TYPE = [

        self::MULTIPLE_CHOICE_SINGLE_ANSWER => "Multiple Choice Single Answer",

        self::MULTIPLE_CHOICE_MULTIPLE_ANSWER => "Multiple Choice Multiple Answer",

        // self::MATCH_THE_COLUMN => "Match The Column",

        self::SHORT_ANSWER => "Short Answer",

        self::LONG_ANSWER => "Long Answer"

    ];

public function getQuestionCount()

    {

        

        $count = $this->db->query("SELECT COUNT(*) AS c FROM qms_questions")->row()->c;

        return $count;

    }

    public function getQuestions($quiz_id = 0) {
        $where = array('is_active' => 1);
        $questions = $this->db->select('qms_questions.*, qms_categories.category_name, qms_levels.level_name')
            ->from('qms_questions')
            ->join('qms_categories', 'qms_questions.category_id = qms_categories.id', 'left')
            ->join('qms_levels', 'qms_questions.level_id = qms_levels.id', 'left')
            ->where($where)
            ->order_by('question_id', 'DESC')
            // ->get_compiled_select();
            ->get()->result();
        return $questions;
    }

    public function getQuestionsMaster($question) {

        // echo $question;
        // exit();
        if($question){
            $where = array('is_active' => 1, 'question'=>$question);
        }
        else{
            $where = array('is_active' => 1);
        }
        $questions = $this->db->select('qms_questions.*, qms_categories.category_name, qms_levels.level_name')
            ->from('qms_questions')
            ->join('qms_categories', 'qms_questions.category_id = qms_categories.id', 'left')
            ->join('qms_levels', 'qms_questions.level_id = qms_levels.id', 'left')
            ->where($where)
            ->order_by('question_id', 'DESC')
            ->limit('500')
            // ->get_compiled_select();
            ->get()->result();
        return $questions;
    }



    public function addQuestion($input) {

        try {

            $this->db->insert('qms_questions', $input);

            $this->session->set_flashdata('msg', 'Question added successfully.');

        } catch (\Exception $e) {

            $this->session->set_flashdata('error', 'Something went wrong, please try again later');

        }



        return;

    }



    public function addBulkQuestion($input) {

        try {

            $this->db->insert_batch('qms_questions', $input);

            $this->session->set_flashdata('msg', 'Questions added successfully.');

        } catch (\Exception $e) {

            $this->session->set_flashdata('error', 'Something went wrong, please try again later');

        }



        return;

    }



    public function getQuestionById($question_id) {

        $questions = [];

        try {

            $questions = $this->db->select('qms_questions.*')

                ->from('qms_questions')

                ->where(array("question_id" => $question_id))

                ->order_by('question_id', 'DESC')

                // ->get_compiled_select();

                ->get()->row();

        } catch (\Exception $e) {



        }



        return $questions;

    }



    public function updateQuestion($where) {

        try {

            $this->db->where($where);

            $this->db->update('qms_questions',['is_active'=>0]);

             $this->db->where($where);

            $this->db->delete('quiz_question');

            $this->session->set_flashdata('msg', 'Question updated successfully.');

        } catch (\Exception $e) {

            $this->session->set_flashdata('error', 'Something went wrong, please try again later');

        }



        return;

    }



    public function getQuizQuestions($quiz_id) {

        $questions = [];

        try {

            $where = array('is_active' => 1, 'quiz_question.quiz_id' => $quiz_id);

            $questions = $this->db->select('qms_questions.*, qms_categories.category_name, qms_levels.level_name')

                ->from('qms_questions')

                ->join('qms_categories', 'qms_questions.category_id = qms_categories.id', 'left')

                ->join('qms_levels', 'qms_questions.level_id = qms_levels.id', 'left')

                ->join('quiz_question', 'qms_questions.question_id = quiz_question.question_id', 'inner')

                ->where($where)

                ->get()->result();

        } catch (\Exception $exception) {



        }



        return $questions;

    }

}