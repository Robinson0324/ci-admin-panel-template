<?php
//Hash class load
require_once FCPATH."/ui/server/class-phpass.php";

class lang_model extends CI_Model {

   
    function __construct()
    {
        parent::__construct();
    }

    public  function get_textdata($lang='', $page='')
    {
        $data=  array();
       // echo $page;
        switch($page)
        {
            case 'ordersnew':
            {
                $data=  $this->orders_new_page_text($lang,$page);

                break;
            }
            case 'ordersinput':
            {
                $data=  $this->orders_input_page_text($lang,$page);

                break;
            }
            case 'ordersshipping':
            {
                $data=  $this->orders_shipping_page_text($lang,$page);

                break;
            }
            case 'ordersshippingcomplete':
            {
                $data=  $this->orders_shipping_complete_page_text($lang,$page);
                break;
            }
            case 'shippingconfirm':
            {
                $data=  $this->shippingconfirm_page_text($lang,$page);
                break;
            }
            case 'orderscomplete':
            {
                $data=  $this->orders_complete_page_text($lang,$page);

                break;
            }
        }
        //menu part
        $data['lang_toggle_navigation']= $this->lang->line('Toggle navigation');
        $data['lang_brand']= 'Amaze';
        $data['lang_user_profile'] = $this->lang->line('User Profile');
        $data['lang_setting'] = $this->lang->line('Setting');
        $data['lang_logout'] = $this->lang->line('Logout');
        $data['menu_research']='商品情報調査';
        $data['menu_inventory']='出品中商品';
        $data['menu_order']='注文管理';
        $data['menu_new_order']='新規受注';
        $data['menu_input_order']='入庫待ち';
        $data['menu_shipping_order']='出荷準備中';
        $data['menu_shipping_compete_order']='出荷準備完了';
        $data['menu_complete_order']='注文完了';
        $data['menu_setting']='設定';
        $data['menu_history']='記録';
       //========banner button====

        $data['banner_apply']= 'banner_apply';//適用:적용
        $data['banner_apply_process']= 'banner_apply_process';//適用中:적용중
       //===========action job  list
        $data['action_job_update_info']= '出品中商品インポート';
        $data['action_job_update_price']= '価格改定';
        $data['action_job_remove']= '削除';
        $data['action_job_move_to_import_ban']= '購入禁止';
        $data['action_job_move_to_export_ban']= '出品禁止';
        $data['action_job_release_from_import_ban']= '購入禁止解除';
        $data['action_job_release_from_export_ban']= '出品禁止解除';
        $data['action_job_bulk_list']= '一括出品';
        $data['action_job_bulk_remove']= '一括削除';
        $data['action_job_update_info_individual']= '個別商品更新';
        $data['action_job_individual_list']= '個別出品';
        $data['action_job_individual_revise']= '個別改定';
        $data['action_job_individual_list_stop']= '個別出品停止';
        $data['action_job_individual_remove']= '個別削除';
        $data['action_job_bulk_date_update']= '一括情報更新';
        $data['action_job_bulk_active_stop']= '一括出品停止';
        $data['action_job_auto_revise']= '自動価格改定';
        $data['action_job_bulk_relist']= '再出品';
        $data['action_job_calculate_profit']= '利益額計算';
        $data['action_job_auto_calculate_profit']= '自動利益額計算';
        $data['action_job_individual_order_profit_calculate']= '個別利益額計算';
        $data['action_job_excel_output']= 'Excel 出力';//エクセル出力
        $data['action_individual_package_output']= 'Individual Package Label 出力';//エクセル出力
        $data['action_individual_label_output']= 'Individual Reciving Label 出力';//エクセル出力
        $data['action_job_recive_label_output']= '納品書印刷';//견적서
        $data['action_job_package_label_output']= 'Package Label印刷';//청구서
        $data['action_job_post_output']= '宛名印刷';//우편물
        $data['action_job_cn22_output']= 'CN22印刷';//우편물
        $data['action_job_ems_output']= 'EMS＆SAL書留アドレスcsvファイル出力';//우편물
        $data['action_job_sal_track_output']= 'EMS＆SAL書留Item csvファイル出力';//우편물
        $data['action_job_content_register']= '内容品登録';//내용물등록
        $data['action_job_complete_price_table_output']= '後納料金表印刷';//내용물등록
        $data['action_job_delete']= '削除';
        $data['action_job_orders_table_download']= '注文資料ダウンロード';
        $data['action_job_orders_table_upload']= '注文資料アップロード';

        //========filter  list=========
        $data['filter_all']= '全体';
        $data['filter_research_all']= '調査商品全体';
        $data['filter_inventory_all']= '出品中商品全体';
        $data['filter_orders_new_all']= '新規受注商品全体';
        $data['filter_orders_input_all']= '入庫待ち商品全体';
        $data['filter_orders_shipping_all']= '未発送商品全体';
        $data['filter_orders_complete_all']= '注文完了商品全体';
        $data['filter_is_new']= '新品';
        $data['filter_is_used']= '中古';
        $data['filter_profit_plus']= '利益プラス';
        $data['filter_profit_minus']= '利益マイナス';
        $data['filter_export_ban']= '禁止商品';
        $data['filter_is_adult']= 'アダルト商品';
        $data['filter_is_listed']= '出品中商品';
        $data['filter_is_none_listed']= '出品前商品';
        $data['filter_is_ship_ems']= 'EMS配送商品';
        $data['filter_individual']= '個別商品';
        $data['filter_calculate']= '価格計算';
        $data['filter_is_stop']= '出品停止商品';
        $data['filter_list']= '個別出品';
        $data['filter_revise']= '個別改定';
        $data['filter_bulk_auto_revise']= '出品中の商品';
        $data['filter_is_none_price']= '販売価格の無い商品';
        $data['filter_us_unregistered']= '米国未登録商品';
        $data['filter_us_unregistered_listed']= '米国未登録商品';
        $data['filter_preorder']= '予定商品';
        $data['filter_order_profit_calculate']= '利益計算';
        $data['filter_purchase_complete']= '購入完了';
        $data['filter_purchase_incomplete']= '購入注文';
        $data['filter_input_complete']= '入庫待ち完了注文';
        $data['filter_input_incomplete']= ' 入庫待ち注文 ';
        $data['filter_shipping_complete']= '出荷準備完了注文';
        $data['filter_shipping_incomplete']= '出荷準備注文';
        $data['filter_order_complete']= '注文完了';
        $data['filter_order_incomplete']= '注文未完了';
        $data['filter_individual_package_output']= '個別Package out';
        $data['filter_individual_label_output']= '個別Package out';
        $data['filter_ems_orders']= 'EMS';
        $data['filter_sal_orders']= 'SAL';
        $data['filter_sal_track_orders']= 'SAL書留';
        $data['filter_sal_air_orders']= 'SAL航空便';
        //dashboard page
        $data['lang_dashboard'] = 'Dashboard';

        //login page
        $data['Login']= $this->lang->line('Login');
        $data['Sign_up']= $this->lang->line('Sign up');
        $data['Remember_Me']= $this->lang->line('Remember Me');
        $data['Please_Sign_In']= $this->lang->line('Please Sign In');

        $data['lang_signup'] = $this->lang->line("Sign up");
        $data['lang_plz_signup'] = $this->lang->line("Please Sign up");
        $data['lang_login']= $this->lang->line('Login');


        //manage page
        $data['lang_user_management']= $this->lang->line('User Management');
        $data['lang_user_list']= $this->lang->line('User List');
        $data['lang_register_date']= $this->lang->line('Register Date');
        $data['lang_role']= $this->lang->line('User Role');
        $data['lang_action']= $this->lang->line('Action');
        $data['lang_add_new_user']= $this->lang->line('Add new user');
        $data['lang_password']= $this->lang->line('Password');
        $data['lang_new_password']= $this->lang->line('New password');
        $data['lang_confirm_password']= $this->lang->line('Confirm password');
        $data['lang_user']= $this->lang->line('User');
        $data['lang_manager']= $this->lang->line('Manager');
        $data['lang_password_reset']= $this->lang->line('Password Reset');
        $data['lang_user_delete']= $this->lang->line('User Delete');
        $data['lang_save'] = $this->lang->line('Save');
        $data['lang_user_allow'] = $this->lang->line('User Allow');

        //server messages
        $data['lang_user_delete_inform']= $this->lang->line('User Delete Inform');
        $data['lang_thanks_for_use_to_now']= $this->lang->line('Thanks for using by now!');

        $data['lang_user_register_inform']= $this->lang->line('User Registration Inform');
        $data['lang_thanks_for_register']= $this->lang->line('Thanks for register!');
        $data['lang_sent_register_mail']= $this->lang->line('We had sent a registration notification mail to the user.');

        $data['lang_added_new_user']= $this->lang->line('New User Added');
        $data['lang_user_delete_inform']= $this->lang->line('User Delete Inform');

        $data['lang_password_change_success']= $this->lang->line('The password change was successful.');
        $data['lang_not_match_old_password']= $this->lang->line('Not match old password');
        $data['lang_user_password_reset_inform']= $this->lang->line('User password reset notification');

        $data['lang_user_password_has_reset']= $this->lang->line('User password has reset');
        $data['lang_your_password']= $this->lang->line('Your Password');
        $data['lang_plz_login_and_change_your_password']= $this->lang->line('Please login and change your password!');

        //product page
        $data['lang_product'] = $this->lang->line('Product');///
        $data['lang_products'] = $this->lang->line('Products');///
        $data['lang_japan_asin'] =$this->lang->line('Japan ASIN');///
        $data['lang_world_asin'] =$this->lang->line('World ASIN');///
        $data['lang_no']=$this->lang->line('No');
        $data['lang_asin']=$this->lang->line('ASIN');
        $data['lang_information']=$this->lang->line('Information');
        $data['lang_title']=$this->lang->line('Title');
        $data['lang_manufacture']=$this->lang->line('Manufacture');
        $data['lang_category']=$this->lang->line('Category');
        $data['lang_release_date']=$this->lang->line('Release Date');
        $data['lang_size']=$this->lang->line('Size');

        //setting page
        $data['lang_settings'] = $this->lang->line('Settings');
        //setting add
        $data['lang_exchange']=$this->lang->line('Exchange');
        $data['lang_setup']=$this->lang->line('Setup');
        $data['lang_shipping_charges_set']= $this->lang->line('Shipping Charges Set');
        $data['lang_profit']=$this->lang->line('Profit');
        $data['lang_setting']=$this->lang->line('Setting');
        $data['lang_purchase_limit']=$this->lang->line('Purchase Limit');
        $data['lang_asin_edit']=$this->lang->line('ASIN Edit');
        $data['lang_register']=$this->lang->line('Register');
        $data['lang_release']=$this->lang->line('Release');
        $data['lang_reset']=$this->lang->line('Reset');
        $data['lang_add']=$this->lang->line('Add');

        $data['lang_eur']=$this->lang->line('EUR');
        $data['lang_usa']=$this->lang->line('USA');
        $data['lang_max_weight']=$this->lang->line('Weight Max');
        $data['lang_min_weight']=$this->lang->line('Weight Min');
        $data['lang_save']=$this->lang->line('Save');
        $data['lang_cancel']=$this->lang->line('Cancel');
        $data['lang_price']=$this->lang->line('Price');
        $data['lang_action']=$this->lang->line('Action');
        $data['lang_proit']=$this->lang->line('Profit');
        $data['lang_amount']=$this->lang->line('Amount');
        $data['lang_percent']=$this->lang->line('Percent');
        $data['lang_profit_amount']=$this->lang->line('Profit Amount');
        $data['lang_profit_percent']=$this->lang->line('Profit Percent');
        $data['lang_plz_enter_limit_asin']=$this->lang->line('Please enter the ASIN that you want to buy limit!');
        $data['lang_asin']=$this->lang->line('ASIN');
        $data['lang_product_name']=$this->lang->line('Product Name');
        $data['lang_manufacturer']=$this->lang->line('Manufacturer');
        $data['lang_restrict_days']=$this->lang->line('Restrict Days');
        $data['lang_show_all_buy_limit_products']=$this->lang->line('Show all buy limit products');
        $data['lang_remain_days']=$this->lang->line('Remain Days');
        $data['lang_plz_enter_edit_asin']=$this->lang->line('Please enter the ASIN that you want to edit!');
        $data['lang_search']=$this->lang->line('Search');
        $data['lang_categoy']=$this->lang->line('Category');
        $data['lang_weight']=$this->lang->line('Weight');
        $data['lang_height']=$this->lang->line('Height');
        $data['lang_length']=$this->lang->line('Length');
        $data['lang_width']=$this->lang->line('Width');
        $data['lang_image']=$this->lang->line('Image');

        //server messages
        $data['lang_added_new_item'] = $this->lang->line('New item added.');
        $data['lang_release'] = $this->lang->line('Release');
        $data['lang_setting'] = $this->lang->line('Setting');
        $data['lang_exchange'] = $this->lang->line('Exchange');
        $data['lang_success'] = $this->lang->line('Success');
        $data['lang_set'] = $this->lang->line('Set');
        $data['lang_get'] = $this->lang->line('Get');
        $data['lang_getting'] = $this->lang->line('Getting');
        $data['lang_info'] = $this->lang->line('Info');
        $data['lang_delete'] = $this->lang->line('Delete');
        $data['lang_all_asin_info_get_success'] = $this->lang->line('All ASIN info get success!');
        $data['lang_saved'] = $this->lang->line('Saved');
        $data['lang_not_found'] = $this->lang->line('Not Found');
        $data['lang_update'] = $this->lang->line('Update');

        //upload page
        $data['lang_upload'] = $this->lang->line('Upload');
        $data['lang_csv_upload']=$this->lang->line('CSV upload');
        $data['lang_add_files']=$this->lang->line('Add files');
        $data['lang_start_upload']=$this->lang->line('Start upload');
        $data['lang_cancel_upload']=$this->lang->line('Cancel upload');
        $data['lang_delete']=$this->lang->line('Delete');
        $data['lang_ready']=$this->lang->line('Ready');

        $data['lang_page']=$this->lang->line('Page');
        $data['lang_usage']=$this->lang->line('Usage');
        $data['lang_data_has_been_entered']=$this->lang->line('Data has been entered.');
        $data['lang_there_is_no_input_data']=$this->lang->line('There is no input data.');
        $data['lang_start']=$this->lang->line('Start');
        $data['lang_cancel']=$this->lang->line('Cancel');
        $data['lang_delete']=$this->lang->line('Delete');

        //blank page
        $data['lang_blank']=$this->lang->line('Blank');
        $data['lang_user_list']=$this->lang->line('User List');
        $data['lang_user_session_info']=$this->lang->line('User Session Info');
        $data['lang_field']=$this->lang->line('Field');
        $data['lang_value']=$this->lang->line('Value');

        //update page
        $data['lang_product_update'] =  $this->lang->line("Update");
        $data['lang_daily'] =  $this->lang->line("Daily");
        $data['lang_times'] =  $this->lang->line("Times per day");
        $data['lang_status_save'] =  $this->lang->line("Status Save");
        $data['lang_revise_start'] =  $this->lang->line("Revise Start");
        $data['lang_revise_result_table'] =  $this->lang->line("Revise Result Table");
        $data['lang_revise_setting'] =  $this->lang->line("Revise Setting");
        $data['lang_no_selected'] =  $this->lang->line("Not selected");
        $data['lang_revise_status'] =  $this->lang->line("Revise Status");
        $data['lang_now_revising'] =  $this->lang->line("Now Revising!");
        $data['lang_revise_stopped'] =  $this->lang->line("Revise stopped");
        $data['lang_revise_stop'] =  $this->lang->line("Revise Stop");

        //profile page
        $data['lang_profile'] =  $this->lang->line('Profile');

        //MWS setting part
        $data['lang_my_mws_settings'] = $this->lang->line("My MWS Settings");
        $data['lang_mws_info'] = $this->lang->line("MWS Info");
        $data['lang_site'] = $this->lang->line("Site");
        $data['lang_access_key'] = $this->lang->line("Access Key");
        $data['lang_security_key'] = $this->lang->line("Security Key");
        $data['lang_merchant_id'] = $this->lang->line("Merchant ID");
        $data['lang_marketplace_id'] = $this->lang->line("Marketplace ID");
        $data['lang_error'] = $this->lang->line("Error");

        $data['records_per_page'] = $this->lang->line("records per page");

        //20141014
        $data['lang_lowest_price'] = $this->lang->line("Lowest Price");
        $data['lang_list_price'] = $this->lang->line("List Price");
        $data['lang_ship_price'] = $this->lang->line("Ship Price");
        //20141016
        $data['lang_US_information'] = $this->lang->line("US Info");
        $data['lang_JP_information'] = $this->lang->line("JP Info");
        $data['lang_auto_revise'] = $this->lang->line("Auto Revise");

        $data['lang_revise_result_table'] = $this->lang->line("Revise Result Table");

        $data['lang_there_is_no_items'] = $this->lang->line("There is no items.");
        $data['lang_previous'] = "Previous";
        $data['lang_next'] = "Next";


        $data['lang_data_insert_success'] = $this->lang->line(" data insert success");
        $data['lang_data_src_table_create_error'] = $this->lang->line("Data source table create error!");
        $data['lang_invalid_file_format'] = $this->lang->line("invalid file format");
        $data['lang_asin_field_no_exist'] = $this->lang->line("ASIN field no exist!");
        $data['lang_file_no_exist'] = $this->lang->line("File no exist!");
        $data['lang_inserting'] = $this->lang->line("Inserting...");

        $data['lang_now_auto_revise'] = $this->lang->line("Auto Revising Activated");
        $data['lang_now_revise_stop'] = $this->lang->line("Auto Revising Stopped");
        $data['lang_last_revise_date'] = $this->lang->line("Last Revise Date");

        $data['lang_aws_info'] = $this->lang->line("AWS Info");

        $data['lang_number_of_sellers'] = $this->lang->line("Number Of Sellers");
        $data['lang_lowest_price'] = $this->lang->line("Lowest Price");
        $data['lang_lowest_ship_price'] = $this->lang->line("Lowest Ship Price");
        $data['lang_rank'] = $this->lang->line("Rank");

        $data['lang_carry_price'] = $this->lang->line("Carry Price");


        $data['lang_daily_times'] =  $this->lang->line("Daily Times");
        $data['lang_listing_product'] =  $this->lang->line("Listing Products");
        $data['lang_csv_product_info'] =  $this->lang->line("CSV Products Information");

        $data['lang_pric_calculate'] =  $this->lang->line("Price calculate");

        $data['lang_shipping_mode'] =  $this->lang->line("Shipping Mode");
        $data['lang_size'] =  $this->lang->line("Size");

        $data['lang_registered_date'] =  $this->lang->line("Registered Date");
        $data['lang_total'] =  $this->lang->line("Total");
        $data['lang_from'] =  $this->lang->line("From");

        $data['lang_apply_alert'] =  $this->lang->line("lang_apply_alert");

        return $data;
    }
    private function orders_new_page_text($lang,$page)
    {

        $this->lang->load($page,$lang);
        $data = array();
        $data['title']   =   $this->lang->line('title');
        $data['management']   =   $this->lang->line('management');
        $data['keyword']   =   $this->lang->line('keyword');
        $data['search']   =   $this->lang->line('search');
        $data['filter']   =   $this->lang->line('filter');
        $data['all']   =   $this->lang->line('all');
        $data['new_product']   =   $this->lang->line('new_product');
        $data['used_product']   =   $this->lang->line('used_product');
        $data['action']   =   $this->lang->line('action');
        $data['user']   =   $this->lang->line('user');
        $data['no']   =   $this->lang->line('no');
        $data['apply']   =   $this->lang->line('apply');
        $data['apply_process']   =   $this->lang->line('apply_process');
        $data['Previous']   =   $this->lang->line('Previous');
        $data['Next']   =   $this->lang->line('Next');
        $data['First']   =   $this->lang->line('First');
        $data['Last']   =   $this->lang->line('Last');
        $data['no_tabledata']   =   $this->lang->line('no_tabledata');
        $data['no_presentitem']   =   $this->lang->line('no_presentitem');
        $data['data_processing']   =   $this->lang->line('data_processing');
        $data['filtering']   =   $this->lang->line('filtering');
        $data['no_data']   =   $this->lang->line('no_data');
        $data['number_detect']   =   $this->lang->line('number_detect');
        $data['displaybyline']   =   $this->lang->line('displaybyline');
        $data['page']   =   $this->lang->line('page');
        $data['vie']   =   $this->lang->line('vie');
        $data['total']   =   $this->lang->line('total');
        $data['delete']   =   $this->lang->line('delete');
        $data['modify']   =   $this->lang->line('modify');
        $data['percent']   =   $this->lang->line('percent');

        //=========table header content=========
        $data['order_id']   =   $this->lang->line('order_id');
        $data['order_date']   =   $this->lang->line('order_date');
        $data['ship_date']   =   $this->lang->line('ship_date');

        $data['product_title']   =   $this->lang->line('product_title');
        $data['product_image']   =   $this->lang->line('product_image');

        $data['asin']   =   $this->lang->line('asin');
        $data['jan']   =   $this->lang->line('jan');
        $data['sku']   =   $this->lang->line('sku');
        $data['condition']   =   $this->lang->line('condition');

        $data['shipping_status']   =   $this->lang->line('shipping_status');
        $data['shipping_service_level']   =   $this->lang->line('shipping_service_level');
        $data['buyer_name']   =   $this->lang->line('buyer_name');
        $data['buyer_phone']   =   $this->lang->line('buyer_phone');


        $data['ship_name']   =   $this->lang->line('ship_name');
        $data['ship_address']   =   $this->lang->line('ship_address');
        $data['ship_city']   =   $this->lang->line('ship_city');
        $data['ship_state']   =   $this->lang->line('ship_state');
        $data['postal_code']   =   $this->lang->line('postal_code');
        $data['ship_country']   =   $this->lang->line('ship_country');


        $data['purchase_price']   =   $this->lang->line('purchase_price');
        $data['international_price']   =   $this->lang->line('international_price');
        $data['international_mode']   =   $this->lang->line('international_mode');
        $data['sell_price']   =   $this->lang->line('sell_price');
        $data['sell_ship_price']   =   $this->lang->line('sell_ship_price');
        $data['stock']   =   $this->lang->line('stock');
        $data['score']   =   $this->lang->line('score');
        $data['profit']   =   $this->lang->line('profit');
        $data['fee']   =   $this->lang->line('fee');
        $data['Weight']   =   $this->lang->line('Weight');
        $data['Height']   =   $this->lang->line('Height');
        $data['Length']   =   $this->lang->line('Length');
        $data['Width']   =   $this->lang->line('Width');
        $data['product_comment']   =   $this->lang->line('product_comment');

        //==========button=======
        $data['order_data_edit']   =   $this->lang->line('order_data_edit');
        $data['this_save']   =   $this->lang->line('this_save');
        $data['complete_purchase']   =   $this->lang->line('complete_purchase');
        //====================

        $data['calculate_profit']   =   $this->lang->line('calculate_profit');
        $data['calculate_profit_process']   =   $this->lang->line('calculate_profit_process');
        $data['data_processing_success']   =   $this->lang->line('data_processing_success');
        $data['data_processing_faild']   =   $this->lang->line('data_processing_faild');
        //=========model============
        $data['order_new_edit_title']   =   $this->lang->line('order_new_edit_title');


        return $data;
    }

