<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 11:23 PM
 *
 * Product research
 */

require_once __DIR__."/../config.php";

$handler = new SubjectHandler($data,$userdata);
$job_handler = new JobHandler($data,$userdata);
//$setting_handler = new SettingHandler($data,$userdata);

switch($action){
    case 'get_research_tb':
	    $handler->get_research_tb();
        break;
    case 'file_insert_db':
        $handler->file_db_insert_handler();
        break;
    case 'register_new_job':
        $result = $job_handler->register_new_job();
        $data['JobRegDate']  =    $job_handler->JobRegDate;
        $handler->output(array(
            'msg' => ($result)?"Processing has been registered.":"Registration has failed.",
            'data' => $data
        ));
        break;
    case 'get_product_status':
        $handler->get_product_status();
        break;
    case 'get_job_status':
        $job_handler->get_job_status();
        break;
    case 'get_default_setting':
        $setting_handler->get_default_settings();
        break;
    case 'save_product_edit_info':
        $job_handler->save_product_edit_info();
        break;
    case 'get_product_info':
        $handler->get_product_info();
        break;
    case 'add_subject_infor':
        $handler->add_subject_infor();
        break;
    case 'exist_subject_name':
        $handler->exist_subject_name();
        break;
    case 'update_subject_infor':
        $handler->update_subject_infor();
        break;
    case 'delete_subject':
        $handler->delete_subject_infor();
        break;
    default:
        $handler->output(array('msg'=>'!','data'=>$data));
        break;
}