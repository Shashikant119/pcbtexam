<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 28/11/19
 * Time: 11:38 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionBankController extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $user_type = $this->session->userdata('admin_login');
        if (!$user_type) {
            redirect( base_url('admin'));
        }


        $this->load->model('QuestionBank');
        $this->load->model('Category');
        $this->load->model('Level');
    }

    public function index(){
        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->input->post('question_name') !='') {
            $question_name  = $this->input->post('question_name');            
        }
        else{
            $question_name  = '';  
        }    
        $data = array();
        $data['questions'] = $this->QuestionBank->getQuestionsMaster($question_name);
        $data['categories'] = $this->Category->getCategories();
        $data['levels'] = $this->Level->getLevels();
        $this->load->view('admin/question_bank', $data);
    }

    public function pre_create() {
        $this->load->view('admin/pre-add-question');
    }

    public function create() {

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('question_type', 'Question Type', 'required');
            $this->form_validation->set_rules('number_of_option', 'Number of Option', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('admin/pre-add-question');
            }

            $data = array();
            $data["question_type"] = $this->input->post('question_type');
            $data["number_of_option"] = $this->input->post('number_of_option');
            $data["categories"] = $this->Category->getCategories();
            $data["levels"] = $this->Level->getLevels();
            $this->load->view('admin/add-question', $data);

        } else {
            redirect("pre-add-question");
        }

    }

    public function store() {

        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //setting validation rule
            $this->form_validation->set_rules('question_type', 'Question Type', 'required');
            $this->form_validation->set_rules('question_text', 'Question Text', 'required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('level', 'Level', 'required');
            if (!empty($this->input->post('question_type')) && $this->input->post('question_type') != QuestionBank::LONG_ANSWER && $this->input->post('question_type') != QuestionBank::SHORT_ANSWER) {
                $this->form_validation->set_rules('number_of_option', 'Number Of Option', 'required');

                if (!empty($this->input->post('number_of_option'))) {
                    for ($i = 1; $i <= $this->input->post('number_of_option'); $i++) {
                        $this->form_validation->set_rules('option_'.$i, 'Option '.$i, 'required');
                    }
                }
            }

            if (!empty($this->input->post('number_of_option')) && $this->input->post('question_type') == QuestionBank::MULTIPLE_CHOICE_SINGLE_ANSWER || $this->input->post('question_type') != QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER) {
                $this->form_validation->set_rules('correct_option[]', 'Correct Option', 'required');
            }

            if ($this->form_validation->run() === FALSE) {
                redirect("pre-add-question");
            }

            $input = array ( 'question_type' => $this->input->post('question_type'),
                'category_id' => $this->input->post('category'),
                'level_id' => $this->input->post('level'),
                'question' => $this->input->post('question_text'),
                'number_of_option' => $this->input->post('number_of_option'),
                'correct_option' => json_encode($this->input->post('correct_option')),
                'answer_explanation' => $this->input->post('answer_explanation')
            );

            if ($input["question_type"] == QuestionBank::SHORT_ANSWER || $input["question_type"] == QuestionBank::LONG_ANSWER) {
                $input["number_of_option"] = 0;
            } else {
                for ($i = 1; $i<= $this->input->post("number_of_option"); $i++) {
                    $input["option_".$i] = $this->input->post("option_".$i);
                }
            }

            $this->QuestionBank->addQuestion($input);
            $this->session->set_flashdata('msg', 'Question added successfully.');
            redirect('question-bank');
        }
    }

    public function edit($question_id) {
        $data = array();
        $data["categories"] = $this->Category->getCategories();
        $data["levels"] = $this->Level->getLevels();
        $data['question'] = $this->QuestionBank->getQuestionById($question_id);
       //echo $this->db->last_query();die;
        if (empty($data["question"])) {
            $this->session->set_flashdata('msg', 'Question not found');
            redirect('question-bank');
        }

        $this->load->view('admin/edit-question', $data);
    }

    public function update($question_id) {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            $question = $this->QuestionBank->getQuestionById($question_id);

            if (empty($question)) {
                $this->session->set_flashdata('msg', 'Invalid question selected');
                redirect('question-bank');
            }

            //setting validation rule
            $this->form_validation->set_rules('question_text', 'Question Text', 'required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            $this->form_validation->set_rules('level', 'Level', 'required');

            if ($question->question_type != QuestionBank::LONG_ANSWER && $question->question_type != QuestionBank::SHORT_ANSWER) {
                if ($question->number_of_option > 0) {
                    for ($i = 1; $i <= $question->number_of_option; $i++) {
                        $this->form_validation->set_rules('option_'.$i, 'Option '.$i, 'required');
                    }
                }
            }

            if ($question->number_of_option > 0 && $question->question_type == QuestionBank::MULTIPLE_CHOICE_SINGLE_ANSWER || $question->question_type == QuestionBank::MULTIPLE_CHOICE_MULTIPLE_ANSWER) {
                $this->form_validation->set_rules('correct_option[]', 'Correct Option', 'required');
            }

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('edit-question');
            }

            $input["video_url"]= $question->video_url;
            if($_FILES['video_url']['name']){

                $f=$_FILES['video_url']['name'];
                $file_name=$this->do_upload_field($f,'video_url','video');
                $input["video_url"]=$file_name;
            }
            $input["audio_url"]= $question->audio_url;
            if($_FILES['audio_url']['name']){

                $f=$_FILES['audio_url']['name'];
                $file_name=$this->do_upload_field($f,'audio_url','audio');
                $input["audio_url"]=$file_name;
            }
            $input["image_url"]= $question->image_url;;
         // echo "<pre>";print_r($_FILES);die;
            $input = array ( 'category_id' => $this->input->post('category'),
                'level_id' => $this->input->post('level'),
                'question' => strip_tags($this->input->post('question_text'),'<img'),
                'correct_option' => json_encode($this->input->post('correct_option')),
                'answer_explanation' => $this->input->post('answer_explanation'),
                'video_url'=>$input["video_url"],
                'audio_url'=>$input["audio_url"],
                'image_url'=>$input["image_url"],
                'option_1'=>$this->strRe($this->input->post('option_1')),
                'option_2'=>$this->strRe($this->input->post('option_2')),
                'option_3'=>$this->strRe($this->input->post('option_3')),
                'option_4'=>$this->strRe($this->input->post('option_4'))
            );
            if($_FILES['option_1_url']['name']){
                $f=$_FILES['option_1_url']['name'];
                $file_name=$this->do_upload_field($f,'option_1_url','options');
                $input["option_1_url"]=$file_name;
            }
            if($_FILES['option_2_url']['name']){
                $f=$_FILES['option_2_url']['name'];
                $file_name=$this->do_upload_field($f,'option_2_url','options');
                $input["option_2_url"]=$file_name;
            }
            if($_FILES['option_3_url']['name']){
                $f=$_FILES['option_3_url']['name'];
                $file_name=$this->do_upload_field($f,'option_3_url','options');
                $input["option_3_url"]=$file_name;
            }
            if($_FILES['option_4_url']['name']){
                $f=$_FILES['option_4_url']['name'];
                $file_name=$this->do_upload_field($f,'image_url','options');
                $input["option_4_url"]=$file_name;
            }
            if ($question->number_of_option > 0) {
                for ($i = 1; $i<= $question->number_of_option; $i++) {
                    $input["option_".$i] = $this->input->post("option_".$i);
                }
            }
 // echo "<pre>";print_r($input);die;
            $where = array("question_id" => $question_id);
            $this->db->where($where)->update('qms_questions',$input);
            redirect('question-bank');
        }
    }
    function strRe($str)
    {
        return  preg_replace("/[\n\r]/","",$str); 
    }
    public function upload() {
        if(empty($_FILES['question_file']) || $this->input->server('REQUEST_METHOD') !== 'POST') {
            $this->session->set_flashdata('msg', 'Please select a valid file');
            redirect('question-bank');
        }

        $file_ext = strtolower(pathinfo($_FILES['question_file']['name'], PATHINFO_EXTENSION));

        if ($file_ext !== 'xls') {
            $this->session->set_flashdata('msg', 'Please upload file in .xls format only');
            redirect('question-bank');
        }

        $level_id = $this->input->post('level');
        $category_id = $this->input->post('category');

        // get data from file
        $upload_counter = 0;
        $file = $_FILES['question_file']['tmp_name'];
        $this->load->library('excel');

        $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
        $excelObj = $excelReader->load($file);
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();
        $data = array();
        for ($row = 2; $row <= $lastRow; $row++) {
            $temp_data = array();
            $temp_data['question_type'] = $worksheet->getCell('A'.$row)->getValue() instanceof PHPExcel_RichText ? $worksheet->getCell('A'.$row)->getValue()->getPlainText() : $worksheet->getCell('A'.$row)->getValue();
            $temp_data['question'] = $worksheet->getCell('B'.$row)->getValue() instanceof PHPExcel_RichText ? $worksheet->getCell('B'.$row)->getValue()->getPlainText() : $worksheet->getCell('B'.$row)->getValue();

            if (empty(trim($temp_data['question']))) {
                continue;
            }



            $temp_data['answer_explanation'] = $worksheet->getCell('C'.$row)->getValue() instanceof PHPExcel_RichText ? $worksheet->getCell('C'.$row)->getValue()->getPlainText() : $worksheet->getCell('C'.$row)->getValue();
            $temp_data['correct_option'] = $worksheet->getCell('D'.$row)->getValue() instanceof PHPExcel_RichText ? $worksheet->getCell('D'.$row)->getValue()->getPlainText() : $worksheet->getCell('D'.$row)->getValue();
            $temp_data['option_1'] = $worksheet->getCell('E'.$row)->getValue() instanceof PHPExcel_RichText ? $worksheet->getCell('E'.$row)->getValue()->getPlainText() : $worksheet->getCell('E'.$row)->getValue();
            $temp_data['option_2'] = $worksheet->getCell('F'.$row)->getValue() instanceof PHPExcel_RichText ? $worksheet->getCell('F'.$row)->getValue()->getPlainText() : $worksheet->getCell('F'.$row)->getValue();
            $temp_data['option_3'] = $worksheet->getCell('G'.$row)->getValue() instanceof PHPExcel_RichText ? $worksheet->getCell('G'.$row)->getValue()->getPlainText() : $worksheet->getCell('G'.$row)->getValue();
            $temp_data['option_4'] = $worksheet->getCell('H'.$row)->getValue() instanceof PHPExcel_RichText ? $worksheet->getCell('H'.$row)->getValue()->getPlainText() : $worksheet->getCell('H'.$row)->getValue();
            $temp_data['lang'] = $worksheet->getCell('I'.$row)->getValue() instanceof PHPExcel_RichText ? $worksheet->getCell('I'.$row)->getValue()->getPlainText() : $worksheet->getCell('I'.$row)->getValue();

            if (!empty($temp_data['option_1']) && !empty($temp_data['option_2']) && !empty($temp_data['option_3']) && !empty($temp_data['option_4'])) {
                $temp_data['number_of_option'] = 4;
                $correct_option = explode(",", $temp_data['correct_option']);
                $temp_option = [];
                for ($i = 0; $i < count($correct_option); $i++) {
                    $temp_option[] = "option_".$correct_option[$i];
                }
                $temp_data['correct_option'] = json_encode($temp_option);
            } else {
                $temp_data['correct_option'] = json_encode($temp_data['correct_option']);
                $temp_data['number_of_option'] = 0;
            }
            $check_ar=json_decode($temp_data['correct_option']);
            if(!is_array($check_ar) )
            {
               if(strlen($check_ar)==1)
                  $temp_data['correct_option']=json_encode(['option_'. $temp_data['correct_option']]);
          }
          $temp_data['level_id'] = $level_id;
          $temp_data['category_id'] = $category_id;
          if(empty($temp_data['lang']))
           $temp_data['lang']='en';
       array_push($data, $temp_data);
       $upload_counter++;
   }

   if (empty($data)) {
    $this->session->set_flashdata('msg', 'No question found in uploaded file');
    redirect('question-bank');
}

$this->QuestionBank->addBulkQuestion($data);
redirect('question-bank');
}

