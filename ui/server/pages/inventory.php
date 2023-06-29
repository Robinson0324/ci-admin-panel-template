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

$handler = new InventoryHandler($data,$userdata);
$job_handler = new JobHandler($data,$userdata);
$setting_handler = new SettingHandler($data,$userdata);

switch($action){
    case 'get_inventory_tb':
        $handler->get_inventory_tb();
        break;
    case 'register_new_job':
        $result = $job_handler->register_new_job();
        $data['JobRegDate']  =    $job_handler->JobRegDate;
        $handler->output(array(
            'msg' => ($result)?"処理が登録されました。":"登録が失敗しました。",
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
    case 'get_mws_info':
        $response = $setting_handler->get_mws_info($data['site']);
        $setting_handler->output(
            array(
                'msg' => 'Loaded!',
                'data' => $response
            )
        );
        break;
    default:
        break;
}