    private function orders_input_page_text($lang,$page)
    {

        $this->lang->load($page,$lang);
        $data = array();
        $data['title']   =   $this->lang->line('title');
        $data['management']   =   $this->lang->line('management');
        $data['keyword']   =   $this->lang->line('keyword');
        $data['search']   =   $this->lang->line('search');
        $data['filter']   =   $this->lang->line('filter');
        $data['all']   =   $this->lang->line('all');
        $data['new_product']   =   $this->lang->line('new_product');
        $data['used_product']   =   $this->lang->line('used_product');
        $data['action']   =   $this->lang->line('action');
        $data['user']   =   $this->lang->line('user');
        $data['no']   =   $this->lang->line('no');
        $data['apply']   =   $this->lang->line('apply');
        $data['apply_process']   =   $this->lang->line('apply_process');
        $data['Previous']   =   $this->lang->line('Previous');
        $data['Next']   =   $this->lang->line('Next');
        $data['First']   =   $this->lang->line('First');
        $data['Last']   =   $this->lang->line('Last');
        $data['no_tabledata']   =   $this->lang->line('no_tabledata');
        $data['no_presentitem']   =   $this->lang->line('no_presentitem');
        $data['data_processing']   =   $this->lang->line('data_processing');
        $data['filtering']   =   $this->lang->line('filtering');
        $data['no_data']   =   $this->lang->line('no_data');
        $data['number_detect']   =   $this->lang->line('number_detect');
        $data['displaybyline']   =   $this->lang->line('displaybyline');
        $data['page']   =   $this->lang->line('page');
        $data['vie']   =   $this->lang->line('vie');
        $data['total']   =   $this->lang->line('total');
        $data['delete']   =   $this->lang->line('delete');
        $data['modify']   =   $this->lang->line('modify');
        $data['percent']   =   $this->lang->line('percent');
        $data['barcode_check']   =   $this->lang->line('barcode_check');
        $data['product_comment']   =   $this->lang->line('product_comment');

        //=========table header content=========
        $data['order_id']   =   $this->lang->line('order_id');
        $data['order_date']   =   $this->lang->line('order_date');
        $data['ship_date']   =   $this->lang->line('ship_date');

        $data['product_title']   =   $this->lang->line('product_title');
        $data['product_image']   =   $this->lang->line('product_image');

        $data['asin']   =   $this->lang->line('asin');
        $data['jan']   =   $this->lang->line('jan');
        $data['sku']   =   $this->lang->line('sku');
        $data['condition']   =   $this->lang->line('condition');

        $data['shipping_status']   =   $this->lang->line('shipping_status');
        $data['shipping_service_level']   =   $this->lang->line('shipping_service_level');
        $data['buyer_name']   =   $this->lang->line('buyer_name');
        $data['buyer_phone']   =   $this->lang->line('buyer_phone');


        $data['ship_name']   =   $this->lang->line('ship_name');
        $data['ship_address']   =   $this->lang->line('ship_address');
        $data['ship_city']   =   $this->lang->line('ship_city');
        $data['ship_state']   =   $this->lang->line('ship_state');
        $data['postal_code']   =   $this->lang->line('postal_code');
        $data['ship_country']   =   $this->lang->line('ship_country');


        $data['purchase_price']   =   $this->lang->line('purchase_price');
        $data['international_price']   =   $this->lang->line('international_price');
        $data['international_mode']   =   $this->lang->line('international_mode');
        $data['sell_price']   =   $this->lang->line('sell_price');
        $data['sell_ship_price']   =   $this->lang->line('sell_ship_price');
        $data['stock']   =   $this->lang->line('stock');
        $data['score']   =   $this->lang->line('score');
        $data['profit']   =   $this->lang->line('profit');
        $data['fee']   =   $this->lang->line('fee');
        $data['Weight']   =   $this->lang->line('Weight');
        $data['Height']   =   $this->lang->line('Height');
        $data['Length']   =   $this->lang->line('Length');
        $data['Width']   =   $this->lang->line('Width');

        //==========button=======
        $data['order_data_edit']   =   $this->lang->line('order_data_edit');
        $data['this_save']   =   $this->lang->line('this_save');
        $data['complete_purchase']   =   $this->lang->line('complete_purchase');
        $data['complete_input']   =   $this->lang->line('complete_input');
        $data['label_output']   =   $this->lang->line('label_output');
        $data['label_output_process']   =   $this->lang->line('label_output_process');
        $data['package_output']   =   $this->lang->line('package_output');
        $data['package_output_process']   =   $this->lang->line('package_output_process');
        //====================

        $data['calculate_profit']   =   $this->lang->line('calculate_profit');
        $data['calculate_profit_process']   =   $this->lang->line('calculate_profit_process');
        $data['data_processing_success']   =   $this->lang->line('data_processing_success');
        $data['data_processing_faild']   =   $this->lang->line('data_processing_faild');
        //=========model============
        $data['order_new_edit_title']   =   $this->lang->line('order_new_edit_title');


        return $data;
    }
    private function orders_shipping_page_text($lang,$page)
    {

        $this->lang->load($page,$lang);
        $data = array();
        $data['title']   =   $this->lang->line('title');
        $data['management']   =   $this->lang->line('management');
        $data['keyword']   =   $this->lang->line('keyword');
        $data['search']   =   $this->lang->line('search');
        $data['filter']   =   $this->lang->line('filter');
        $data['all']   =   $this->lang->line('all');
        $data['new_product']   =   $this->lang->line('new_product');
        $data['used_product']   =   $this->lang->line('used_product');
        $data['action']   =   $this->lang->line('action');
        $data['user']   =   $this->lang->line('user');
        $data['no']   =   $this->lang->line('no');
        $data['apply']   =   $this->lang->line('apply');
        $data['apply_process']   =   $this->lang->line('apply_process');
        $data['Previous']   =   $this->lang->line('Previous');
        $data['Next']   =   $this->lang->line('Next');
        $data['First']   =   $this->lang->line('First');
        $data['Last']   =   $this->lang->line('Last');
        $data['no_tabledata']   =   $this->lang->line('no_tabledata');
        $data['no_presentitem']   =   $this->lang->line('no_presentitem');
        $data['data_processing']   =   $this->lang->line('data_processing');
        $data['filtering']   =   $this->lang->line('filtering');
        $data['no_data']   =   $this->lang->line('no_data');
        $data['number_detect']   =   $this->lang->line('number_detect');
        $data['displaybyline']   =   $this->lang->line('displaybyline');
        $data['page']   =   $this->lang->line('page');
        $data['vie']   =   $this->lang->line('vie');
        $data['total']   =   $this->lang->line('total');
        $data['delete']   =   $this->lang->line('delete');
        $data['modify']   =   $this->lang->line('modify');
        $data['percent']   =   $this->lang->line('percent');
        $data['barcode_check']   =   $this->lang->line('barcode_check');
        //=========table header content=========
        $data['order_id']   =   $this->lang->line('order_id');
        $data['order_date']   =   $this->lang->line('order_date');
        $data['ship_date']   =   $this->lang->line('ship_date');

        $data['product_title']   =   $this->lang->line('product_title');
        $data['product_image']   =   $this->lang->line('product_image');

        $data['asin']   =   $this->lang->line('asin');
        $data['jan']   =   $this->lang->line('jan');
        $data['sku']   =   $this->lang->line('sku');
        $data['condition']   =   $this->lang->line('condition');

        $data['shipping_status']   =   $this->lang->line('shipping_status');
        $data['shipping_service_level']   =   $this->lang->line('shipping_service_level');
        $data['buyer_name']   =   $this->lang->line('buyer_name');
        $data['buyer_phone']   =   $this->lang->line('buyer_phone');


        $data['ship_name']   =   $this->lang->line('ship_name');
        $data['ship_address']   =   $this->lang->line('ship_address');
        $data['ship_city']   =   $this->lang->line('ship_city');
        $data['ship_state']   =   $this->lang->line('ship_state');
        $data['postal_code']   =   $this->lang->line('postal_code');
        $data['ship_country']   =   $this->lang->line('ship_country');


        $data['purchase_price']   =   $this->lang->line('purchase_price');
        $data['international_price']   =   $this->lang->line('international_price');
        $data['international_mode']   =   $this->lang->line('international_mode');
        $data['sell_price']   =   $this->lang->line('sell_price');
        $data['sell_ship_price']   =   $this->lang->line('sell_ship_price');
        $data['stock']   =   $this->lang->line('stock');
        $data['score']   =   $this->lang->line('score');
        $data['profit']   =   $this->lang->line('profit');
        $data['fee']   =   $this->lang->line('fee');
        $data['Weight']   =   $this->lang->line('Weight');
        $data['Height']   =   $this->lang->line('Height');
        $data['Length']   =   $this->lang->line('Length');
        $data['Width']   =   $this->lang->line('Width');
        $data['product_comment']   =   $this->lang->line('product_comment');

        //==========button=======
        $data['order_data_edit']   =   $this->lang->line('order_data_edit');
        $data['this_save']   =   $this->lang->line('this_save');
        $data['complete_shipping']   =   $this->lang->line('complete_shipping');
        $data['complete_input']   =   $this->lang->line('complete_input');

        //====================

        $data['calculate_profit']   =   $this->lang->line('calculate_profit');
        $data['calculate_profit_process']   =   $this->lang->line('calculate_profit_process');
        $data['data_processing_success']   =   $this->lang->line('data_processing_success');
        $data['data_processing_faild']   =   $this->lang->line('data_processing_faild');
        //=========model============
        $data['order_new_edit_title']   =   $this->lang->line('order_new_edit_title');


        return $data;
    }
    private function orders_shipping_complete_page_text($lang,$page)
    {

        $this->lang->load($page,$lang);
        $data = array();
        $data['title']   =   $this->lang->line('title');
        $data['management']   =   $this->lang->line('management');
        $data['keyword']   =   $this->lang->line('keyword');
        $data['search']   =   $this->lang->line('search');
        $data['filter']   =   $this->lang->line('filter');
        $data['all']   =   $this->lang->line('all');
        $data['new_product']   =   $this->lang->line('new_product');
        $data['used_product']   =   $this->lang->line('used_product');
        $data['action']   =   $this->lang->line('action');
        $data['user']   =   $this->lang->line('user');
        $data['no']   =   $this->lang->line('no');
        $data['apply']   =   $this->lang->line('apply');
        $data['apply_process']   =   $this->lang->line('apply_process');
        $data['Previous']   =   $this->lang->line('Previous');
        $data['Next']   =   $this->lang->line('Next');
        $data['First']   =   $this->lang->line('First');
        $data['Last']   =   $this->lang->line('Last');
        $data['no_tabledata']   =   $this->lang->line('no_tabledata');
        $data['no_presentitem']   =   $this->lang->line('no_presentitem');
        $data['data_processing']   =   $this->lang->line('data_processing');
        $data['filtering']   =   $this->lang->line('filtering');
        $data['no_data']   =   $this->lang->line('no_data');
        $data['number_detect']   =   $this->lang->line('number_detect');
        $data['displaybyline']   =   $this->lang->line('displaybyline');
        $data['page']   =   $this->lang->line('page');
        $data['vie']   =   $this->lang->line('vie');
        $data['total']   =   $this->lang->line('total');
        $data['delete']   =   $this->lang->line('delete');
        $data['modify']   =   $this->lang->line('modify');
        $data['percent']   =   $this->lang->line('percent');
        $data['barcode_check']   =   $this->lang->line('barcode_check');
        //=========table header content=========
        $data['order_id']   =   $this->lang->line('order_id');
        $data['order_date']   =   $this->lang->line('order_date');
        $data['ship_date']   =   $this->lang->line('ship_date');

        $data['product_title']   =   $this->lang->line('product_title');
        $data['product_image']   =   $this->lang->line('product_image');

        $data['asin']   =   $this->lang->line('asin');
        $data['jan']   =   $this->lang->line('jan');
        $data['sku']   =   $this->lang->line('sku');
        $data['condition']   =   $this->lang->line('condition');

        $data['shipping_status']   =   $this->lang->line('shipping_status');
        $data['shipping_service_level']   =   $this->lang->line('shipping_service_level');
        $data['buyer_name']   =   $this->lang->line('buyer_name');
        $data['buyer_phone']   =   $this->lang->line('buyer_phone');


        $data['ship_name']   =   $this->lang->line('ship_name');
        $data['ship_address']   =   $this->lang->line('ship_address');
        $data['ship_city']   =   $this->lang->line('ship_city');
        $data['ship_state']   =   $this->lang->line('ship_state');
        $data['postal_code']   =   $this->lang->line('postal_code');
        $data['ship_country']   =   $this->lang->line('ship_country');


        $data['purchase_price']   =   $this->lang->line('purchase_price');
        $data['international_price']   =   $this->lang->line('international_price');
        $data['international_mode']   =   $this->lang->line('international_mode');
        $data['sell_price']   =   $this->lang->line('sell_price');
        $data['sell_ship_price']   =   $this->lang->line('sell_ship_price');
        $data['stock']   =   $this->lang->line('stock');
        $data['score']   =   $this->lang->line('score');
        $data['profit']   =   $this->lang->line('profit');
        $data['fee']   =   $this->lang->line('fee');
        $data['Weight']   =   $this->lang->line('Weight');
        $data['Height']   =   $this->lang->line('Height');
        $data['Length']   =   $this->lang->line('Length');
        $data['Width']   =   $this->lang->line('Width');
        $data['product_comment']   =   $this->lang->line('product_comment');

        //==========button=======
        $data['order_data_edit']   =   $this->lang->line('order_data_edit');
        $data['this_save']   =   $this->lang->line('this_save');
        $data['complete_shipping']   =   $this->lang->line('complete_shipping');
        $data['complete_input']   =   $this->lang->line('complete_input');

        //====================

        $data['calculate_profit']   =   $this->lang->line('calculate_profit');
        $data['calculate_profit_process']   =   $this->lang->line('calculate_profit_process');
        $data['data_processing_success']   =   $this->lang->line('data_processing_success');
        $data['data_processing_faild']   =   $this->lang->line('data_processing_faild');
        //=========model============
        $data['order_new_edit_title']   =   $this->lang->line('order_new_edit_title');


        return $data;
    }
    private function shippingconfirm_page_text($lang,$page)
    {

        $this->lang->load($page,$lang);
        $data = array();
        $data['title']   =   $this->lang->line('title');
        $data['management']   =   $this->lang->line('management');
        $data['keyword']   =   $this->lang->line('keyword');
        $data['search']   =   $this->lang->line('search');
        $data['filter']   =   $this->lang->line('filter');
        $data['all']   =   $this->lang->line('all');
        $data['new_product']   =   $this->lang->line('new_product');
        $data['used_product']   =   $this->lang->line('used_product');
        $data['action']   =   $this->lang->line('action');
        $data['user']   =   $this->lang->line('user');
        $data['no']   =   $this->lang->line('no');
        $data['apply']   =   $this->lang->line('apply');
        $data['apply_process']   =   $this->lang->line('apply_process');
        $data['Previous']   =   $this->lang->line('Previous');
        $data['Next']   =   $this->lang->line('Next');
        $data['First']   =   $this->lang->line('First');
        $data['Last']   =   $this->lang->line('Last');
        $data['no_tabledata']   =   $this->lang->line('no_tabledata');
        $data['no_presentitem']   =   $this->lang->line('no_presentitem');
        $data['data_processing']   =   $this->lang->line('data_processing');
        $data['filtering']   =   $this->lang->line('filtering');
        $data['no_data']   =   $this->lang->line('no_data');
        $data['number_detect']   =   $this->lang->line('number_detect');
        $data['displaybyline']   =   $this->lang->line('displaybyline');
        $data['page']   =   $this->lang->line('page');
        $data['vie']   =   $this->lang->line('vie');
        $data['total']   =   $this->lang->line('total');
        $data['delete']   =   $this->lang->line('delete');
        $data['modify']   =   $this->lang->line('modify');
        $data['percent']   =   $this->lang->line('percent');
        $data['barcode_check']   =   $this->lang->line('barcode_check');
        //=========table header content=========
        $data['order_id']   =   $this->lang->line('order_id');
        $data['order_date']   =   $this->lang->line('order_date');
        $data['ship_date']   =   $this->lang->line('ship_date');

        $data['product_title']   =   $this->lang->line('product_title');
        $data['product_image']   =   $this->lang->line('product_image');

        $data['asin']   =   $this->lang->line('asin');
        $data['jan']   =   $this->lang->line('jan');
        $data['sku']   =   $this->lang->line('sku');
        $data['condition']   =   $this->lang->line('condition');

        $data['shipping_status']   =   $this->lang->line('shipping_status');
        $data['shipping_service_level']   =   $this->lang->line('shipping_service_level');
        $data['buyer_name']   =   $this->lang->line('buyer_name');
        $data['buyer_phone']   =   $this->lang->line('buyer_phone');


        $data['ship_name']   =   $this->lang->line('ship_name');
        $data['ship_address']   =   $this->lang->line('ship_address');
        $data['ship_city']   =   $this->lang->line('ship_city');
        $data['ship_state']   =   $this->lang->line('ship_state');
        $data['postal_code']   =   $this->lang->line('postal_code');
        $data['ship_country']   =   $this->lang->line('ship_country');


        $data['purchase_price']   =   $this->lang->line('purchase_price');
        $data['international_price']   =   $this->lang->line('international_price');
        $data['international_mode']   =   $this->lang->line('international_mode');
        $data['sell_price']   =   $this->lang->line('sell_price');
        $data['sell_ship_price']   =   $this->lang->line('sell_ship_price');
        $data['stock']   =   $this->lang->line('stock');
        $data['score']   =   $this->lang->line('score');
        $data['profit']   =   $this->lang->line('profit');
        $data['fee']   =   $this->lang->line('fee');
        $data['Weight']   =   $this->lang->line('Weight');
        $data['Height']   =   $this->lang->line('Height');
        $data['Length']   =   $this->lang->line('Length');
        $data['Width']   =   $this->lang->line('Width');
        $data['product_comment']   =   $this->lang->line('product_comment');

        //==========button=======
        $data['order_data_edit']   =   $this->lang->line('order_data_edit');
        $data['this_save']   =   $this->lang->line('this_save');
        $data['complete_shipping']   =   $this->lang->line('complete_shipping');
        $data['complete_input']   =   $this->lang->line('complete_input');

        //====================

        $data['calculate_profit']   =   $this->lang->line('calculate_profit');
        $data['calculate_profit_process']   =   $this->lang->line('calculate_profit_process');
        $data['data_processing_success']   =   $this->lang->line('data_processing_success');
        $data['data_processing_faild']   =   $this->lang->line('data_processing_faild');
        //=========model============
        $data['order_new_edit_title']   =   $this->lang->line('order_new_edit_title');


        return $data;
    }
    private function orders_complete_page_text($lang,$page)
    {

        $this->lang->load($page,$lang);
        $data = array();
        $data['title']   =   $this->lang->line('title');
        $data['management']   =   $this->lang->line('management');
        $data['keyword']   =   $this->lang->line('keyword');
        $data['search']   =   $this->lang->line('search');
        $data['filter']   =   $this->lang->line('filter');
        $data['all']   =   $this->lang->line('all');
        $data['new_product']   =   $this->lang->line('new_product');
        $data['used_product']   =   $this->lang->line('used_product');
        $data['action']   =   $this->lang->line('action');
        $data['user']   =   $this->lang->line('user');
        $data['no']   =   $this->lang->line('no');
        $data['apply']   =   $this->lang->line('apply');
        $data['apply_process']   =   $this->lang->line('apply_process');
        $data['Previous']   =   $this->lang->line('Previous');
        $data['Next']   =   $this->lang->line('Next');
        $data['First']   =   $this->lang->line('First');
        $data['Last']   =   $this->lang->line('Last');
        $data['no_tabledata']   =   $this->lang->line('no_tabledata');
        $data['no_presentitem']   =   $this->lang->line('no_presentitem');
        $data['data_processing']   =   $this->lang->line('data_processing');
        $data['filtering']   =   $this->lang->line('filtering');
        $data['no_data']   =   $this->lang->line('no_data');
        $data['number_detect']   =   $this->lang->line('number_detect');
        $data['displaybyline']   =   $this->lang->line('displaybyline');
        $data['page']   =   $this->lang->line('page');
        $data['vie']   =   $this->lang->line('vie');
        $data['total']   =   $this->lang->line('total');
        $data['delete']   =   $this->lang->line('delete');
        $data['modify']   =   $this->lang->line('modify');
        $data['percent']   =   $this->lang->line('percent');
        $data['product_comment']   =   $this->lang->line('product_comment');
        //=========table header content=========
        $data['order_id_text']   =   $this->lang->line('order_id');
        //echo $data['order_id'];
        $data['order_date']   =   $this->lang->line('order_date');
        $data['ship_date']   =   $this->lang->line('ship_date');

        $data['product_title']   =   $this->lang->line('product_title');
        $data['product_image']   =   $this->lang->line('product_image');

        $data['asin']   =   $this->lang->line('asin');
        $data['jan']   =   $this->lang->line('jan');
        $data['sku']   =   $this->lang->line('sku');
        $data['condition']   =   $this->lang->line('condition');

        $data['shipping_status']   =   $this->lang->line('shipping_status');
        $data['shipping_service_level']   =   $this->lang->line('shipping_service_level');
        $data['buyer_name']   =   $this->lang->line('buyer_name');
        $data['buyer_phone']   =   $this->lang->line('buyer_phone');


        $data['ship_name']   =   $this->lang->line('ship_name');
        $data['ship_address']   =   $this->lang->line('ship_address');
        $data['ship_city']   =   $this->lang->line('ship_city');
        $data['ship_state']   =   $this->lang->line('ship_state');
        $data['postal_code']   =   $this->lang->line('postal_code');
        $data['ship_country']   =   $this->lang->line('ship_country');


        $data['purchase_price']   =   $this->lang->line('purchase_price');
        $data['international_price']   =   $this->lang->line('international_price');
        $data['international_mode']   =   $this->lang->line('international_mode');
        $data['sell_price']   =   $this->lang->line('sell_price');
        $data['sell_ship_price']   =   $this->lang->line('sell_ship_price');
        $data['stock']   =   $this->lang->line('stock');
        $data['score']   =   $this->lang->line('score');
        $data['profit']   =   $this->lang->line('profit');
        $data['fee']   =   $this->lang->line('fee');
        $data['Weight']   =   $this->lang->line('Weight');
        $data['Height']   =   $this->lang->line('Height');
        $data['Length']   =   $this->lang->line('Length');
        $data['Width']   =   $this->lang->line('Width');

        //==========button=======
        $data['order_data_edit']   =   $this->lang->line('order_data_edit');
        $data['this_save']   =   $this->lang->line('this_save');
        $data['complete_complete']   =   $this->lang->line('complete_complete');
        $data['complete_shipping']   =   $this->lang->line('complete_shipping');
        //====================

        $data['calculate_profit']   =   $this->lang->line('calculate_profit');
        $data['calculate_profit_process']   =   $this->lang->line('calculate_profit_process');
        $data['data_processing_success']   =   $this->lang->line('data_processing_success');
        $data['data_processing_faild']   =   $this->lang->line('data_processing_faild');
        //=========model============
        $data['order_new_edit_title']   =   $this->lang->line('order_new_edit_title');


        return $data;
    }
}
?>