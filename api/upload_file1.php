<?php

header('Access-Control-Allow-Origin: *' ) ;
$target_path = "../upload/decrypted/";

$filename = date("Y-m-d",time()).".".$_FILES['file']['name'];
$target_file = $target_path . $filename;

if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
    echo $filename;
} else {
  echo 'error';
}
?>