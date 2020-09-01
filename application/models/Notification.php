<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 04/01/20
 * Time: 11:32 PM
 */
require_once APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php';
class Notification extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    public function sendEmail($to_email,$sub,$message) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = FALSE;  
        $mail->Host = "localhost"; 
        $mail->SMTPAuth = false; 
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;
        $mail->Username   = "knovatik@gmail.com";
        $mail->Password   = "knovatik@5817";
        $mail->IsHTML(true);
        $mail->AddAddress(trim($to_email), "InnoKnova");
        $mail->SetFrom("knovatik@gmail.com", "InnoKnova");
        
        $mail->Subject = $sub;
        $content = $message;
        $mail->MsgHTML($content); 
        if(!$mail->Send()) {
          return false;
          
      } else {
          return true;
      }
  }
  public function sendM() {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    
    $mail->Host = "localhost"; 
    $mail->SMTPAuth = false; 
    $mail->SMTPSecure = false;
    $mail->SMTPAutoTLS = false;
    $mail->Username   = "info@pcbtexamportal.com";
    $mail->Password   = "shivbaba123456#";
    $mail->IsHTML(true);
    $mail->AddAddress(trim('shashi801@gmail.com'), "PCBT");
    $mail->SetFrom("info@pcbtexamportal.com", "PCBT");
    $mail->Subject ='pcbtsmstp';
    $content ='hihih this';
    $mail->MsgHTML($content); 
    if(!$mail->Send()) {
         // return false;
        
    } else {
         // return true;
       echo 'done';
   }
}

public function sendSMS($number,$msg=''){
    //   $client_id='67a206f5-80c7-4f40-ad10-43c41d81125d';
    //   $api_key='7301d031-b386-4584-be71-0f17e667e2bb';
    //   $number=ltrim($number,'0');
    //  $handle = curl_init();
    //  $msg= curl_escape($handle, $msg);
    //  $url = "http://app.smsinsta.in/vendorsms/pushsms.aspx?clientid=".$client_id."&apikey=".$api_key."&msisdn=".$number."&sid=PCBTEP&msg=".$msg."&fl=0&gwid=2";
    
    // curl_setopt($handle, CURLOPT_URL, $url);
    // // Set the result output to be a string.
    // curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
 
    // $output = curl_exec($handle);
 
    // //curl_close($handle);
    
    // $resp= json_decode($output,true);
    
    // return $resp;
}

}