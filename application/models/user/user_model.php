<?php
//Hash class load
require_once FCPATH."/ui/server/class-phpass.php";

class user_model extends CI_Model {

   
    function __construct()
    {
        parent::__construct();
    }

    function get_all_user(){
        return $this->db->get(USER_TABLE)->result();
    }

    function get_devices($key){
        $this->db->where("owner" , $key);
        return $this->db->get('device_tb')->result();
    }

    public function get_user( $id ){
        $this->db->where("member_id" , $id);
        $res=$this->db->get(USER_TABLE);
        if($res && $res->num_rows()>0)
            return $res->result()[0];

        return false;
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
    function update_member_info($data,$condition)
    {
        /**
         *    output:  array->userid->region->,mws_access_key,mws_secret_key,merchantId,marketpaceId
         */
        $this->db->where($condition);
        $this->db->update(USER_TABLE,$data);
        $this->db->where($condition);
        $res=$this->db->get(USER_TABLE);
        if($res && $res->num_rows()>0)
            return $res->result()[0];

        return false;
    }
    function iphone_noti($ou_id, $msg, $u_id)
    {

       //code for iphone push notification
        $this->db->where('member_id', $ou_id);
        $q = $this->db->get(DB_USER_TABLE)->row_array();
        $this->db->where('member_id', $u_id);
        $rs = $this->db->get(DB_USER_TABLE)->row_array();

        $deviceToken = $q['iphone_device_id'];
        //test code

        //$deviceToken='16f5bcc9c4c0999a97fbb4e57f7b14ae10aadcc4e8671f30eea907afe2fcbc7f';//develop version
        //$deviceToken='b1fdd0241f46414c8b81b16a516ce868934d76563ae0109cbb271278487cf7d4';//release version
        //=====
        if (!empty($deviceToken)) {
            $passphrase = '';

            $ctx = stream_context_create();
            //stream_context_set_option($ctx, 'ssl', 'local_cert', 'api/DevCer.pem');
            stream_context_set_option($ctx, 'ssl', 'local_cert', 'api/ProCer.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

            // Open a connection to the APNS server
            $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 30, STREAM_CLIENT_CONNECT, $ctx);//release version
            if (!$fp) {
                return false;
            } else {
                // Create the payload body
                $body['aps'] = array(
                    'alert' => $rs['member_first_name'] . ' : ' . $msg,
                    'sound' => 'default',
                    'sender_id' => $u_id,
                    'badge' => 0,
                    'msg' => $rs['member_first_name'] . ' : ' . $msg

                );

                // Encode the payload as JSON
                $payload     = json_encode($body);
                // Build the binary notification
                $msg         = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                // Send it to the server
                $result = fwrite($fp, $msg, strlen($msg));
                fclose($fp);
                if (!empty($result)) {
                    return true;
                } else {
                    return false;
                }
                // Close the connection to the server
            }
        }
        //iphone push code ends
    }
    function iphone_noti_dev($ou_id, $msg, $u_id)
    {

        //code for iphone push notification
        $this->db->where('member_id', $ou_id);
        $q = $this->db->get(DB_USER_TABLE)->row_array();
        $this->db->where('member_id', $u_id);
        $rs = $this->db->get(DB_USER_TABLE)->row_array();

        $deviceToken = $q['iphone_device_id'];
        //test code
        //$deviceToken='com.johan.boomcup';
        //$deviceToken='16f5bcc9c4c0999a97fbb4e57f7b14ae10aadcc4e8671f30eea907afe2fcbc7f';//develop version
        //$deviceToken='b1fdd0241f46414c8b81b16a516ce868934d76563ae0109cbb271278487cf7d4';//release version
        //=====
        if (!empty($deviceToken)) {
            $passphrase = '';
            /*
            $fname='api/DevCer.pem';
            $fp=fopen($fname,'r');
            echo fread($fp,filesize($fname));
            fclose($fp);*/
            $ctx = stream_context_create();
            //stream_context_set_option($ctx, 'ssl', 'local_cert', 'api/DevCer.pem');
            stream_context_set_option($ctx, 'ssl', 'local_cert', 'api/DevCer.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

            // Open a connection to the APNS server

            //ssl://gateway.sandbox.push.apple.com:2195
            $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 30, STREAM_CLIENT_CONNECT, $ctx);//develop version
            //$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 30, STREAM_CLIENT_CONNECT, $ctx);//release version
            //echo "<pre>";print_r($fp);die;
            if (!$fp) {
                //exit("Failed to connect: $err $errstr" . PHP_EOL);
                return false;
            } else {
                //echo 'Connected to APNS' . PHP_EOL;

                // Create the payload body
                $body['aps'] = array(
                    'alert' => $rs['member_first_name'] . ' : ' . $msg,
                    'sound' => 'default',
                    'sender_id' => $u_id,
                    'badge' => 0,
                    'msg' => $rs['member_first_name'] . ' : ' . $msg

                );

                // Encode the payload as JSON
                $payload     = json_encode($body);
                //echo "<pre>";print_r($body);die;
                // Build the binary notification
                $msg         = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                // Send it to the server
                $result = fwrite($fp, $msg, strlen($msg));
                fclose($fp);
                //echo "<pre>";print_r($result);
                if (!empty($result)) {
                    //echo 'Message successfully delivered amar' . PHP_EOL;
                    return true;
                } else {
                    //echo 'Message not delivered' . PHP_EOL;
                    return false;
                }
                // Close the connection to the server


            }
        }
        //iphone push code ends
    }
}
?>