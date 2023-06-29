<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/10/14
 * Time: 9:43 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class signup extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //$this->login_model->login();
    }

    public function index($data = array())
    {
//        //lang data
//        $data = $this->lang_model->get_textdata();
//        //login form display
//        $data['login_url'] = base_url().'user/login';
//        $data['title'] = "Sign up";
//
//        $this->load->view('user/signup_view',$data);
    }

    public function ajax_call(){
        /**
         * Get Ajax Request Parameters
         */
        //ajax call
        require_once FCPATH.'ui/server/config.php';
        require_once FCPATH.'ui/server/user_manage.php';
  
        $user_manager= new UserManagement();
        $data  =   $this->input->post('data');
        $fullname = $data['fullname'];
        $email   =   $data['email'];
        $password   =   $data['password'];
        $user=array();
        $user['member_email']=isset($data['email']) ? $data['email']: "";
        $user['member_password']=isset($data['password']) ? $data['password']:"";
        $user['member_name']=isset($data['fullname']) ? $data['fullname']:"";
        $user['member_first_name']=$user['member_name'];
        $user['member_last_name']="";
        $user['iphone_device_id']="";
        $user['android_device_id']="";
        $user['country']="";
        $user['phone']="";
        $user['register_date']=time();
        $user['login_date']=time();
        if($user['member_name']==="")
        {
            $this->login_model->output('Please,input Full Name!',array('status' => 'error'));
            die;
        }
        if($user['member_email']==="")
        {
            $this->login_model->output('Please,input Email!',array('status' => 'error'));
            die;
        }
        if($user['member_password']===""){
            $this->login_model->output('Please,input Password!',array('status' => 'error'));
            die;
        }
           
        $result=$user_manager->is_exist_user($user);
        if($result)
        {
            if($result['member_email']===$user['member_email'])
                 $this->login_model->output('User Email already Exist ! ',array('status' => 'error'));
            else
               $this->login_model->output('User Name already Exist !',array('status' => 'error'));
            return;
        }
        else{
            $res=$user_manager->register_user($user,false);
            if($res)
              $this->login_model->output('Register Success!',array('status' => 'success'));
            else
              $this->login_model->output('Register Failed!',array('status' => 'error'));
            die;
        }
       
        
    }
}