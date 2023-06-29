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

$handler = new OrdersHandler($data,$userdata);
$job_handler = new JobHandler($data,$userdata);
$setting_handler = new SettingHandler($data,$userdata);

switch($action){
    case 'get_orders_new_tb':
        $handler->get_orders_new_tb();
        break;
    case 'get_orders_input_tb':
        $handler->get_orders_input_tb();
        break;
    case 'get_orders_shipping_tb':
        $handler->get_orders_shipping_tb();
        break;
    case 'get_orders_shipping_complete_tb':
        $handler->get_orders_shipping_complete_tb();
        break;
    case 'get_orders_complete_tb':
        $handler->get_orders_complete_tb();
        break;
    case 'register_new_job':
        $result = $job_handler->register_new_job();
        $data['JobRegDate']  =    $job_handler->JobRegDate;
        $handler->output(array(
            'msg' => ($result)? $this->data['data_processing_success']:$this->data['data_processing_faild'],
            'data' => $data
        ));
        break;
    case 'get_product_status':
        $handler->get_product_status();
        break;
    case 'load_content_menu':
        $handler->load_content_menu();
        break;
    case 'set_new_order':
        $handler->set_new_order();
        break;
    case 'set_input_order':
        $handler->set_input_order();
        break;
    case 'set_shipping_ready_order':
        $handler->set_shipping_order();
        break;
    case 'set_shipping_complete_order':
        $handler->set_shipping_complete_order();
        break;
    case 'set_complete_order':
        $handler->set_complete_order();
        break;
   case 'set_order_info':
       $handler->set_order_info();
       break;
    case 'set_order_common_info':
        $handler->set_order_common_info();
        break;
    case 'save_shipping_confirm_info':
        $handler->save_shipping_confirm_info();
        break;
    case 'delete_order':
        $handler->delete_order();
        break;
    case 'init_set_info':
        $handler->init_set_info();
        break;
    case 'set_barcode_info':
        $handler->set_barcode_info();
        break;
    case 'set_individual_order_description':
        $handler->set_individual_order_description();
        break;
    case 'set_order_description':
        $handler->set_order_description();
        break;
    case 'get_job_status':

        $job_handler->get_job_status();
        break;
    case 'get_default_setting':
        $setting_handler->get_default_settings();
        break;
    case 'file_download':
        $handler->file_download();
        break;
    case 'get_order_info':
        $handler->get_order_info();
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