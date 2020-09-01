<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Model {
   function __construct() {
        parent::__construct();
    }

    

	public function getPaymentCount()
	{
	    
        $count = $this->db->query("SELECT COUNT(*) AS c FROM qms_payment_history")->row()->c;
		return $count;
	}
}
