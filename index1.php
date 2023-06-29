<?php

$url = "http://".$_SERVER['HTTP_HOST']."/frontend/main";
$flag = false;
$cookie_name = "crc32"; 
$crc32 = "";
if(isset($_COOKIE[$cookie_name])) {
    $crc32 = $_COOKIE[$cookie_name];
    $flag = true;
}

if(isset($_GET['id']) && $_GET['id'] != "")
{
		$id = trim($_GET['id'],' ');
    if($id !== "user")
    {
      $url = $url."?id=".$id;
     	redirect($url);
    }
    else{
      if($flag) {
              $url = $url."?id=".$crc32;
              redirect($url);   
      }
    } 
}
else {
    if($flag) {
        $url = $url."?id=".$crc32;
        redirect($url);   
    }
}
redirect($url."/register");

function redirect($url) {
ob_start();
header('Location: '.$url);
ob_end_flush();
die();
}
?>