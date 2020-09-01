<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Root extends CI_Controller {

	public function index(){ 

		$data = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			// setting validation rule
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() !== FALSE) {
            	$this->load->model('User_model');
                $login_res = $this->User_model->validate_user($this->input->post('username', true), $this->input->post('password', true), '1');
                if(count($login_res) > 0) {
                    if($login_res->is_active == 1){
                        $this->session->set_userdata('admin_login',1 );
                       /* $this->session->set_userdata( array('user_id'  => $login_res->user_id) );
                        $this->session->set_userdata( array('user_name'  => $login_res->username) );
                        $this->session->set_userdata( array('user_type'  => $login_res->user_type) );
                        $this->session->set_userdata('login', 'true');*/
                        redirect('dashboard');
                    } else {
                        $data['error_msg'] = 'Your account is not active.';
                    }
                } else {
                    $data['error_msg'] = 'Invalid login details.';
                }
            } else {
                $data['error_msg'] = 'Please enter username and password.';
            }
        }
        $this->load->view('login', $data);
    }

    public function logout(){
      $this->session->sess_destroy();
      if( $this->session->userdata('user_type')==1)
          redirect( base_url() . 'admin' );
      else
        redirect( base_url());
}
}
