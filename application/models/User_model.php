<?php

class User_model extends CI_Model {



    function __construct() {

        parent::__construct();

    }



    public function exist_username($username) {

        $query = $this->db->select('*')

        ->from('qms_users')

        ->where( array('username' => $username) )

        ->get();



        return $query->result();

    }



    public function loginusername($username) {

        $query = $this->db->select('*')

        ->from('qms_users')

        ->where( array('user_id' => $username) )

        ->get();



        return $query->result();

    }



    public function getLoginUserData($where) {

        $query = $this->db->select('*')

        ->from('qms_users')

        ->where($where)

        ->get();

        return $query->row();

    }

    //skv
    



    public function updateUser($input, $where) {

        try {

            $this->db->where($where);

            $this->db->update("qms_users", $input);

            $this->session->set_flashdata('msg', "<div class='alert alert-success'>Your profile updated successfully</div>");

        } catch (\Exception $exception) {

            $this->session->set_flashdata('msg', "<div class='alert alert-danger'>Unable to update profile, please try again later</div>");

        }



        return ;

    }



    public function matchCurrentPassword($user_id, $password) {

        try {

            $password = md5($password);

            $result = $this->db->select('*')

            ->from('qms_users')

            ->where( array('user_id' => $user_id, 'password' => $password))

            ->get()->row();



            $match = !empty($result) ? true : false;

        } catch (\Exception $exception) {

            $match = false;

        }



        return $match;

    }



    public function getdata($where) {

        $query = $this->db->select('qms_users.*')

        ->select('user_package.*')

        ->select('qms_packages.*')

        ->from('qms_users')

        ->join('user_package', 'qms_users.user_id = user_package.user_id')

        ->join('qms_packages', 'user_package.package_id = qms_packages.package_id')

        ->where($where)

        ->get();

        return $query->result();

    }



    public function getbackquestiontodisplay($con1) {

        $con=array('qms_test_details.testuniqueid'=>$this->session->userdata('testid'),);

        $query = $this->db->select('qms_questions.*')

        ->select('qms_test_details.*')

        ->from('qms_questions')

        ->join('qms_test_details', 'qms_questions.question_id = qms_test_details.questionid')

        ->where($con )

        ->where('qms_test_details.id <', $con1)

        ->order_by('qms_test_details.id','asc')

        ->limit('1','0')

        ->get();

        return $query->result();

    }



    public function getquestiontodisplay() {

        $con = array('qms_test_details.testuniqueid' => $this->session->userdata('testid'),'qms_test_details.questionattendent'=>'0');

        $query = $this->db->select('qms_questions.*')

        ->select('qms_test_details.*')

        ->from('qms_questions')

        ->join('qms_test_details', 'qms_questions.question_id = qms_test_details.questionid')

        ->where($con )

        ->order_by('qms_test_details.id','asc')

        ->limit('1','0')

        ->get();

        return $query->result();

    }





    public function getquestionnumber($con1) {

        $con=array('testuniqueid'=>$this->session->userdata('testid'),);

        $query = $this->db->select('*')

        ->from('qms_test_details')

        ->where($con )



        ->where('id <=', $con1)

        ->order_by('id','asc')



        ->get();

        return  $query->num_rows();

        // return $query->result();

    }



    public function getquestiontodisplayques($con1) {

        $con=array('qms_test_details.testuniqueid'=>$this->session->userdata('testid'),);

        $query = $this->db->select('qms_questions.*')

        ->select('qms_test_details.*')

        ->from('qms_questions')

        ->join('qms_test_details', 'qms_questions.question_id = qms_test_details.questionid')

        ->where($con )

        ->where($con1 )



        ->order_by('qms_test_details.id','asc')

        ->limit('1','0')

        ->get();

        return $query->result();

    }



