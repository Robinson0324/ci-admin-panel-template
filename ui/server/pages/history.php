<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 11:24 PM
 *
 * We will write all settings code
 */

require_once __DIR__."/../config.php";

$handler = new HistoryHandler($data,$userdata);

switch($action){

    case 'get_job_history_tb':
        $handler->get_job_history_tb();
        break;
    case 'get_file_upload_history_tb':
        $handler->get_file_upload_history_tb();
        break;
    default:
        $handler->output(array(
           'msg' => 'Invalid Action!',
            'data' => $data
        ));
        break;
}