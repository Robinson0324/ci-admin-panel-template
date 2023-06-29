<?php
/**
 * Created by PhpStorm.
 * User: Lockie.J
 * Date: 11/16/2020
 * Time: 9:57 PM
 */

class ProfileHandler
{
    public $data;
    public $user_data;

    function __construct($user_data = array())
    {
        $this->user_data = $user_data;
    }

    public function save_profile($data){
        $this->data['member_name'] = $data['username'];
        $this->data['member_email'] = $data['email'];
        $this->data['member_first_name'] = $data['first'];
        $this->data['member_last_name'] = $data['last'];
        $this->data['dash_address'] = $data['dashaddress'];

        $CI =   & get_instance();
        $CI->db->where('member_id', $this->user_data['id']);
        $CI->db->update(USER_TABLE,$this->data);
        $CI->db->where('member_id', $this->user_data['id']);
        $res=$CI->db->get(USER_TABLE)->result()[0];
        $res->msg = "Update Successful!";
        echo json_encode($res);
    }

    public function request_budget($data){
        $CI =   & get_instance();
        $query = "update member_tb set request_dash = 1 where member_email = '".$data['email']."';";
        $res = $CI->db->query($query);
        $result = array(
            "msg" => $res ? "Request Successful!" : "Request Failed!",
        );
        echo json_encode($result);
    }

    public function update_avatar($data){
        $this->data['member_avatar'] = $data['avatar'];

        $CI =   & get_instance();
        $CI->db->where('member_id', $this->user_data['id']);
        $CI->db->update(USER_TABLE,$this->data);
        $CI->db->where('member_id', $this->user_data['id']);
        $res=$CI->db->get(USER_TABLE)->result()[0];
        $res->msg = "Avatar updated successfully!";
        echo json_encode($res);
    }
}