    public function getallquestiontodisplay() {

        $con=array('qms_ongoing_test.user_test_id'=>$this->session->userdata('qms_user_test_id'),);

        $query = $this->db->select('qms_questions.*')

        ->select('qms_ongoing_test.*')

        ->from('qms_questions')

        ->join('qms_ongoing_test', 'qms_questions.question_id = qms_ongoing_test.question_id')

        ->where($con )

        ->order_by('qms_ongoing_test.id','asc')

        ->get();

        return $query->result();

    }



    public function getquiz($id) {



        /*$query = $this->db->select('*, (SELECT COUNT(*) FROM quiz_question WHERE quiz_question.quiz_id = qms_quiz.quiz_id) AS number_of_questions')

        ->from('qms_quiz')*/



        $query = $this->db->select('qms_quiz.*, qms_questions.*, (SELECT COUNT(*) FROM quiz_question WHERE quiz_question.quiz_id = qms_quiz.quiz_id) AS number_of_questions')

        ->from('qms_quiz')

        ->join('quiz_question as qqa', 'qms_quiz.quiz_id = qqa.quiz_id')

        ->join('qms_questions', 'qqa.question_id = qms_questions.question_id')

            // ->where("quiz_packages = '$id'  OR quiz_packages LIKE '$id,%'  OR quiz_packages LIKE '%,$id,%'  OR quiz_packages LIKE '%,$id'")

        ->where("FIND_IN_SET ($id, quiz_packages)")

        ->order_by('rand()')

        ->get();

        return $query->result();

    }



    public function getquiznumberq($quiz_id) {

        $query = $this->db->select('qms_quiz.*, qms_questions.*, (SELECT COUNT(*) FROM quiz_question WHERE quiz_question.quiz_id = qms_quiz.quiz_id) AS number_of_questions')

        ->from('qms_quiz')

        ->join('quiz_question as qq', 'qq.quiz_id = qms_quiz.quiz_id')

        ->join('qms_questions', 'qq.question_id = qms_questions.question_id')

        ->where('qq.quiz_id ', $quiz_id)

            //->where("quiz_packages = '$con'  OR quiz_packages LIKE '$con,%'  OR quiz_packages LIKE '%,$con,%'  OR quiz_packages LIKE '%,$con'")

        ->order_by('rand()')

        ->get();

        return $query->result();

    }

    public function getquiznumberques($quiz_id) {

        $query = $this->db->select('qms_quiz.*, qms_questions.*')

        ->from('qms_quiz')

        ->join('quiz_question as qq', 'qq.quiz_id = qms_quiz.quiz_id')

        ->join('qms_questions', 'qq.question_id = qms_questions.question_id')

        ->where('qq.quiz_id ', $quiz_id)

            //->where("quiz_packages = '$con'  OR quiz_packages LIKE '$con,%'  OR quiz_packages LIKE '%,$con,%'  OR quiz_packages LIKE '%,$con'")

        ->order_by('rand()')

        ->get();

        return $query->num_rows();

    }



    public function getquizstarttest($con) {

        $query = $this->db->select('qms_quiz.*')

        ->select('qms_questions.*')

        ->from('qms_quiz')

        ->join('qms_questions', 'qms_quiz.quiz_id = qms_questions.quiz_id')

        ->where('qms_quiz.quiz_id',$con )

            // ->where("quiz_packages = '$con'  OR quiz_packages LIKE '$con,%'  OR quiz_packages LIKE '%,$con,%'  OR quiz_packages LIKE '%,$con'")

        ->order_by('rand()')

        ->get();



        return $query->result();

    }



    public function getquizlistformypackage($id) {

        $query = $this->db->select('*, (SELECT COUNT(*) FROM quiz_question WHERE quiz_question.quiz_id = qms_quiz.quiz_id) AS number_of_questions')

        ->from('qms_quiz')

        ->where("FIND_IN_SET ($id, quiz_packages)")

            // ->where("quiz_packages = '$id'  OR quiz_packages LIKE '$id,%'  OR quiz_packages LIKE '%,$id,%'  OR quiz_packages LIKE '%,$id'")

        ->group_by("qms_quiz.quiz_id")

        ->get();



        return $query->result();



    }



