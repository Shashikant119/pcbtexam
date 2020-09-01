<?php
/**
 * Created by PhpStorm.
 * User: amitpandey
 * Date: 30/11/19
 * Time: 12:18 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class LevelController extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $user_type = $this->session->userdata('admin_login');
        if (!$user_type) {
            redirect( base_url('admin'));
        }


        $this->load->model('Level');
    }

    public function index() {
        $data = array();
        $data["levels"] = $this->Level->getLevels();
        $this->load->view('admin/levels', $data);
    }

    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            // setting validation rule
            $this->form_validation->set_rules('level_name', 'Level Name', 'required');

            if ($this->form_validation->run() !== FALSE)
            {
                $input = array ( 'level_name' => $this->input->post('level_name'));
                $this->Level->add_level($input);
            }

            redirect('levels');
        }
    }

    public function update() {
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            // setting validation rule
            $this->form_validation->set_rules('level_name', 'Level Name', 'required');
            $this->form_validation->set_rules('level_id', 'Level ID', 'required');

            if ($this->form_validation->run() !== FALSE)
            {
                $input = array ( 'level_name' => $this->input->post('level_name'));
                $where = array('id' => $this->input->post('level_id'));

                $res = $this->Level->update_level($input, $where);
                if ($res) {
                    header('Content-Type: application/json');
                    echo json_encode(array("success" => true, "message" => "Level updated successfully"));
                } else {
                    return json_encode(["success" => false, "message" => "Level updated successfully"]);
                }
            }
        }
    }

    public function delete($level_id) {
        $this->Level->delete_level($level_id);
        redirect('levels');
    }

}