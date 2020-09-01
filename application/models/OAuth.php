
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class OAuth extends CI_Model{
    function __construct() {
        $this->tableName = 'qms_users';
        $this->primaryKey = 'user_id';
    }
    public function checkUser($data = array()){
        $this->db->select($this->primaryKey);
        $this->db->from($this->tableName);
        $this->db->where(array('oath_provider'=>$data['oauth_provider'],'oath_uid'=>$data['oauth_uid']));
        $prevQuery = $this->db->get();
        $prevCheck = $prevQuery->num_rows();
        $userID=NULL;
        if($prevCheck > 0){
           
            $userID = $prevQuery->row()->user_id;
        }else{
           $userID=FALSE;
        }
 
        return $userID;
    }
}