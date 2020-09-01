<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 17/12/19
 * Time: 11:13 PM
 */

class Result extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    public function getAllResults() {
        $results = [];
        try {
            $results = $this->db->select('qms_results.*, qms_quiz.quiz_title as quiz_name, qu.name as student_name, qu.username')
                ->from('qms_results')
                ->join('qms_quiz', 'qms_results.quiz_id = qms_quiz.quiz_id')
                ->join('qms_users as qu', 'qms_results.user_id = qu.user_id')
                ->order_by('qms_results.net_percentage_obtained', 'DESC')
                ->get()->result();
        } catch (\Exception $exception) {

        }

        return $results;
    }



    // pdf processs

    public function getAllResult() {
        $results = [];
        try {
            $results = $this->db->select('qms_results.*, qms_quiz.quiz_title as quiz_name, qu.name as student_name, qu.username')
                ->from('qms_results')
                ->join('qms_quiz', 'qms_results.quiz_id = qms_quiz.quiz_id')
                ->join('qms_users as qu', 'qms_results.user_id = qu.user_id')
                ->limit(500)
                ->order_by('qms_results.net_percentage_obtained', 'DESC')
                ->get()->result();
        } catch (\Exception $exception) {

        }

        return $results;
    }

    public function getUserResult($user_id) {
        $results = [];
        try {
            $results = $this->db->select('qms_results.*, qms_quiz.quiz_title as quiz_name, qu.name as student_name, qu.username')
                ->from('qms_results')
                ->join('qms_quiz', 'qms_results.quiz_id = qms_quiz.quiz_id')
                ->join('qms_users as qu', 'qms_results.user_id = qu.user_id')
                ->where(array('qms_results.user_id' => $user_id, 'qu.user_id' => $user_id))
                ->order_by('qms_results.net_percentage_obtained', 'DESC')
                ->get()->result();
        } catch (\Exception $exception) {

        }

        return $results;
    }

    

    

    public function generateReport($quiz_id) {
        //TODO: Optimize this function and query
        try {
            $reports =   $this->db->select('qms_ongoing_test.*, qms_questions.*, qms_users.name, qms_user_test.*, min_pass_percentage, marks_per_question, negative_marks_per_question, qms_quiz.quiz_title')
                ->from('qms_ongoing_test')
                ->join('qms_user_test', 'qms_ongoing_test.user_test_id = qms_user_test.id')
                ->join('qms_questions','qms_ongoing_test.question_id = qms_questions.question_id', 'inner')
                ->join('qms_users', 'qms_user_test.user_id = qms_users.user_id')
                ->join('qms_quiz', 'qms_user_test.quiz_id = qms_quiz.quiz_id')
                ->where(array('qms_user_test.quiz_id'=> $quiz_id, 'qms_user_test.submitted' => 1, 'qms_quiz.quiz_id' => $quiz_id, 'qms_user_test.result_prepared' => 0))
                ->get()->result();

            $final_report = array();
            $right_answers = 0;
            $not_answered = 0;
            $wrong_answers = 0;
            $i = 0;

            if (empty($reports)) {
                return false;
            }

            foreach ($reports as $report) {
                $i++;
                $corr = json_decode($report->correct_option);
                $user_option = $report->selected_answer;
                $correct_option = "";
                if ($report->question_type == QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER) {
                    for ($j = 0; $j < count($corr); $j++) {
                        $temp_corr = $corr[$i];
                        if (empty($correct_option)) {
                            $correct_option = $report->{$temp_corr};
                        } else {
                            $correct_option = ", " . $report->{$temp_corr};
                        }
                    }
                } else if ($report->question_type == QuestionBank::MULTIPLE_CHOICE_SINGLE_ANSWER) {
                    $temp_corr = $corr[0];
                    $correct_option = $report->{$temp_corr};
                } else {
                    $correct_option = $corr[0];
                }

                if (empty($report->selected_answer)) {
                    $not_answered++;
                } else if (!empty($report->selected_answer) && $report->{$user_option} == $correct_option) {
                    $right_answers++;
                } else {
                    $wrong_answers++;
                }


                $total_marks_for_correct_answer = $right_answers * $report->marks_per_question;
                $total_negative_marks = $wrong_answers * $report->negative_marks_per_question;
                $total_marks_obtained = $total_marks_for_correct_answer - $total_negative_marks;
                $maximum_marks = $report->number_of_questions * $report->marks_per_question;
                $percentage_obtained = round((($total_marks_obtained / $maximum_marks) * 100), 2);
                $status = $percentage_obtained >= $report->min_pass_percentage ? 1 : 0 ;

                $final_report[$report->id]['test_id'] = $report->id;
                $final_report[$report->id]['user_id'] = $report->user_id;
                $final_report[$report->id]['quiz_id'] = $report->quiz_id;
                $final_report[$report->id]['quiz_name'] = $report->quiz_title;
                $final_report[$report->id]['no_of_attempts'] = $report->no_of_attempt;
                $final_report[$report->id]['status'] = $status;
                $final_report[$report->id]['net_marks_obtained'] = $total_marks_obtained;
                $final_report[$report->id]['net_percentage_obtained'] = $percentage_obtained;
                $final_report[$report->id]['created_date'] = date('Y-m-d H:i:s');
            }

            foreach ($final_report as $report) {
                $this->db->insert('qms_results', $report);

                if ($this->db->insert_id()) {
                    $this->db->where(array('id' => $report["test_id"]));
                    $this->db->update('qms_user_test', array("result_prepared" => 1));
                }
            }

            return true;

        } catch (\Exception $exception) {
            return false;
        }
    }

    public function prepareTestReport($test_id) {
        //TODO: Optimize this function and query
        try {
            $user_id = $this->session->userdata('user_id');
            $reports = $this->db->select('qms_ongoing_test.*, qms_questions.*, qms_users.name, qms_user_test.*, min_pass_percentage, marks_per_question, negative_marks_per_question, qms_quiz.quiz_title')
                ->from('qms_ongoing_test')
                ->join('qms_user_test', 'qms_ongoing_test.user_test_id = qms_user_test.id')
                ->join('qms_questions','qms_ongoing_test.question_id = qms_questions.question_id', 'inner')
                ->join('qms_users', 'qms_user_test.user_id = qms_users.user_id')
                ->join('qms_quiz', 'qms_user_test.quiz_id = qms_quiz.quiz_id')
                ->where(array('qms_user_test.id'=> $test_id, 'qms_user_test.submitted' => 1, 'qms_user_test.result_prepared' => 0, 'qms_user_test.user_id' => $user_id))
                ->get()->result();
//echo "<pre>";print_r($reports );die;
            $final_report = array();
            $right_answers = 0;
            $not_answered = 0;
            $wrong_answers = 0;
            $i = 0;

            // all question status
            $question_not_visited = 0;
            $question_not_answered = 0;
            $question_answered = 0;
            $question_answered_and_marked_for_review = 0;
            $question_not_answered_and_marked_for_review = 0;

            if (empty($reports)) {
                return false;
            }
//echo "<pre>";print_r($reports);die;
            foreach ($reports as $report) {
                
                $i++;
                $corr = json_decode($report->correct_option);
                if(!is_array($corr))
                  $corr=['option_'.$corr];
                $user_option = $report->selected_answer;
                $correct_option = "";
                if ($report->question_type == QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER) {
                    for ($j = 0; $j < count($corr); $j++) {
                        $temp_corr = $corr[$i];
                        if (empty($correct_option)) {
                            $correct_option = $report->{$temp_corr};
                        } else {
                            $correct_option = ", " . $report->{$temp_corr};
                        }
                    }
                } else if ($report->question_type == QuestionBank::MULTIPLE_CHOICE_SINGLE_ANSWER) {
                    $temp_corr = $corr[0];
                    $correct_option = $report->{$temp_corr};
                } else {
                    $correct_option = $corr[0];
                }

                if (empty($report->selected_answer)) {
                    $not_answered++;
                } else if (!empty($report->selected_answer) && $report->{$user_option} == $correct_option) {
                    $right_answers++;
                } else {
                    $wrong_answers++;
                }

                // all status count
                if ($report->question_status == OnlineExam::QUESTION_NOT_VISITED) {
                    $question_not_visited++;
                } else if ($report->question_status == OnlineExam::QUESTION_ANSWERED_AND_MARKED_FOR_REVIEW) {
                    $question_answered_and_marked_for_review++;
                } else if ($report->question_status == OnlineExam::QUESTION_NOT_ANSWERED) {
                    $question_not_answered++;
                } else if ($report->question_status == OnlineExam::QUESTION_NOT_ANSWERED_AND_MARKED_FOR_REVIEW) {
                    $question_not_answered_and_marked_for_review++;
                } else if ($report->question_status == OnlineExam::QUESTION_ANSWERED) {
                    $question_answered++;
                }
$report->negative_marks_per_question=$this->calculate_string($report->negative_marks_per_question);
                $total_marks_for_correct_answer = $right_answers * $report->marks_per_question;
                $total_negative_marks = $wrong_answers *( $report->negative_marks_per_question);
             //echo "negative perq-".$wrong_answers."<br>";
            // echo "total_negative_marks-".$total_negative_marks."<br>";
                $total_marks_obtained = $total_marks_for_correct_answer - $total_negative_marks;
          // echo "total_obtained-".$total_marks_obtained."<br>";die;
          
                $maximum_marks = $report->number_of_questions * $report->marks_per_question;
                $percentage_obtained = round((($total_marks_obtained / $maximum_marks) * 100), 2);
                $status = $percentage_obtained >= $report->min_pass_percentage ? 1 : 0 ;

                date_default_timezone_set('Asia/Kolkata');
                $time_spent = (strtotime($report->submitted_date_time) - strtotime($report->entry_date_time)); // in seconds

                $final_report['test_id'] = $report->id;
                $final_report['user_id'] = $report->user_id;
                $final_report['quiz_id'] = $report->quiz_id;
                $final_report['quiz_name'] = $report->quiz_title;
                $final_report['no_of_attempts'] = $report->no_of_attempt;
                $final_report['status'] = $status;
                $final_report['net_marks_obtained'] = $total_marks_obtained;
                $final_report['net_percentage_obtained'] = $percentage_obtained;
                $final_report['negative_marks_obtained'] =$total_negative_marks;
                $final_report['negative_percentage_obtained'] = round((($total_negative_marks / $maximum_marks) * 100), 2);
                $final_report['total_marks_obtained'] = $total_marks_for_correct_answer;
                $final_report['total_percentage_obtained'] = round((($total_marks_for_correct_answer / $maximum_marks) * 100), 2);
                $final_report['created_date'] = date('Y-m-d H:i:s');
                $final_report['time_spent'] = $time_spent;
                $final_report['answered'] = $question_answered;
                $final_report['answered_and_marked_for_review'] = $question_answered_and_marked_for_review;
                $final_report['not_answered'] = $question_not_answered;
                $final_report['not_answered_and_marked_for_review'] = $question_not_answered_and_marked_for_review;
                $final_report['not_visited'] = $question_not_visited;
                $final_report['correct'] = $right_answers;
                $final_report['wrong'] = $wrong_answers;
                $final_report['number_of_questions'] = $report->number_of_questions;
                $final_report['negative_marking'] = $report->negative_marks_per_question;
            }
//echo "<pre>";print_r($final_report);die;
            $this->db->insert('qms_results', $final_report);
            $result_id = $this->db->insert_id();

            if ($result_id) {
                $this->db->where(array("user_id" => $user_id, 'id' => $test_id));
                $this->db->update('qms_user_test', array("result_prepared" => 1));

                $this->prepareAnswerSheet($reports, $result_id);
            }

            return true;

        } catch (\Exception $exception) {
            return false;
        }
    }
  function calculate_string( $mathString )    {
        $mathString = trim($mathString);
        $mathString = str_replace ('[^0-9+-*/() ]', '', $mathString); 
        $compute = create_function("", "return (" . $mathString . ");" );
        return 0 + $compute();
    }
    public function prepareAnswerSheet($reports, $result_id) {
        $answer_sheet = array();
        $user_id = $this->session->userdata('user_id');
        foreach ($reports as $report) {
            $is_correct = 0;
            $temp_answer_sheet = array();
            $temp_answer_sheet["result_id"] = $result_id;
            $temp_answer_sheet["user_id"] = $user_id;
            $temp_answer_sheet["question_id"] = $report->question_id;
            $temp_answer_sheet["user_answer"] = $report->selected_answer;
            $temp_answer_sheet["status"] = $report->question_status;

            $corr = json_decode($report->correct_option);
            $user_option = $report->selected_answer;
            if ($report->question_type == QuestionBank::MULTIPLE_CHOICE_SINGLE_ANSWER) {
                $temp_corr = ($corr[0])?$corr[0]:'option_1';
                $correct_option = $report->{$temp_corr};
            } else {
                $correct_option = $corr[0];
            }
           if (!empty($report->selected_answer) && $report->{$user_option} == $correct_option) {
                $is_correct = 1;
            }

            $temp_answer_sheet["is_correct"] = $is_correct;
            array_push($answer_sheet, $temp_answer_sheet);
        }

        try {
            $this->db->insert_batch('qms_answer_sheet', $answer_sheet);
        } catch (\Exception $exception) {
            /*echo $exception->getMessage();
            die;*/
        }

    }

    public function getAnswerSheet($result_id) {
        $answer_sheet = [];
        try {
            if ($this->session->userdata("user_type") == 2) {
                $where = array("user_id" => $this->session->userdata("user_id"), "result_id" => $result_id);
            } else {
                $where = array("result_id" => $result_id);
            }

            $answer_sheet = $this->db->select("*, qms_questions.*")
                ->from("qms_answer_sheet")
                ->join('qms_questions', 'qms_answer_sheet.question_id = qms_questions.question_id')
                ->where($where)
                ->get()->result();
        } catch (\Exception $exception) {

        }
        return $answer_sheet;
    }

    public function getResult($result_id) {
        $result = [];
        try {
            if ($this->session->userdata("user_type") == 2) {
                $where = array("qms_results.user_id" => $this->session->userdata("user_id"), "id" => $result_id);
            } else {
                $where = array("id" => $result_id);
            }

            $result = $this->db->select("qms_results.*, username, name, email, dob, mobile, address, qms_quiz.pdf_paper_link, qms_quiz.common_merit_link, qms_quiz.cbt_practice_link, qms_quiz.question_explanation,qms_quiz.show_answersheet")
                ->from("qms_results")
                ->join("qms_users", "qms_results.user_id = qms_users.user_id")
                ->join("qms_quiz", "qms_results.quiz_id = qms_quiz.quiz_id")
                ->where($where)
                ->get()->row();
        } catch (\Exception $exception) {

        }

        return $result;
    }

    public function getMeritList($quiz_id) {
        $merit_list = [];
        try {
            $where = array("qms_results.quiz_id" => $quiz_id);
            $merit_list = $this->db->select("qms_results.*, username, name, qms_quiz.quiz_title")
                ->from("qms_results")
                ->join("qms_users", "qms_results.user_id = qms_users.user_id")
                ->join("qms_quiz", "qms_results.quiz_id = qms_quiz.quiz_id")
                ->where($where)
                ->order_by('qms_results.net_percentage_obtained', 'DESC')
                ->get()->result();
        } catch (\Exception $exception) {

        }

        return $merit_list;
    }

    public function deleteResult($id) {
        try {
            $this->db->trans_start();
            $this->db->delete('qms_results', array("id" => $id));
            $this->db->delete('qms_answer_sheet', array("result_id" => $id));
            $this->db->trans_complete();
            return true;
        } catch (\Exception $exception) {
            $this->session->set_flashdata('error', 'Unable to update quiz');
            return false;
        }
    }

}