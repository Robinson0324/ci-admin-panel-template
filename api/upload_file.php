<?php

header('Access-Control-Allow-Origin: *' ) ;
$target_path = "../upload/encrypted/";

$filename = time()."--".$_FILES['file']['name'];
$target_file = $target_path . $filename;

if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
    echo $filename;
} else {
echo $target_file;
 echo "There was an error uploading the file, please try again!";
}
?>