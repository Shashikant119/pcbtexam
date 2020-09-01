<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 29/12/19
 * Time: 12:30 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('Notification');
     
      $this->load->helper('custome_helper');
    }

    public function index() { 
        
        //echo phpversion();die;
     $data['feedback']=$this->db->query("SELECT user_feedback.`user_id`, `name`,`state`,`feedback` FROM user_feedback INNER JOIN qms_users ON user_feedback.`user_id`=qms_users.`user_id` ORDER BY user_feedback.`id` LIMIT 25")->result();
      //$this->truncate_table();
        $this->load->view('index',$data);
    }
     public function sendM() {//echo "hiii";die;
     // $this->Notification->sendEmail('shashi801@gmail.com','Subje','body');
       
    }
public function truncate_table()
{
  $q="SELECT table_name FROM information_schema.tables WHERE table_schema ='pcbt-qms'";
      $r=$this->db->query($q)->result();
      foreach($r as $x){
           if($x->table_name=='qms_users')
               continue;
         $this->db->query("TRUNCATE TABLE ".$x->table_name);

         }
$this->db->query("DELETE FROM qms_users WHERE `username`!='admin'");
}
 public function privacy() {
      
       $this->load->view('privacy/privicy_and_policy');
       
    }

 public function terms() {
      
         //echo $this->db->last_query();die;
       $this->load->view('Terms/terms_and_conditions');
       
    }

}