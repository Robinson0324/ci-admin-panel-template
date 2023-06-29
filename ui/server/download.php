<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/7/14
 * Time: 12:16 AM
 */
require_once __DIR__."/config.php";

// Database Connection
$host=DB_HOST;
$uname=DB_USER;
$pass=DB_PASSWORD;
$database = DB_NAME;

$connection=mysql_connect($host,$uname,$pass);

echo mysql_error();

//or die("Database Connection Failed");
$selectdb=mysql_select_db($database) or die("Database could not be selected");
$result=mysql_select_db($database) or die("database cannot be selected <br>");


// Fetch Record from Database

$output			= "";
$table 			= DB_RESULT_TABLE; // Enter Your Table Name
$sql 			= mysql_query("select asin,jan,title,artist,diff_price,list_price,lowest_price,rank,release_date,quantity,image_url from $table");
$columns_total 	= mysql_num_fields($sql);

// Get The Field Name

for ($i = 0; $i < $columns_total; $i++) {
    $heading	=	mysql_field_name($sql, $i);
    $output		.= '"'.$heading.'",';
}
$output .="\n";

// Get Records from the table

while ($row = mysql_fetch_array($sql)) {
    for ($i = 0; $i < $columns_total; $i++) {
        $output .='"'.$row["$i"].'",';
    }
    $output .="\n";
}

// Download the file

$filename =  "SearchResult.csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
exit;
