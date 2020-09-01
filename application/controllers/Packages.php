<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {

    function __construct() {
        parent::__construct();
    /* $is_admin = $this->session->userdata('admin_login');
        if($is_admin) {
            //ok
        } else {
            redirect( base_url() . 'admin/' );
        }
        */
        $this->load->model('Quiz_model');
    }

	public function getPakageCount()
	{
	    
        $count = $this->db->query("SELECT COUNT(*) AS c FROM qms_packages")->row()->c;
		return $count;
	}

    public function add_update_package()
    {
        $data = array();
        if ($this->input->server('REQUEST_METHOD') === 'POST') 
        {
            //setting validation rule
            $this->form_validation->set_rules('package_name', 'Packages Name', 'required');

            if ($this->form_validation->run() !== FALSE) 
            {
                $edit_id = $this->input->post('req_edit_id');
                $data_ar = array ( 'package_name' => $this->input->post('package_name'),
                                   'package_type' => $this->input->post('package_type'),
                                   'package_price' => $this->input->post('package_price'),
                                   'package_duration' => $this->input->post('package_duration'),
                                   'total_cbt_test' => $this->input->post('total_cbt_test'),
                                   'mcq_in_cbt' => $this->input->post('mcq_in_cbt'),
                                   'frequency_of_cbt' => $this->input->post('frequency_of_cbt'),
                           );

                if ($edit_id > 0) 
                { 
                   //echo "<pre>";print_r($_FILES);die;
            if($_FILES['package_image']['name']){
               
                $f=$_FILES['package_image']['name'];
                $file_name=$this->do_upload_field($f,'package_image','./assets/images/packages');
                $data_ar['image']=$file_name;
            }

                    $where_ar = array('package_id' => $edit_id);
                    $this->Quiz_model->update_package($where_ar, $data_ar);
                    $this->session->set_flashdata('msg', 'Packages updated successfully.');
                } 
                else
                {
                    $this->Quiz_model->add_package($data_ar);
                    $this->session->set_flashdata('msg', 'Packages added successfully.');
                }
            }
        }
       redirect('admin_package');
    }

    public function del_package() 
    {
        $get_id = intval($this->uri->segment(2));
        if($get_id > 0) 
        {
            $where_ar = array('package_id' => $get_id);
            $this->Quiz_model->update_package($where_ar, array('is_active' => 0));
            $this->session->set_flashdata('msg', 'Packages deleted successfully.');
        }
        redirect('admin_package');
    }

    public function get_package_details()
    {
        $data['status'] = '0';
        $pid = intval($this->input->post('pid'));
        $result = $this->Quiz_model->get_package_details($pid);
        if(count($result) > 0)
        {
            $data['status'] = '1';
            $data['result'] = $result[0];
        }
        echo json_encode($data);
    }
public function do_upload_field($file,$field,$path=''){
        $new_name=time().$file;
        $config = array(
        'upload_path' =>$path,
        'allowed_types' => "gif|jpg|png|jpeg|pdf",
        'overwrite' => TRUE,
        'max_size' => "2048000",
        'file_name'=>$new_name
         );
    
    
   $this->load->library('upload',$config);
   $this->upload->initialize($config);
  if($this->upload->do_upload($field))
  {
    $upload_data = $this->upload->data(); 
      $file_name = $upload_data['file_name'];
    return $file_name;
  }
  else
  {
  $error = array('error' => $this->upload->display_errors());
  return '';
  }
} 
}
