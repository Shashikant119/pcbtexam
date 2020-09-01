<?php
  class Excel_export_model extends CI_Model{
	function __construct() {
        parent::__construct();
    }
  	public function fetchData(){
		return  $this->db->select("*")->from('qms_users')->order_by('id', 'desc')->get()->result();
  	}
  }
?>