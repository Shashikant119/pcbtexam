<?php
 
/**

 * Created by PhpStorm.

 * User: amitpandey
 
 * Date: 29/12/19

 * Time: 4:25 PM

 */



class Auth extends CI_Model

{

    function __construct() {

        parent::__construct();

    }



    function generatePassword()

    {

        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

        $password = array();

        $alpha_length = strlen($string) - 1;

        for ($i = 0; $i < 6; $i++)

        {

            $n = rand(0, $alpha_length);

            $password[] = $string[$n];

        }

        return implode($password);

    }



    public function registerUser($input) {
        try {
            $this->db->insert('qms_users', $input);
            return $this->db->insert_id();

        } catch (\Exception $exception) {
            return false;
        }

    }



    public function isEmailExists($email) {



        $q = $this->db->get_where('qms_users',['email'=>trim($email)]);



        if($q->num_rows()==0)

         return false;

     else

        return true;



}



public function getUser($username, $field) {

    $user = [];

    try {

        $user = $this->db->select('*')

        ->from('qms_users')

        ->where(array($field => $username, 'is_active' => 1))

        ->get()->row();

    } catch (\Exception $exception) {



    }



    return $user;

}



}