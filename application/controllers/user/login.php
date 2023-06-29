<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:26 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {

    public $key;
    public $redirect_url = 'research/main';

    public function __construct(){
        parent::__construct();
    }
    
    public function index($data = array())
    {
        $key = $this->input->get('key');

        if(!$key || !$this->login_model->is_exist_member_key($key)){
            return;
        }
        //lang data
        $data = $this->lang_model->get_textdata();

        $data['signup_url'] = base_url()."user/signup";
        $data['theme_url'] = base_url().THEME_URL.CURRENT_THEME_NAME;
        $data['title'] = "Sign in";
        $data['key'] = $key;
        $this->load->view('user/login_view',$data);
    }

    public function confirm()
    {
        //$userdata   =   $this->login_model->get_user_info('wjsskanyo@gmail.com');
        $email  =   $this->input->get_post('email') ;
        $pass   =   $this->input->get_post('password');
        $key = $this->input->get_post('key');


        /**
         * $data['iserror'] = 0:    no error
         * $data['iserror'] = 1:    no exist user
         * $data['iserror'] = 2:    password error
         */
        $data['iserror']    =   0;
        //Check session validation

        //Check user exist
        if(!$this->login_model->is_exist_member_email($email))
        {
            //if no exist user then return to signup page
            $this->login_model->output('User no exist!',array('status' => 'no_exist'));
            exit;
        }

        //Check user key
        if(!$this->login_model->is_valid_key($email , $key)){
            $this->login_model->output('Invalid Key!',array('status' => 'invalid_key'));
            exit;
        }

        //Check user info validation
        //echo $pass;
        $rec=$this->login_model->confirm_user_info($email, $pass);
        //print_r($rec);
        if(!$this->login_model->islogin())
        {
           //redirect('user/login',$data);
            $this->login_model->output('Password Error!',array('status' => 'password_error'));
        }else{
            //redirect($this->redirect_url);
            $this->login_model->output('Success!',array('status' => 'success'));
        }
    }

    public function ajax_call(){
        $this->confirm();
    }

    public function logout(){
        $this->login_model->logout();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
