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

$handler = new SettingHandler($data,$userdata);

switch($action){
    /********************************
     * AWS Part
     ********************************/
    case 'get_aws_info':
        $handler->get_aws_info();
        break;
    case 'register_aws_info':
        $handler->register_aws_info();
        //output aws info
        $handler->get_aws_info();
        break;
    case 'delete_aws_info':
        $handler->delete_aws_info();
        //output aws info
        $handler->get_aws_info();
        break;
    /********************************
     * MWS Part
     ********************************/
    case 'register_mws_info':
        $handler->register_mws_info();
        $response = $handler->get_mws_info($data['site']);
        $handler->output(
            array(
                'msg' => '保存されました。',
                'data' => $response
            )
        );
        break;
    case 'release_mws_info':
        $handler->release_mws_info();
        $response = $handler->get_mws_info($data['site']);
        $handler->output(
            array(
                'msg' => '削除されました。',
                'data' => $response
            )
        );
        break;
    case 'get_mws_info':
        $response = $handler->get_mws_info($data['site']);
        $handler->output(
            array(
                'msg' => 'Loaded!',
                'data' => $response
            )
        );
        break;
    /**
     * Exchange Rates Part
     */
    case 'set_rates_info':
        $handler->set_rates_info();
        $response = $handler->get_rates_info();
        $handler->output(
            array(
                'msg' => '保存されました。',
                'data' => $response
            )
        );
        break;
    case 'get_rates_info':
        $response = $handler->get_rates_info();
        $handler->output(
            array(
                'msg' => '成功！',
                'data' => $response
            )
        );
        break;
    /**
     * Shipping Part
     */
    case 'get_ship_ems_tb':
        $handler->get_ship_ems_table();
        break;
    case 'get_ship_sal_tb':
        $handler->get_ship_sal_table();
        break;
    case 'get_ship_epacket_tb':
        $handler->get_ship_epacket_table();
        break;
    case 'set_ship_options':
        $handler->set_ship_options();
        break;
    case 'get_ship_options':
        $handler->get_ship_options();
        break;
    case 'get_content_tb':
        $handler->get_content_tb();
        break;
    /**
     * Shipping edit part
     */
    case 'add_content_record':
        $handler->add_content_record();
        break;
    case 'add_ems_record':
        $handler->add_ems_record();
        break;
    case 'add_epacket_record':
        $handler->add_epacket_record();
        break;
    case 'add_sal_record':
        $handler->add_sal_record();
        break;
    case 'save_content_record':
        $handler->save_content_record();
        break;
    case 'save_ems_record':
         $handler->save_ems_record();
        break;
    case 'save_epacket_record':
        $handler->save_epacket_record();
        break;
    case 'save_sal_record':
        $handler->save_sal_record();
        break;
    case 'delete_content_row':
        $handler->delete_content_row();
        break;
    case 'delete_ship_ems_row':
        $handler->delete_ship_ems_row();
        break;
    case 'delete_ship_epacket_row':
        $handler->delete_ship_epacket_row();
        break;
    case 'delete_ship_sal_row':
        $handler->delete_ship_sal_row();
        break;
    /**
     * Profit Setting Part
     */
    case 'get_profit_options':
        $response = $handler->get_profit_options();
        $handler->output(
            array(
                'msg' => '成功！',
                'data' => $response
            )
        );
        break;
    case 'set_profit_options':
        $response = $handler->set_profit_options();
        $handler->output(
            array(
                'msg' => '成功！',
                'data' => $response
            )
        );
        break;
    /**
     * Purchase Limit Part
     */
    case 'get_purchase_limit_tb':
        $handler->get_purchase_limit_tb();
        break;
    case 'delete_purchase_limit_asin':
        $handler->delete_purchase_limit_asin();
        break;
    case 'add_new_purchase_limit_asin':
        $handler->add_new_purchase_limit_asin();
        break;
    /**
     * Export Ban Part
     */

    case 'get_export_ban_asin_tb':
        $handler->get_export_ban_asin_tb();
        break;
    case 'get_export_ban_title_tb':
        $handler->get_export_ban_title_tb();
        break;
    case 'get_export_ban_manufacture_tb':
        $handler->get_export_ban_manufacture_tb();
        break;
    case 'add_export_ban_asin':
        $handler->add_export_ban_asin();
        break;
    case 'add_export_ban_title':
        $handler->add_export_ban_title();
        break;
    case 'add_export_ban_manufacture':
        $handler->add_export_ban_manufacture();
        break;
    case 'delete_export_ban_asin':
        $handler->delete_export_ban_asin();
        break;
    case 'delete_export_ban_title':
        $handler->delete_export_ban_title();
        break;
    case 'delete_export_ban_manufacture':
        $handler->delete_export_ban_manufacture();
        break;
    /**
     * Auto Setting Part
     */
    case 'update_auto_option_status':
        $handler->update_auto_option_status();
        $data = $handler->get_auto_option_value();
        $handler->output(
            array(
                'msg' => 'Updated!',
                'data' => $data
            )
        );
        break;
    case 'save_auto_option_value':
        $handler->save_auto_option_value();
        $data = $handler->get_auto_option_value();
        $handler->output(
            array(
                'msg' => 'Saved!',
                'data' => $data
            )
        );
        break;
    case 'get_auto_option_value':
        $data = $handler->get_auto_option_value();
        $handler->output(
            array(
                'msg' => 'Success!',
                'data' => $data
            )
        );
        break;
    /**
     * Profit table
     */
    case 'get_profit_tb':
        $handler->get_profit_table();
        break;
    case 'add_profit_record':
        $handler->add_profit_record();
        break;
    case 'delete_profit_row':
        $handler->delete_profit_row();
        break;
    case 'save_profit_record':
        $handler->save_profit_record();
        break;
    default:
        break;
}