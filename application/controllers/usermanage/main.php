<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/11/14
 * Time: 1:39 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

    public $data;
    public function __construct(){
        parent::__construct();
        $this->login_model->login();
        // Page loading custom data
        $data = $this->lang_model->get_textdata();
        $data['page'] = 'usermanage';
        $data['theme_url'] = base_url().THEME_URL.CURRENT_THEME_NAME;
        $data['userdata'] = $this->login_model->get_cur_user_info();
        $data['menu_url'] = base_url()."index/menu";
        $data['title'] = "User management";

        $this->data = $data;
    }

    public function index()
    {
        $this->data['userdata'] = $this->user_model->get_user($this->data['userdata']['member_id']);
        $this->data['users'] = $this->user_model->get_all_user();
//        $this->page_model->get_header($this->data);
//        $this->page_model->get_sidebar($this->data);
//        $this->page_model->get_content($this->data);
//        $this->page_model->get_footer($this->data);
        $this->page_model->load_page_template($this->data);
    }

    public function ajax_call(){
        //ajax call
        $action  =   $this->input->get_post('action');
        $data   =   $this->input->get_post('data');


        require_once FCPATH."ui/server/user_manage.php";
        $user_manage = new UserManagement();
//        echo json_encode($data);
        switch($action){
            case 'add_new_user':

                $user['member_name'] = $data['user_email'];
                $user['member_email'] = $data['user_email'];
                $user['member_password'] = $data['user_pass'];
                $user['member_role'] = $data['user_role'];

                $user_manage->register_user($user);
                break;
            case 'delete_user':
                $user['member_id'] = $data['id'];
                $user_manage->delete_user($user);
                break;
            case 'reset_user_password':
                $user['member_email'] = $data['email'];
                $user['member_password'] = $data['password'];
                $user_manage->reset_password($user);
                break;
            case 'reset_request':
                $user['member_email'] = $data['email'];
                $user_manage->reset_request($user);
                break;
        }


    }

}
