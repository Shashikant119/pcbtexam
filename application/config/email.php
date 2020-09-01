<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 04/01/20
 * Time: 11:58 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp',
    'smtp_host' => '',
    'smtp_port' => '',
   
    'smtp_user' => '', // email id
    'smtp_pass' => '',
    'crlf' => "\r\n",
    'newline' => "\r\n",
    //'smtp_crypto' => '', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    //'smtp_timeout' => '5', //in seconds
    //'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);