<?php
/**
 *  ... Please MODIFY this file ...
 *
 *
 *  YOUR MYSQL DATABASE DETAILS
 *
 */
require_once( __DIR__.'/../../../../../api/conf.php');
define("DB_HOST", 	$db['localhost']);				// hostname
 define("DB_USER", 	$db['user']);		// database username
 define("DB_PASSWORD", 	$db['pass']);		// database password
 define("DB_NAME", 	$db['db']);	// database name




/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional)", "etc...");
 */

$query = "select * from device_tb where hwid='$hwid';";
$res = run_sql($query);
$cryptobox_private_keys = array('58126AAUdHIDDash77DASHPRVG5RaI3etsBv563r2wu1RUF8B1');
$dash_private_key = "58126AAUdHIDDash77DASHPRVG5RaI3etsBv563r2wu1RUF8B1";
$dash_public_key = "58126AAUdHIDDash77DASHPUBEH4bj1QDKaar879dq9s0BA102";
if($res){
	$member_key = $res->owner;
	$query = "select * from member_tb where member_key='$member_key';";
    $res = run_sql($query);
   
    
    if($res){
    	if(is_array($res)){
	    		foreach ($res as $key => $value) {
	    		//print_r( $key);
	    		$dash_private_key = $value->dash_private_key;
		    	$dash_public_key = $value->dash_public_key;
				$cryptobox_private_keys = array($dash_private_key);
				break;
	    		}
    	}
    	else{
    		$dash_private_key = $res->dash_private_key;
		    	$dash_public_key = $res->dash_public_key;
				$cryptobox_private_keys = array($dash_private_key);
    	}
    }	
    
}
else{//testing
	$member_key = 'Avw2b666Zd33z2Kj';//admin
	$query = "select * from member_tb where member_key='$member_key';";
    $res = run_sql($query);
    if(is_array($res)){
	    		foreach ($res as $key => $value) {
	    		//print_r( $key);
	    		$dash_private_key = $value->dash_private_key;
		    	$dash_public_key = $value->dash_public_key;
				$cryptobox_private_keys = array($dash_private_key);
				break;
	    		}
    	}
    	else{
    		$dash_private_key = $res->dash_private_key;
		    	$dash_public_key = $res->dash_public_key;
				$cryptobox_private_keys = array($dash_private_key);
    	}
}

 define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
 unset($cryptobox_private_keys);
         
?>
