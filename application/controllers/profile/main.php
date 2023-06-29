<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:26 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

    public $data;

    public function __construct(){
        parent::__construct();
        $this->login_model->login();
        // Page loading custom data
        $data = $this->lang_model->get_textdata();
        $data['page'] = 'profile';
        $data['theme_url'] = base_url().THEME_URL.CURRENT_THEME_NAME;
        $data['userdata'] = $this->login_model->get_cur_user_info();
        $data['menu_url'] = base_url()."index/menu";
        $data['title'] = "Profile";
        $this->data = $data;
    }

    public function index()
    {
        // load view content
        $this->data['userdata'] = $this->user_model->get_user($this->data['userdata']['member_id']);
        $this->page_model->get_header($this->data);
        $this->page_model->get_sidebar($this->data);
        $this->page_model->get_content($this->data);
        $this->page_model->get_footer($this->data);
    }

    public function ajax_call(){
        /**
         * Get Ajax Request Parameters
         */
        //ajax call
        $action  =   $this->input->get_post('action');
        $data   =   $this->input->get_post('data');
        $user_data = $this->data['userdata'];
//        echo json_encode($action);
        $updated_user_data = array();
        //return
        require_once FCPATH."ui/server/pages/profile.php";
        //$this->login_model->login();

//        $this->data['userdata']['username'] = $updated_user_data['member_name'];
//        $this->data['userdata']['email'] = $updated_user_data['member_email'];
//        $this->data['userdata']['first'] = $updated_user_data['member_first_name'];
//        $this->data['userdata']['last'] = $updated_user_data['member_last_name'];

//        echo json_encode($updated_user_data);

    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
