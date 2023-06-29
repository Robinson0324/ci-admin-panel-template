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
        $data['page'] = 'chatting';
        $data['theme_url'] = base_url().THEME_URL.CURRENT_THEME_NAME;
        $data['userdata'] = $this->login_model->get_cur_user_info();
        $data['menu_url'] = base_url()."index/menu";
        $data['title'] = "Chatting";
        $this->data = $data;
    }

    public function index()
    {
        $this->data['userdata'] = $this->user_model->get_user($this->data['userdata']['member_id']);
        $key = $this->data['userdata']->member_key;
        $this->data['users'] = $this->user_model->get_devices($key);

        // load view content
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
        
        $userdata = isset($this->data['userdata']) ? $this->user_model->get_user($this->data['userdata']['member_id']) : array();
        $action  =   $this->input->get_post('action') ;
        $data   =   $this->input->get_post('data');

        require_once FCPATH."ui/server/pages/chatting.php";
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
