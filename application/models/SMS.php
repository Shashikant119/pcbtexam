<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 17/12/19
 * Time: 11:13 PM
 */

class SMS extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

   public function sendSMS($number,$msg='')
   {
          $client_id='67a206f5-80c7-4f40-ad10-43c41d81125d';
      $api_key='7301d031-b386-4584-be71-0f17e667e2bb';
    
        $handle = curl_init();
        //echo $msg;die;
        $msg= curl_escape($handle, $msg);
        $url = "http://app.smsinsta.in/vendorsms/pushsms.aspx?clientid=".$client_id."&apikey=".$api_key."&msisdn=".$number."&sid=PCBTEP&msg=".$msg."&fl=0&gwid=2";
        
        curl_setopt($handle, CURLOPT_URL, $url);
        // Set the result output to be a string.
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
         
        $output = curl_exec($handle);
         
        //curl_close($handle);
        
        $resp= json_decode($output,true);
        
        return $resp;
   }

}