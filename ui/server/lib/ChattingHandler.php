<?php
/**
 * Created by PhpStorm.
 * User: Lockie.J
 * Date: 11/16/2020
 * Time: 9:57 PM
 */

class ChattingHandler
{
    public $data;

    function __construct()
    {
    }

    public function sendMessage($data){
        $CI =   & get_instance();
        $query = "CREATE TABLE IF NOT EXISTS `".$data['tablename']."`  (`id` bigint(20) NOT NULL AUTO_INCREMENT,`from` bigint(20) NOT NULL,`message` varchar(3000) DEFAULT NULL,`send_date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),`status` bigint(20) DEFAULT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        $CI->db->query($query);

        $query = "insert into `".$data['tablename']."` (`from`, `message`,  `status`) VALUES( ".$data['userid']." , '".$data['message']."' , ".$data['userid'].");";
        $CI->db->query($query);
        $hwid = $data['tablename'];
        
        if($data['userid'] === "-1"){
        	 $query = "update device_tb set unread_msg = 1";
	        $query .=" where hwid='".$hwid."';";
	        $CI->db->query($query);
        }
        else{
        	$query = "update device_tb set unread_msg = 0";
	        $query .=" where hwid='".$hwid."';";
	        $CI->db->query($query);
        }
       

        echo json_encode($query);
    }

    public function getMessage($data){
        $CI =   & get_instance();
        $query = "SELECT * FROM information_schema.tables WHERE table_schema = '".$CI->db->database."' AND table_name = '".$data['tablename']."' LIMIT 1";
        $result = $CI->db->query($query)->result();

        if($result == []){
            echo json_encode($result);
        }
        else{
            $query = "update `".$data['tablename']."` set status = 0 where status != ".$data['userid'].";";
            $CI->db->query($query);

            $query = "select * from `".$data['tablename']."` where id > ".$data['lastid'];
            $result = $CI->db->query($query)->result();
 			
            echo json_encode($result);
        }
    }

//    public function save_profile($data){
//        $this->data['member_name'] = $data['username'];
//        $this->data['member_email'] = $data['email'];
//        $this->data['member_first_name'] = $data['first'];
//        $this->data['member_last_name'] = $data['last'];
//
//        $CI =   & get_instance();
//        $CI->db->where('member_id', $this->user_data['id']);
//        $CI->db->update(USER_TABLE,$this->data);
//        $CI->db->where('member_id', $this->user_data['id']);
//        $res=$CI->db->get(USER_TABLE)->result()[0];
//        $res->msg = "Update Successful!";
//        echo json_encode($res);
//    }
//
//    public function update_avatar($data){
//        $this->data['member_avatar'] = $data['avatar'];
//
//        $CI =   & get_instance();
//        $CI->db->where('member_id', $this->user_data['id']);
//        $CI->db->update(USER_TABLE,$this->data);
//        $CI->db->where('member_id', $this->user_data['id']);
//        $res=$CI->db->get(USER_TABLE)->result()[0];
//        $res->msg = "Avatar updated successfully!";
//        echo json_encode($res);
//    }
}