public function delete($question_id) {
    $where = array('question_id' => $question_id);
    $this->QuestionBank->updateQuestion(array('is_active' => 0), $where);
    $this->session->set_flashdata('msg', 'Question deleted successfully.');
    redirect('question-bank');
}
public function delete_files() {
 $qid=$this->input->post('qid');
 $type=$this->input->post('type');
 $q=$this->db->get_where('qms_questions',['question_id'=>$qid])->row();
 if($type=='video')
 {
    $video_url=$q->video_url;
    unlink(FCPATH.'uploads/video/'.$video_url);
    $this->db->where('question_id',$qid)->update('qms_questions',['video_url'=>'']);

}
if($type=='audio')
{
    $video_url=$q->audio_url;
    unlink(FCPATH.'uploads/audio/'.$video_url);
    $this->db->where('question_id',$qid)->update('qms_questions',['audio_url'=>'']);

}
if($type=='image')
{
    $video_url=$q->image_url;
    unlink(FCPATH.'uploads/image/'.$video_url);
    $this->db->where('question_id',$qid)->update('qms_questions',['image_url'=>'']);

}
if($type=='op1')
{
    $video_url=$q->option_1_url;
    unlink(FCPATH.'uploads/options/'.$video_url);
    $this->db->where('question_id',$qid)->update('qms_questions',['option_1_url'=>'']);

}
if($type=='op2')
{
    $video_url=$q->option_2_url;
    unlink(FCPATH.'uploads/options/'.$video_url);
    $this->db->where('question_id',$qid)->update('qms_questions',['option_2_url'=>'']);

}
if($type=='op3')
{
    $video_url=$q->option_3_url;
    unlink(FCPATH.'uploads/options/'.$video_url);
    $this->db->where('question_id',$qid)->update('qms_questions',['option_3_url'=>'']);

}
if($type=='op4')
{
    $video_url=$q->option_4_url;
    unlink(FCPATH.'uploads/options/'.$video_url);
    $this->db->where('question_id',$qid)->update('qms_questions',['option_4_url'=>'']);

}

        // echo $this->db->last_query();
echo 'done';
}

public function do_upload_field($file,$field,$path=''){
    $new_name=time().$file;
    $config = array(
        'upload_path' =>FCPATH.'uploads/'.$path,
        'allowed_types' => "gif|jpg|png|jpeg|mp4|avi|mp3|ogg",
        'overwrite' => TRUE,
        'max_size' => "2048000",
        'file_name'=>$new_name
    );
    $this->load->library('upload',$config);
    $this->upload->initialize($config);
    if($this->upload->do_upload($field)){
      $upload_data = $this->upload->data(); 
      $file_name = $upload_data['file_name'];
      return $file_name;
  }
  else{
    $error = array('error' => $this->upload->display_errors());
    echo $this->upload->display_errors();die;
    return '';
}
} 
}