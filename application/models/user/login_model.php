<?php
//Hash class load
require_once FCPATH."/ui/server/class-phpass.php";

class login_model extends CI_Model {

    private  $_table = "member_tb";
    function __construct()
    {
        parent::__construct();
    }
	function confirm_user_info($email, $passwd)
    {
            //set default userinfo  into session
            $userdata   =   $this->get_empty_user_info();
            $this->set_cur_user_info($userdata);
			//confirm  login info with email and passwd 
            $query =array("member_email"=>$email);
			$this->db->where($query);
			$execResult =$this->db->get($this->_table);
			if($execResult->num_rows()<1)
				return false;
                
            $rec=$execResult->result()[0];
            $userdata['member_id'] = $rec->member_id;
            $userdata['email'] = $rec->member_email;
            $userdata['id'] = $rec->member_id;
            $userdata["role"] =  $rec->member_role;
            $userdata['name'] = $rec->member_name;
            $userdata["passwd"]=$rec->member_password;
            $userdata['first'] = $rec->member_first_name;
            $userdata['last'] = $rec->member_last_name;
            $userdata['avatar'] = $rec->member_avatar;
            $userdata['login']=false;
            //Password to wordpress hashed Password
            $wp_hasher = new PasswordHash(8, TRUE);


            if($wp_hasher->CheckPassword($passwd, $userdata["passwd"])) {
                $userdata['login']=true;
                $this->set_cur_user_info($userdata);
                return $rec;
            }
            $this->set_cur_user_info($userdata);
            return false;
//set current user info to session
        //$this->set_cur_user_info($userdata);

            
    }
    function get_table_data ($tablename,$where='')
    {
        try {
            if($where   !== '')
            $this->db->where($where);
            return $this->db->get($tablename)->result();
        } catch (Exception $e) {
            json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                ),
            ));
           
        } 
        
    }
    function get_user_all_info($email)
    {
        $userinfo   =   $this->get_empty_user_info();
        $query =array("member_email"=>$email);//,"Passwd"=>$passwd);
        $this->db->where($query);
        $execResult =$this->db->get($this->_table);
        if($execResult->num_rows()<1)
            return $userinfo;
        $rec = $execResult->result()[0];

        return $rec;
    }
    function get_user_all_info_from_id($id)
    {

        $query =array("member_id"=>$id);//,"Passwd"=>$passwd);
        $this->db->where($query);
        $execResult =$this->db->get($this->_table);
        if($execResult->num_rows()<1)
            return array();
        $rec = $execResult->result()[0];

        return $rec;
    }
    function get_user_info($email)
    {
        $userinfo   =   $this->get_empty_user_info();
        $query =array("member_email"=>$email);//,"Passwd"=>$passwd);
        $this->db->where($query);
        $execResult =$this->db->get($this->_table);
        if($execResult->num_rows()<1)
           return $userinfo;
        $rec = $execResult->result()[0];

        return $rec;
    }
    function get_empty_user_info(){
          return array(     "id" =>        '',
                            "email" =>     '',
                            "role" =>      '',
                            "passwd"=>     '' ,
                            "name" =>      '',
                            "url" =>       '',
                            "reg_date"=>   '',
                            "activation_key"=>  '',
                            'status'  => '',
                            "display_name" => '',
                            'login' =>false
                       );
          
    }

	function is_exist_member_email($email)
    {

       $this->db->where('member_email',$email);
       $table = $this->_table;
       $execResult =$this->db->get($table);
       if($execResult)
       if($execResult->num_rows()>0)
       {
            return true;
       }   
       return false; 
    }

    function is_valid_key($email , $key){
        $userinf = $this->get_user_info($email);
//        echo json_encode($userinf);
        return ($key == $userinf->member_key);
    }

    function is_exist_member_key($key)
    {

        $this->db->where('member_key',$key);
        $table = $this->_table;
        $execResult =$this->db->get($table);
        if($execResult)
            if($execResult->num_rows()>0)
            {
                return true;
            }
        return false;
    }

    function isExistMember($id)
    {

        $this->db->where('member_id',$id);
        $table = $this->_table;
        $execResult =$this->db->get($table);
        if($execResult)
            if($execResult->num_rows()>0)
            {
                return true;
            }
        return false;
    }
    function get_cur_user_info(){
        $userdata   =   $this->session->userdata('userdata');
        if(isset($userdata))
           return $userdata;
        $userdata   =   $this->get_empty_user_info();
        return $userdata;
    }
    function set_cur_user_info($userdata){
        //set $_SESSION['userdata']
        $this->session->set_userdata('userdata',$userdata);
    }
    function login(){
        $userdata   =   $this->get_cur_user_info();
        if(isset($userdata['login']) && $userdata['login'])
           return ;
        $url    = 'user/login';
        redirect($url);
    }
    function islogin(){
        $userdata   =   $this->get_cur_user_info();
        if(isset($userdata['login']) && $userdata['login'])
           return true;
        return false;
    }
    function logout()
    {  
        $userdata   =   $this->get_empty_user_info();
        $this->set_cur_user_info($userdata);
        redirect('user/login');
    }

    function output($msg='',$data = array()){
        $arry = array(
            'msg' => $msg,
            'data' => $data
        );
        echo json_encode($arry);
    }

}
?>