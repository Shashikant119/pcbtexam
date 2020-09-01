<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 02/12/19
 * Time: 11:35 PM
 */

class AnswerSheet extends CI_Model
{

    function __construct() {
        parent::__construct();
    }
   function allAnswerSheet()
   {
    $list=$this->db->select('qms_answer_sheet.id,qms_answer_sheet.user_id,result_id,can_view_permission,username,name')
                  ->from('qms_answer_sheet')
                 ->join('qms_users','qms_answer_sheet.user_id=qms_users.user_id')
                  ->get()->result();
               //   echo $this->db->last_query();die;
     return $list;
   }
    function updateView($id,$val)
   {
    $this->db->where('id',$id)
                  ->update('qms_answer_sheet',['can_view_permission'=>$val]);
                
     
   }

 }
   