<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 11:23 PM
 *
 * Inventory management
 */

require_once __DIR__."/../config.php";

//$handler = new OrdersHandler($data,$userdata);
//$job_handler = new JobHandler($data,$userdata);
//$setting_handler = new SettingHandler($data,$userdata);
//echo json_encode($data);

$chatting_handler = new ChattingHandler();
$handler = new RansomlistHandler($data,$userdata);
switch($action){
	case 'get_ransomlist':
        $handler->get_ransomlist();
        break;
    case "send_message":
       
        if($data !== "")
           $chatting_handler->sendMessage($data);
        break;
    case "get_message":
        $chatting_handler->getMessage($data);
        break;
}