    public function loginusernamejoin($username) {

        $query = $this->db->select('*')

        ->from('qms_users')

        ->where( array('user_id' => $username) )

        ->get();



        return $query->result();

    }



    # check user by email

    public function checkUserByEmail($email)

    {

        $this->db->where('email',$email);

        $query = $this->db->get('qms_users');

        if($query->num_rows() > 0)

            return false;

        else

            return true;

    }

    public function create_otp($sent_to) {

        $otp = mt_rand(100000, 999999);

        $this->db->insert('users_otp', array('sent_on' => $sent_to, 'otp_number' => $otp));

        return $otp;

    }



    public function check_otp($sent_to, $otp) {

        $query = $this->db->select('*')

        ->from('users_otp')

        ->where( array('sent_on' => $sent_to, 'otp_number' => $otp) )

        ->order_by('otp_id', 'DESC')

        ->limit(1)

        ->get();

        return $query->result();

    }



    public function checkuser($sent_to, $otp) {

        $query = $this->db->select('*')

        ->from('users_otp')

        ->where( array('sent_on' => $sent_to, 'otp_number' => $otp) )

        ->order_by('otp_id', 'DESC')

        ->limit(1)

        ->get();

        return $query->result();

    }


    public function update_otp($where_ar, $data) {
        $this->db->where($where_ar);
        $this->db->update('users_otp', $data);
    }

    //////////////////////////////////////////////////admin functions///////////////////////
    public function validate_user($username, $password) {
        $password = md5($password);
        $query = $this->db->select('*')
        ->from('qms_users')
        ->where( array('username' => $username, 'password' => $password))
        ->get();
        return $query->row();
    }

    public function add_user($data) {
        $this->db->insert('qms_users', $data);
        return $this->db->insert_id();
    }

    public function add_user_package($data) {
        $this->db->insert('user_package', $data);
        return $this->db->insert_id();
    }

