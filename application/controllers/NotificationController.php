<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 05/01/20
 * Time: 12:01 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
//require_once APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php';
class NotificationController extends CI_Controller
{
    function __construct() {
        parent::__construct();
        /*$user_type = intval($this->session->userdata('user_type'));

        if($user_type != 2) {
            redirect(base_url());
        }*/

        $this->load->helper(array('form', 'url'));
        $this->load->model('Auth');
    }
/*public function sendMail($to='shashi801@gmail.com')
{
	$mail = new PHPMailer();
	   $mail->IsSMTP();
	   $mail->Mailer = "smtp";
	  $mail->SMTPDebug  = 1;  
		$mail->SMTPAuth   = TRUE;
		$mail->SMTPSecure = "tls";
		$mail->Port       = 587;
		$mail->Host       = "smtp.gmail.com";
		$mail->Username   = "shashi801@@gmail.com";
		$mail->Password   = "shivbaba123456#";
		$mail->IsHTML(true);
		$mail->AddAddress("shashi801@@gmail.com", "recipient-name");
		$mail->SetFrom("shashi801@@gmail.com", "shashi");
		
		$mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
		$content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";
	   $mail->MsgHTML($content); 
		if(!$mail->Send()) {
		  echo "Error while sending Email.";
		  var_dump($mail);
		} else {
		  echo "Email sent successfully";
		}
}*/

}