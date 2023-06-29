<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/7/14
 * Time: 6:10 AM
 */
require_once __DIR__."/config.php";
require_once __DIR__.'/class-phpass.php';
require_once __DIR__.'/PHPMailer/PHPMailerAutoload.php';

class UserManagement{
    public $db_con;
    public $lang;
    public $user_tables;
    public function __construct(){
        //db_connect
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $this->db_con = new PDO("mysql:host=$db_host;dbname=$db_name", DB_USER, DB_PASSWORD);
        //other setting
        $this->lang = $this->get_lang_data();
        //user tables format
        $this->user_tables = array();
    }
    public function get_user_list(){

        $strQuery = "SELECT * FROM ".DB_USER_TABLE." WHERE 1";
        $query = $this->db_con->prepare($strQuery);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        //get result array
        $list = $query->fetchAll();
        return $list;
    }

    public function is_exist_user($userinfo){
        $CI =   & get_instance();
       
        $strQuery = "SELECT * FROM ".DB_USER_TABLE." where member_email = '".$userinfo['member_email']."'";
        $res = $CI->db->query($strQuery);
        if($res){
             $results = $res->result();
            
             if(count($results) > 0){
                 foreach ($results as $key => $row) {
                    $row = (array) $row;
                     return $row;
                 }
            }
        } 
       
        if($userinfo['member_name']!==''){
                
            $strQuery = "SELECT * FROM ".DB_USER_TABLE." where member_name = '".$userinfo['member_name']."'";
            $res = $CI->db->query($strQuery);
            //print_r($results);
            if($res){
                $results = $res->result();
                if(count($results) > 0){
                 foreach ($results as $key => $row) {
                    $row = (array) $row;
                     return $row;
                 }
                }
            }
        }
        
        return false;
    }
    public function delete_user($user){
       
        $strQuery = "DELETE FROM ".DB_USER_TABLE." WHERE `member_id`='".$user['member_id']."'";
        $query = $this->db_con->prepare($strQuery);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();

        $userinfo['msg'] = "Remove Successful!";
        echo json_encode($userinfo);
        return true;
        //Delete mailing process
        $mail = array(
            'receiver_email'  =>  $user['member_email'],
            'receiver_name' =>  $user['member_email'],
            //'attach_image'  =>  'PHPMailer/contents/images/logo.png',
            'subject'  =>  $this->lang['lang_user_delete_inform'], //'ユーザー削除通知'
            'msg_body'  =>  "<strong>".$user['member_email']."</strong><p>".$this->lang['lang_thanks_for_use_to_now']."</p>"
        );
        $res =  $this->send_mail($mail);
        if($res){
            $list = $this->get_user_list();
            $res = array(
                'msg' => '<p>User '.$user['member_email'].' deleted!</p>',
                'list' => $list
            );
            $this->output($res);
        }else{
            $list = $this->get_user_list();
            $res = array(
                'msg' => 'Delete mail send failed!',
                'list' => $list
            );
            $this->output($res);
        }
    }
    public function allow_user($user){
        $strQuery = "UPDATE ".DB_USER_TABLE." SET `user_status`= 1  WHERE `member_email`='".$user['member_email']."'";
        $query = $this->db_con->prepare($strQuery);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        //User list output
        $list = $this->get_user_list();
        $res = array(
            'msg' => '<p>User '.$user['member_email'].' allowed!</p>',
            'list' => $list
        );
        $this->output($res);
    }