    public function add_data($table,$data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update_user($where_ar, $data) {
        $this->db->where($where_ar);
        $this->db->update('qms_users', $data);
    }

    public function selectdatajoin($table,$filed,$con) {
        $query =   $this->db->select('user_package.*')
        ->select('qms_packages.*')
        ->from($table)
        ->join('qms_packages', $table.'.package = qms_packages.package_id', 'inner')
        ->where($con)
        ->get();
        return $query->result();
    }

    public function get_temp_user_quiz_answer($user_id, $quiz_id) {
        $query = $this->db->select('*')
        ->from('tmp_qms_answer')
        ->join('tmp_qms_answer_details', 'tmp_qms_answer.answer_id = tmp_qms_answer_details.answer_id', 'left')
        ->where( array('tmp_qms_answer.user_id' => $user_id, 'tmp_qms_answer.quiz_id' => $quiz_id) )
        ->get();
        return $query->result();
    }

    public function update_userdata($table, $where_ar, $data) {
        $this->db->where($where_ar);
        $this->db->update($table, $data);
    }

    public function get_all_user() {
        $query = $this->db->select('*')
        ->from('qms_users')
        ->order_by('user_id', 'DESC')
        ->get();
        return $query->result();
    }

    // pdf process 

    public function get_all_userpdf() {
        $query = $this->db->select('*')
        ->from('qms_users')
        ->limit(500)
        ->order_by('user_id', 'DESC')
        ->get();
        return $query->result();
    }

    // print process

    public function get_all_userprint() {
        $query = $this->db->select('*')
        ->from('qms_users')
        ->limit(500)
        ->order_by('user_id', 'DESC')
        ->get();
        return $query->result();
    }

    public function getcnt($table,$where) {
        $query = $this->db->select('*')
        ->from('qms_test_details')
        ->where($where)
        ->get();
        return $query->num_rows();
    }

    public function getAlldata($table,$filed,$con,$orderby,$order) {
        // $where = array('userid' => $this->session->userdata('loginid'), 'quizid' => $this->session->userdata('quiz_id'), 'finalsubmitstatus' => '1',);
        $query = $this->db->select($filed)
        ->from($table)
        ->where($con)
        ->order_by($orderby, $order)
        ->get();
        return $query->result();
    }


    public function getAlldatamypackage($table,$filed,$con,$orderby,$order) {
        $where = array('qms_packages.is_active' => '1', 'user_package.user_id' => $this->session->userdata('loginid'));
        $query = $this->db->select('qms_packages.*, user_package.*')
        ->from('qms_packages')
        ->join('user_package', 'qms_packages.package_id = user_package.package_id')
        ->where($where)
        ->order_by('qms_packages.package_duration', 'ASC')
        ->get();
        return $query->result();
    }

    public function questionandans($id){
        $con=array('qms_test_details.testuniqueid'=>$id);
        $query =   $this->db->select('qms_test_details.*')
        ->select('qms_questions.*')
        ->from('qms_test_details')
        ->join('qms_questions','qms_test_details.questionid = qms_questions.question_id', 'inner')
        ->where($con)
        ->get();
        return $query->result();
    }

    public function getattemptquiz($con){
        $query =   $this->db->select('qms_user_test.*')
        ->select('qms_quiz.*')
        ->from('qms_user_test')
        ->join('qms_quiz','qms_user_test.quizid = qms_quiz.quiz_id', 'inner')
        ->where($con)
        ->get();
        return $query->result();
    }


    public function get_user($user_id) {
        $query = $this->db->select('*')
        ->from('qms_users')
        ->where( array('user_id' => $user_id))
        ->get();
        return $query->result();
    }

    public function get_user_by_username($user_name) {
        $query = $this->db->select('user_id')
        ->from('qms_users')
        ->where( array('username' => $user_name))
        ->get();
        return $query->result();
    }

    public function exist_user_email($email, $skip = 0) {
        $query = $this->db->select('*')
        ->from('qms_users')
        ->where( array('email' => $email) );
        if($skip > 0) {
            $query->where( array('user_id !=' => $skip) );
        }
        $query = $query->get();
        return $query->result();
    }

    public function delete_user($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->delete('qms_users');
        return $query;
    }

    public function delete_useruserpackage($table,$user_id) {
        $this->db->where($user_id);
        $query = $this->db->delete($table);
        return $query;
    }

    public function getUserPackageMapping() {
        $this->db->select('user_id, username, name');
        $this->db->from('qms_users');
        $this->db->where('role', '3');
        $this->db->where('is_active', '1');
        $this->db->order_by('user_id', 'desc');
        $this->db->limit('300');
        $query=$this->db->get();
        $result=$query->result_array();


        $final_array  = array();
        $i = 0;
        foreach($result  as $data){
            $this->db->select('qms_packages.package_name');
            $this->db->from('user_package');
            $this->db->join('qms_packages', 'qms_packages.package_id = user_package.package_id', 'left');
            $this->db->where('user_package.user_id', $data['user_id']);
            $sqlPackageManagement=$this->db->get();
            $resultPackageManagement=$sqlPackageManagement->result_array();

            if($resultPackageManagement){
                $mapped_quiz_array = array();
                foreach ($resultPackageManagement as $quiz_mapping_data) {
                   $pckg_detail = $quiz_mapping_data['package_name'].'(purchased)'; 
                   array_push($mapped_quiz_array, "'".$pckg_detail."'");
                }
                $mapped_quiz_str = implode(',', $mapped_quiz_array);

            }
            $final_array[$i] = array('user_id'=>$data['user_id'], 'username'=>$data['username'], 'name'=>$data['name'], 'mapped_packages'=>$mapped_quiz_str);
            $i++;
        }
        return $final_array;
    }

}