    function getRandomString($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public function register_user($user,$isMobile=false){
        //Password to wordpress hashed Password
        $wp_hasher = new PasswordHash(8, TRUE);
        $src_pass = $user['member_password'];
        $user['member_password'] =  $wp_hasher->HashPassword($src_pass);
        $user['member_key'] = $this->getRandomString(16);
        //INSERT INTO Customers (CustomerName, ContactName, Address, City, PostalCode, Country)
        //VALUES ('Cardinal','Tom B. Erichsen','Skagen 21','Stavanger','4006','Norway');
        $karry = $varry = array();
        foreach($user as $key => $val){
            $karry[] = $key;
            $varry[] = "'".$val."'";
        }
        $kstr = implode(",",$karry);
        $vstr = implode(",",$varry);

        $strQuery = "INSERT INTO ".DB_USER_TABLE." (".$kstr.") VALUES (".$vstr.")";
         
         $CI =   & get_instance();
         $results = $CI->db->query($strQuery);
       // print($strQuery);
        //Create user's info tables
        $user_id=0;
        $userinfo = $this->is_exist_user($user);
        
        if($userinfo)
        {
            $user_id = $userinfo['member_id'];
        }
        if($user_id===0)
            return false;
        $userinfo['msg'] = "Register Successful!";
        echo json_encode($userinfo);
        return true;
        // php mail sender process
        $mail = array(
            'receiver_email'  =>  $user['member_email'],
            'receiver_name' =>  $user['member_email'],
            //'attach_image'  =>  'PHPMailer/contents/images/logo.png',
            'subject'  =>  $this->lang['lang_user_register_inform'],//'ユーザー登録通知',
            'msg_body'  =>  '<p>'.$this->lang['lang_thanks_for_register'].'</p>

                            <p>'.$this->lang['lang_password'].': '.$src_pass.'</p>'
        );
        $res =  $this->send_mail($mail);
        if($res){
            $list = $this->get_user_list();
            $res = array(
                'msg' => '<p>'.$this->lang['lang_added_new_user'].'</p>
                        <p>'.$this->lang['lang_sent_register_mail'].'</p>',
                'list' => $list
            );
            if(!$isMobile)
                $this->output($res);
            else
                return true;
        }else{
            $list = $this->get_user_list();
            $res = array(
                'msg' => 'Register mail send failed!',
                'list' => $list
            );
            if(!$isMobile)
                $this->output($res);
            else
                return false;
        }
    }

    public function change_password($user , $user_data){
        //old password correct check

        $query = $this->db_con->prepare("SELECT * FROM user where member_email = ".$user['user_email']);
        $query->bindValue(":user", $user['user_email']);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $row = $query->fetch();
        //Password to wordpress hashed Password
        $wp_hasher = new PasswordHash(8, TRUE);
//        echo(json_encode($user_data));
        if($wp_hasher->CheckPassword($user['old_pass'], $user_data['passwd'])) {
            //Correct user
            $member_password =  $wp_hasher->HashPassword($user['new_pass']);
            //new password update
            $strQuery = "UPDATE ".DB_USER_TABLE." SET `member_password`= '".$member_password."'  WHERE `member_email`='".$user['user_email']."'";
            $query = $this->db_con->prepare($strQuery);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $msg = array(
                'msg' => $this->lang['lang_password_change_success'] //'パスワードの変更が成功しました。'
            );
            echo(json_encode($msg));
            //$this->output($msg);
        }else{
            //Incorrect user password
            $msg['msg'] = $this->lang['lang_not_match_old_password']; //'現在設定されてパスワード入力エラーです。'
            echo(json_encode($msg));
//            $this->output($msg);
        }
    }

    public function reset_request($user){
        $strQuery = "update member_tb set request_dash=0, budget=0 where member_email='".$user['member_email']."';";
        $query = $this->db_con->prepare($strQuery);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $userinfo['msg'] = "Request reset successfuly!";
        echo json_encode($userinfo);
    }

    public function reset_password($user){
        //Password to wordpress hashed Password
        $new_pass = $this->generate_new_code(15);
        $wp_hasher = new PasswordHash(8, TRUE);
        //Correct user
        $member_password =  $wp_hasher->HashPassword($user['member_password']);
        //new password update
        $strQuery = "UPDATE ".DB_USER_TABLE." SET `member_password`= '".$member_password."'  WHERE `member_email`='".$user['member_email']."'";
        $query = $this->db_con->prepare($strQuery);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        //send mailing process
        //php mail sender process
        $userinfo['msg'] = "Password reset as '".$strQuery."' successfuly!";
        echo json_encode($userinfo);
        return true;
        $mail = array(
            'receiver_email'  =>  $user['member_email'],
            'receiver_name' =>  $user['member_email'],
            //'attach_image'  =>  'PHPMailer/contents/images/logo.png',
            'subject'  =>  "Password Reset",//'ユーザーパスワードリセット通知',
            'msg_body'  =>  '<p>Your Password has been reset.</p>
                            <p>Your New Password : '.$new_pass.'</p>
                            <p>Please Login again and change your password if you want. Thanks.</p>'
        );
        $res =  $this->send_mail($mail);
        if($res){
            $userinfo['msg'] = json_encode($res);
            echo json_encode($userinfo);
//            $msg = array(
//                'msg' => '<p>'.$this->lang['lang_member_passwordword_has_reset'].'</p>
//                        <p>Email: '.$user['member_email'].'</p>
//                        <p>Password = '.$new_pass.'</p>'
//            );
//            $this->output($msg);
        }else{
            $userinfo['msg'] = "Password reset mail sent failed!";
            echo json_encode($userinfo);
        }
    }
    /**
     *	Generate New Random Code With length = 15
     */
    public function generate_new_code($lenth=15){
        $code ='';
        //do{
        // makes a random alpha numeric string of a given lenth
        $aZ09 = array_merge(range('A', 'Z'), range(0, 9));
        $lnk ='-';
        for($c=0;$c < $lenth;$c++)
        {
            $code .= $aZ09[mt_rand(0,count($aZ09)-1)];
        }
        //}while($this->is_Licensecode_exist($code));
        return $code;
    }

    public function output($arry){
        print_r(json_encode($arry));
    }

    /**
     *  Send email to user
     *
     * @param $mail = array(
     *  'receiver_email' => 'receiver@gmail.com'
     *  'sender_email' => 'sender@gmail.com'
     *  'subject' => 'Msg title'
     *  'msg_body'  => 'Msg body'
     * )
     * @return bool
     */
    public function send_mail($mail){

        /**
         * Contents setting variables
         */
        $receiver_email = $mail['receiver_email'];
        $receiver_name = $mail['receiver_name'];
        //$attach_image = $mail['attach_image'];
        $subject = $mail['subject'];
        $mail_body = $mail['msg_body'];

        // PHPMailer using
        date_default_timezone_set('Etc/UTC');

//Create a new PHPMailer instance
        $mail = new PHPMailer();

//Tell PHPMailer to use SMTP
        $mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

//Set the hostname of the mail server
        $mail->Host = MAIL_HOST;

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = MAIL_PORT;

//Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = MAIL_SMTP_SECURE;

//Whether to use SMTP authentication
        $mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = MAIL_OWNER_ADDR;

//Password to use for SMTP authentication
        $mail->Password = MAIL_PASSWORD;

//Set who the message is to be sent from
        $mail->setFrom( MAIL_FROM_USER_ADDR, MAIL_FROM_USER_NAME );

//Set an alternative reply-to address
//        $mail->addReplyTo('wjsskanyo@163.com', 'First 163 Last');

//Set who the message is to be sent to
        $mail->addAddress($receiver_email, $receiver_name);

//Set the subject line
        $mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->msgHTML($mail_body, dirname(__FILE__));

//Replace the plain text body with one created manually
        $mail->AltBody = $mail_body;

        $mail->CharSet="UTF-8";

//Attach an image file
        //$mail->addAttachment($attach_image);

//send the message, check for errors
        if (!$mail->send()) {
            return $mail->ErrorInfo;
        } else {
            return true;
        }
    }

    public function get_lang_data(){

        $CI =   & get_instance();
        $lang = $CI->lang_model->get_textdata();
        return $lang;
    }


}
