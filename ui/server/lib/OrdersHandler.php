<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 11:32 PM
 */

class OrdersHandler {

    public $data;
    public $userdata;
    public $table;

    function __construct($data=array(),$userdata=array()){
        $this->data = $data;
        $this->userdata = $userdata;
        $this->table = $userdata['id']."_orders";
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

    public function get_orders_new_tb(){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        //if user no exist then create table
        // Select 1 from table_name will return false if the table does not exist.
        $table_name = $user_id."_orders";
        //Set primary key field
        $primaryKey = 'order_item_id';
        //Columns define
        $columns = array(
            array( 'db' => 'region',     'dt' => 'region' ),
            array( 'db' => 'order_id',     'dt' => 'order_id' ),
            array( 'db' => 'order_item_id',     'dt' => 'order_item_id' ),
            array( 'db' => 'order_date',     'dt' => 'order_date' ),
            array( 'db' => 'expected_ship_date',     'dt' => 'ship_date' ),

            array( 'db' => 'title',      'dt' => 'title' ),

            array( 'db' => 'image',      'dt' => 'image' ),
            array( 'db' => 'asin',     'dt' => 'asin' ),

            array( 'db' => 'jan',      'dt' => 'jan' ),
            array( 'db' => 'sku',      'dt' => 'sku' ),
            array( 'db' => 'condition',      'dt' => 'condition' ),

            array( 'db' => 'shipping_service_level',      'dt' => 'shipping_service_level' ),
            array( 'db' => 'buyer_name',      'dt' => 'buyer_name' ),
            array( 'db' => 'buyer_phone',      'dt' => 'buyer_phone' ),

            array( 'db' => 'ship_status',      'dt' => 'ship_status' ),
            array( 'db' => 'ship_name',      'dt' => 'ship_name' ),
            array( 'db' => 'ship_address',      'dt' => 'ship_address' ),
            array( 'db' => 'ship_city',      'dt' => 'ship_city' ),
            array( 'db' => 'ship_state',      'dt' => 'ship_state' ),
            array( 'db' => 'ship_postal',      'dt' => 'ship_postal' ),
            array( 'db' => 'ship_country',      'dt' => 'ship_country' ),

            array( 'db' => 'purchase_price',      'dt' => 'purchase_price' ),
            array( 'db' => 'internal_ship_mode',      'dt' => 'internal_ship_mode' ),
            array( 'db' => 'internal_ship_price',      'dt' => 'internal_ship_price' ),

            array( 'db' => 'weight',      'dt' => 'weight' ),
            array( 'db' => 'height',      'dt' => 'height' ),
            array( 'db' => 'length',      'dt' => 'length' ),
            array( 'db' => 'width',      'dt' => 'width' ),

            array( 'db' => 'subtotal_price',      'dt' => 'subtotal_price' ),
            array( 'db' => 'subtotal_ship_price',      'dt' => 'subtotal_ship_price' ),

            array( 'db' => 'quantity',      'dt' => 'quantity' ),
            array( 'db' => 'fee',      'dt' => 'fee' ),
            array( 'db' => 'is_set_info',      'dt' => 'is_set_info' ),
            array( 'db' => 'profit_price',      'dt' => 'profit_price' ),
            array( 'db' => 'profit_percent',      'dt' => 'profit_percent' ),
            array( 'db' => 'order_description',      'dt' => 'order_description' ),
            array( 'db' => 'jp_title',      'dt' => 'jp_title' ),
            array( 'db' => 'internal_ship_num',      'dt' => 'internal_ship_num' ),
            array( 'db' => 'total_weight',      'dt' => 'total_weight' ),
            array( 'db' => 'parent_order',      'dt' => 'parent_order' ),
            array( 'db' => 'total_price',      'dt' => 'total_price' )
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        /**
         * Custom filter apply part
         */

        $param = $_GET['param'];
        $filter_where='';
        if(isset($_GET['param']) && $param['type']=='filter'){
            $filter_where = $this->get_filter_condition($param);
        }

        if($filter_where !=='')
            $filter_where = $filter_where.' AND ';
        $filter_where   =   $filter_where.' `order_process_status`=0';//   new orders

        echo json_encode(
            SSP::get_tb_by_orders( $_GET, $sql_details, $table_name, $primaryKey, $columns ,$filter_where )
        );
    }
    public function get_orders_input_tb(){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        //if user no exist then create table
        // Select 1 from table_name will return false if the table does not exist.
        $table_name = $user_id."_orders";
        //Set primary key field
        $primaryKey = 'order_item_id';
        //Columns define
        $columns = array(
            array( 'db' => 'region',     'dt' => 'region' ),
            array( 'db' => 'order_id',     'dt' => 'order_id' ),
            array( 'db' => 'order_item_id',     'dt' => 'order_item_id' ),
            array( 'db' => 'order_date',     'dt' => 'order_date' ),
            array( 'db' => 'expected_ship_date',     'dt' => 'ship_date' ),

            array( 'db' => 'title',      'dt' => 'title' ),

            array( 'db' => 'image',      'dt' => 'image' ),
            array( 'db' => 'asin',     'dt' => 'asin' ),

            array( 'db' => 'jan',      'dt' => 'jan' ),
            array( 'db' => 'sku',      'dt' => 'sku' ),
            array( 'db' => 'condition',      'dt' => 'condition' ),

            array( 'db' => 'shipping_service_level',      'dt' => 'shipping_service_level' ),
            array( 'db' => 'buyer_name',      'dt' => 'buyer_name' ),
            array( 'db' => 'buyer_phone',      'dt' => 'buyer_phone' ),

            array( 'db' => 'ship_status',      'dt' => 'ship_status' ),
            array( 'db' => 'ship_name',      'dt' => 'ship_name' ),
            array( 'db' => 'ship_address',      'dt' => 'ship_address' ),
            array( 'db' => 'ship_city',      'dt' => 'ship_city' ),
            array( 'db' => 'ship_state',      'dt' => 'ship_state' ),
            array( 'db' => 'ship_postal',      'dt' => 'ship_postal' ),
            array( 'db' => 'ship_country',      'dt' => 'ship_country' ),

            array( 'db' => 'purchase_price',      'dt' => 'purchase_price' ),
            array( 'db' => 'internal_ship_mode',      'dt' => 'internal_ship_mode' ),
            array( 'db' => 'internal_ship_price',      'dt' => 'internal_ship_price' ),

            array( 'db' => 'weight',      'dt' => 'weight' ),
            array( 'db' => 'height',      'dt' => 'height' ),
            array( 'db' => 'length',      'dt' => 'length' ),
            array( 'db' => 'width',      'dt' => 'width' ),

            array( 'db' => 'subtotal_price',      'dt' => 'subtotal_price' ),
            array( 'db' => 'subtotal_ship_price',      'dt' => 'subtotal_ship_price' ),

            array( 'db' => 'quantity',      'dt' => 'quantity' ),
            array( 'db' => 'fee',      'dt' => 'fee' ),
            array( 'db' => 'is_set_info',      'dt' => 'is_set_info' ),

            array( 'db' => 'profit_price',      'dt' => 'profit_price' ),
            array( 'db' => 'profit_percent',      'dt' => 'profit_percent' ),
            array( 'db' => 'order_description',      'dt' => 'order_description' ),
            array( 'db' => 'jp_title',      'dt' => 'jp_title' ),
            array( 'db' => 'internal_ship_num',      'dt' => 'internal_ship_num' ),
            array( 'db' => 'total_weight',      'dt' => 'total_weight' ),
            array( 'db' => 'parent_order',      'dt' => 'parent_order' ),
            array( 'db' => 'total_price',      'dt' => 'total_price' )
        );
        //print_r( $columns);
        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        /**
         * Custom filter apply part
         */

        $param = $_GET['param'];
        $filter_where='';
        //print_r($param);
        if(isset($_GET['param']) && $param['type']=='filter'){
            $filter_where = $this->get_filter_condition($param);
        }

        if($filter_where !=='')
            $filter_where = $filter_where.' AND ';
        $filter_where   =   $filter_where.' `order_process_status`=1';//   new orders
       //echo $filter_where;
        echo json_encode(
            SSP::get_tb_by_orders( $_GET, $sql_details, $table_name, $primaryKey, $columns ,$filter_where )
        );
    }
    public function get_orders_shipping_tb(){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        //if user no exist then create table
        // Select 1 from table_name will return false if the table does not exist.
        $table_name = $user_id."_orders";
        //Set primary key field
        $primaryKey = 'asin';
        //Columns define
        $columns = array(
            array( 'db' => 'region',     'dt' => 'region' ),
            array( 'db' => 'order_id',     'dt' => 'order_id' ),
            array( 'db' => 'order_item_id',     'dt' => 'order_item_id' ),
            array( 'db' => 'order_date',     'dt' => 'order_date' ),
            array( 'db' => 'expected_ship_date',     'dt' => 'ship_date' ),

            array( 'db' => 'title',      'dt' => 'title' ),

            array( 'db' => 'image',      'dt' => 'image' ),
            array( 'db' => 'asin',     'dt' => 'asin' ),

            array( 'db' => 'jan',      'dt' => 'jan' ),
            array( 'db' => 'sku',      'dt' => 'sku' ),
            array( 'db' => 'condition',      'dt' => 'condition' ),

            array( 'db' => 'shipping_service_level',      'dt' => 'shipping_service_level' ),
            array( 'db' => 'buyer_name',      'dt' => 'buyer_name' ),
            array( 'db' => 'buyer_phone',      'dt' => 'buyer_phone' ),

            array( 'db' => 'ship_status',      'dt' => 'ship_status' ),
            array( 'db' => 'ship_name',      'dt' => 'ship_name' ),
            array( 'db' => 'ship_address',      'dt' => 'ship_address' ),
            array( 'db' => 'ship_city',      'dt' => 'ship_city' ),
            array( 'db' => 'ship_state',      'dt' => 'ship_state' ),
            array( 'db' => 'ship_postal',      'dt' => 'ship_postal' ),
            array( 'db' => 'ship_country',      'dt' => 'ship_country' ),

            array( 'db' => 'purchase_price',      'dt' => 'purchase_price' ),
            array( 'db' => 'internal_ship_mode',      'dt' => 'internal_ship_mode' ),
            array( 'db' => 'internal_ship_price',      'dt' => 'internal_ship_price' ),

            array( 'db' => 'weight',      'dt' => 'weight' ),
            array( 'db' => 'height',      'dt' => 'height' ),
            array( 'db' => 'length',      'dt' => 'length' ),
            array( 'db' => 'width',      'dt' => 'width' ),

            array( 'db' => 'subtotal_price',      'dt' => 'subtotal_price' ),
            array( 'db' => 'subtotal_ship_price',      'dt' => 'subtotal_ship_price' ),

            array( 'db' => 'quantity',      'dt' => 'quantity' ),
            array( 'db' => 'fee',      'dt' => 'fee' ),
            array( 'db' => 'is_set_info',      'dt' => 'is_set_info' ),
            array( 'db' => 'profit_price',      'dt' => 'profit_price' ),
            array( 'db' => 'profit_percent',      'dt' => 'profit_percent' ),
            array( 'db' => 'order_description',      'dt' => 'order_description' ),
            array( 'db' => 'jp_title',      'dt' => 'jp_title' ),

             array( 'db' => 'internal_ship_num',      'dt' => 'internal_ship_num' ),
            array( 'db' => 'total_weight',      'dt' => 'total_weight' ),
            array( 'db' => 'parent_order',      'dt' => 'parent_order' ),
            array( 'db' => 'total_price',      'dt' => 'total_price' )
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        /**
         * Custom filter apply part
         */

        $param = $_GET['param'];
        $filter_where='';
        if(isset($_GET['param']) && $param['type']=='filter'){
            $filter_where = $this->get_filter_condition($param);
        }

        if($filter_where !=='')
            $filter_where = $filter_where.' AND ';
        $filter_where   =   $filter_where.' `order_process_status`=2';//   new orders

        echo json_encode(
            SSP::get_tb_by_orders( $_GET, $sql_details, $table_name, $primaryKey, $columns ,$filter_where )
        );
    }
    public function get_orders_shipping_complete_tb(){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        //if user no exist then create table
        // Select 1 from table_name will return false if the table does not exist.
        $table_name = $user_id."_orders";
        //Set primary key field
        $primaryKey = 'asin';
        //Columns define
        $columns = array(
            array( 'db' => 'region',     'dt' => 'region' ),
            array( 'db' => 'order_id',     'dt' => 'order_id' ),
            array( 'db' => 'order_item_id',     'dt' => 'order_item_id' ),
            array( 'db' => 'order_date',     'dt' => 'order_date' ),
            array( 'db' => 'expected_ship_date',     'dt' => 'ship_date' ),

            array( 'db' => 'title',      'dt' => 'title' ),
            array( 'db' => 'image',      'dt' => 'image' ),
            array( 'db' => 'asin',     'dt' => 'asin' ),

            array( 'db' => 'jan',      'dt' => 'jan' ),
            array( 'db' => 'sku',      'dt' => 'sku' ),
            array( 'db' => 'condition',      'dt' => 'condition' ),

            array( 'db' => 'shipping_service_level',      'dt' => 'shipping_service_level' ),
            array( 'db' => 'buyer_name',      'dt' => 'buyer_name' ),
            array( 'db' => 'buyer_phone',      'dt' => 'buyer_phone' ),

            array( 'db' => 'ship_status',      'dt' => 'ship_status' ),
            array( 'db' => 'ship_name',      'dt' => 'ship_name' ),
            array( 'db' => 'ship_address',      'dt' => 'ship_address' ),
            array( 'db' => 'ship_city',      'dt' => 'ship_city' ),
            array( 'db' => 'ship_state',      'dt' => 'ship_state' ),
            array( 'db' => 'ship_postal',      'dt' => 'ship_postal' ),
            array( 'db' => 'ship_country',      'dt' => 'ship_country' ),

            array( 'db' => 'purchase_price',      'dt' => 'purchase_price' ),
            array( 'db' => 'internal_ship_mode',      'dt' => 'internal_ship_mode' ),
            array( 'db' => 'internal_ship_price',      'dt' => 'internal_ship_price' ),

            array( 'db' => 'weight',      'dt' => 'weight' ),
            array( 'db' => 'height',      'dt' => 'height' ),
            array( 'db' => 'length',      'dt' => 'length' ),
            array( 'db' => 'width',      'dt' => 'width' ),

            array( 'db' => 'subtotal_price',      'dt' => 'subtotal_price' ),
            array( 'db' => 'subtotal_ship_price',      'dt' => 'subtotal_ship_price' ),

            array( 'db' => 'quantity',      'dt' => 'quantity' ),
            array( 'db' => 'fee',      'dt' => 'fee' ),
            array( 'db' => 'is_set_info',      'dt' => 'is_set_info' ),
            array( 'db' => 'profit_price',      'dt' => 'profit_price' ),
            array( 'db' => 'profit_percent',      'dt' => 'profit_percent' ),
            array( 'db' => 'order_description',      'dt' => 'order_description' ),
            array( 'db' => 'jp_title',      'dt' => 'jp_title' ),
            array( 'db' => 'internal_ship_num',      'dt' => 'internal_ship_num' ),
            array( 'db' => 'total_weight',      'dt' => 'total_weight' ),
            array( 'db' => 'parent_order',      'dt' => 'parent_order' ),
            array( 'db' => 'total_price',      'dt' => 'total_price' )
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        /**
         * Custom filter apply part
         */

        $param = $_GET['param'];
        $filter_where='';
        if(isset($_GET['param']) && $param['type']=='filter'){
            $filter_where = $this->get_filter_condition($param);
        }

        if($filter_where !=='')
            $filter_where = $filter_where.' AND ';
        $filter_where   =   $filter_where.' `order_process_status`=3';//   new orders

        echo json_encode(
            SSP::get_tb_by_orders( $_GET, $sql_details, $table_name, $primaryKey, $columns ,$filter_where )
        );
    }
    public function get_orders_complete_tb(){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        //if user no exist then create table
        // Select 1 from table_name will return false if the table does not exist.
        $table_name = $user_id."_orders";
        //Set primary key field
        $primaryKey = 'asin';
        //Columns define
        $columns = array(
            array( 'db' => 'region',     'dt' => 'region' ),
            array( 'db' => 'order_id',     'dt' => 'order_id' ),
            array( 'db' => 'order_item_id',     'dt' => 'order_item_id' ),
            array( 'db' => 'order_date',     'dt' => 'order_date' ),
            array( 'db' => 'expected_ship_date',     'dt' => 'ship_date' ),

            array( 'db' => 'title',      'dt' => 'title' ),
            array( 'db' => 'image',      'dt' => 'image' ),
            array( 'db' => 'asin',     'dt' => 'asin' ),

            array( 'db' => 'jan',      'dt' => 'jan' ),
            array( 'db' => 'sku',      'dt' => 'sku' ),
            array( 'db' => 'condition',      'dt' => 'condition' ),

            array( 'db' => 'shipping_service_level',      'dt' => 'shipping_service_level' ),
            array( 'db' => 'buyer_name',      'dt' => 'buyer_name' ),
            array( 'db' => 'buyer_phone',      'dt' => 'buyer_phone' ),

            array( 'db' => 'ship_status',      'dt' => 'ship_status' ),
            array( 'db' => 'ship_name',      'dt' => 'ship_name' ),
            array( 'db' => 'ship_address',      'dt' => 'ship_address' ),
            array( 'db' => 'ship_city',      'dt' => 'ship_city' ),
            array( 'db' => 'ship_state',      'dt' => 'ship_state' ),
            array( 'db' => 'ship_postal',      'dt' => 'ship_postal' ),
            array( 'db' => 'ship_country',      'dt' => 'ship_country' ),

            array( 'db' => 'purchase_price',      'dt' => 'purchase_price' ),
            array( 'db' => 'internal_ship_mode',      'dt' => 'internal_ship_mode' ),
            array( 'db' => 'internal_ship_price',      'dt' => 'internal_ship_price' ),

            array( 'db' => 'weight',      'dt' => 'weight' ),
            array( 'db' => 'height',      'dt' => 'height' ),
            array( 'db' => 'length',      'dt' => 'length' ),
            array( 'db' => 'width',      'dt' => 'width' ),

            array( 'db' => 'subtotal_price',      'dt' => 'subtotal_price' ),
            array( 'db' => 'subtotal_ship_price',      'dt' => 'subtotal_ship_price' ),

            array( 'db' => 'quantity',      'dt' => 'quantity' ),
            array( 'db' => 'fee',      'dt' => 'fee' ),
            array( 'db' => 'is_set_info',      'dt' => 'is_set_info' ),
            array( 'db' => 'profit_price',      'dt' => 'profit_price' ),
            array( 'db' => 'profit_percent',      'dt' => 'profit_percent' ),
            array( 'db' => 'order_description',      'dt' => 'order_description' ),
            array( 'db' => 'jp_title',      'dt' => 'jp_title' ),
            array( 'db' => 'internal_ship_num',      'dt' => 'internal_ship_num' ),
            array( 'db' => 'total_weight',      'dt' => 'total_weight' ),
            array( 'db' => 'parent_order',      'dt' => 'parent_order' ),
            array( 'db' => 'total_price',      'dt' => 'total_price' )
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        /**
         * Custom filter apply part
         */

        $param = $_GET['param'];
        $filter_where='';
        if(isset($_GET['param']) && $param['type']=='filter'){
            $filter_where = $this->get_filter_condition($param);
        }

        if($filter_where !=='')
            $filter_where = $filter_where.' AND ';
        $filter_where   =   $filter_where.' `order_process_status`=5';//   new orders
       //echo $filter_where;
        echo json_encode(
            SSP::get_tb_by_orders_complete( $_GET, $sql_details, $table_name, $primaryKey, $columns ,$filter_where )
        );
    }
    public function get_filter_condition($param){
        $res ='';
        switch($param['value']){

            case 'is_new':
                return "`condition`='New' ";
                break;
            case 'is_used':
                return "`condition`='Used' ";
                break;
            case 'orders_ems_all':
                //return "internal_ship_mode like '%EMS%' ";
                return "`internal_ship_mode`='EMS' ";
                break;
            case 'orders_sal_all':
                //return "internal_ship_mode like '%SAL%' ";
                return "`internal_ship_mode`='SAL' ";
                break;
            case 'orders_sal_track_all':
                //return "internal_ship_mode like '%SAL Track%' ";
                return "`internal_ship_mode`='SAL Track' ";
                break;
            case 'orders_sal_air_all':
                //return "internal_ship_mode like '%SAL Track%' ";
                return "`internal_ship_mode`='Air Mail' ";
                break;
            case 'orders_sal_air_track_all':
                //return "internal_ship_mode like '%SAL Track%' ";
                return "`internal_ship_mode`='Air Mail Track' ";
                break;
            case 'purchase_complete':
            case 'input_complete':
            case 'shipping_complete':
            case 'order_complete':
            case 'info_complete':

                return "`is_set_info`='1' ";
                break;
            case 'purchase_incomplete':
            case 'input_incomplete':
            case 'shipping_incomplete':
            case 'order_incomplete':
                return "`is_set_info`='0' ";

            case 'orders_new_all':
                return "`order_process_status`=0 ";
            case 'orders_input_all':
                return "`order_process_status`=1 ";
            case 'orders_shipping_all':
                return "`order_process_status`=2 ";
            case 'orders_shipping_complete_all':
                return "`order_process_status`=3 ";
            case 'orders_complete_all':
                return "`order_process_status`=5 ";


        }
        return $res;
    }

    public function load_content_menu(){
        $CI =   & get_instance();
        $table_name=$this->userdata['id'].'_content_tb';
        $result = $CI->db->get($table_name);

        $data = $result->result();

        $response = array(
            'msg' =>'success load content menu',
            'data' => $data
        );
        $this->output($response);
    }

    public function get_order_info(){
        $region = $this->data['region'];
        $order_item_id = $this->data['order_item_id'];

        $CI =   & get_instance();
        $CI->db->where(array('region' => $region,'order_item_id' => $order_item_id));
        $CI->db->select('*');
        $result = $CI->db->get($this->table);

        $data = $result->result()[0];

        $response = array(
            'msg' => $data,
            'data' => $data
        );
        $this->output($response);
    }
    public function set_order_info(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;


        $query  =   "  UPDATE $tablename SET `purchase_price`=".$data['purchase_price'].",`weight`=".$data['weight'];
        $query  .=  " ,`height`=".$data['height'].",`length`=".$data['length'].",`width`=".$data['width'];
        $query  .=   ",`internal_ship_mode`='".$data['ship_mode']."' ,`internal_ship_price`=".$data['ship_price'];
        $query  .=   ",`is_set_info`=1,`order_description`='".$data['order_description']."'";
        $query.=    "   WHERE `region`='".$data['region']."'  and `order_item_id`='".$data['order_item_id']."' ";

       // echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => $query
        );
        $this->output($response);

    }
    public function set_order_common_info(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;


        $query  =   "  UPDATE $tablename SET  `total_weight`=".$data['total_weight'];
        $query.=    "   WHERE `region`='".$data['region']."'  and `order_id`='".$data['order_id']."' ";

        // echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => $query
        );
        $this->output($response);

    }
    public function save_shipping_confirm_info(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;


        $query  =   "  UPDATE $tablename SET  order_process_status=5, `package_items`=".$data['package_items'].",`expected_ship_date`='".$data['ship_date']."' ,`carrier`='".$data['carrier']."',`internal_ship_mode`='".$data['internal_ship_mode']."',`tracking_id`='".$data['tracking_id']."',`seller_memo`='".$data['seller_memo']."'   WHERE `region`='".$data['region']."'  and `order_id`='".$data['order_id']."' ";

        //echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => '1'
        );
        $this->output($response);

    }
    public function delete_order(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;


        $query  =   "  delete  from   $tablename    WHERE `region`='".$data['region']."'  and `order_item_id`='".$data['order_item_id']."' ";

        // echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => ''
        );
        $this->output($response);

    }
    public function init_set_info(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;


        $param['value'] = $this->data;

        $filter_where='';
        $filter_where = $this->get_filter_condition($param);
        $query  =   "  UPDATE $tablename SET  `is_set_info`=0  WHERE  ".$filter_where;

        // echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => ''
        );
        $this->output($response);

    }
    public function set_order_description(){
    $data = $this->data;
    $CI =   & get_instance();
    $tablename  =$this->table;

    $value=$this->data['value'];
    $param['value'] = $this->data['filter'];
    $filter_where='';
    $filter_where = $this->get_filter_condition($param);
    if($filter_where !=='')
        $filter_where = $filter_where.' AND ';
    $filter_where   =   $filter_where.' `order_process_status`=2';//   new orders
    if($value !=='')
    {
        $filter_where .= "  and  ";
        $filter_where .= "(order_id like '%" . $value . "%' or asin like '%" . $value . "%' or " . "jan like '%" . $value . "%' or jp_title like '%" . $value . "%' or sku like '%" . $value . "%')";
    }

    $query  =   "  UPDATE $tablename SET  `is_set_info`=1,`order_description`='".$data['order_description']."'   WHERE  ".$filter_where;

    // echo $query;
    $CI->db->query( $query);
    $response = array(
        'msg' => 'Success Save',
        'data' => ''
    );
    $this->output($response);

}
    public function set_individual_order_description(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;

        $value=$this->data['value'];
        $filter_where= "order_item_id='" . $value . "'";
        $query  =   "  UPDATE $tablename SET  `is_set_info`=1,`order_description`='".$data['order_description']."'   WHERE  ".$filter_where;
        // echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => ''
        );
        $this->output($response);

    }
    public function set_barcode_info(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;

        $value=$this->data['value'];
        $param['value'] = $this->data['filter'];
        //print_r($param);
        $filter_where='';
        $filter_where = $this->get_filter_condition($param);
        //echo $filter_where;
        if($value !=='')
        {
            $filter_where .= "  and  ";
            $filter_where .= " jan='". $value."'";
            $query  =   "  UPDATE $tablename SET  `is_set_info`=1   WHERE  ".$filter_where;
            // echo $query;
            $CI->db->query( $query);
        }
        $response = array(
            'msg' => 'Success Save',
            'data' => ''
        );
        $this->output($response);

    }
    public function set_input_order(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;
        $query  =   "  UPDATE $tablename SET `order_process_status`=1,`is_set_info`=0  WHERE `region`='".$data['region']."'  and `order_item_id`='".$data['order_item_id']."' ";

        //echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => ''
        );
        $this->output($response);

    }
    public function set_new_order(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;
        $query  =   "  UPDATE $tablename SET `order_process_status`=0,`is_set_info`=0  WHERE `region`='".$data['region']."'  and `order_item_id`='".$data['order_item_id']."' ";

        //echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => ''
        );
        $this->output($response);

    }
    public function set_shipping_order(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;
        $query  =   "  UPDATE $tablename SET `order_process_status`=2,`is_set_info`=0  WHERE `region`='".$data['region']."'  and `order_id`='".$data['order_id']."' ";

        //echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => ''
        );
        $this->output($response);

    }
    public function set_shipping_complete_order(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;
        $query  =   "  UPDATE $tablename SET `order_process_status`=3,`is_set_info`=0  WHERE `region`='".$data['region']."'  and `order_id`='".$data['order_id']."' ";

        //echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => ''
        );
        $this->output($response);

    }
    public function set_complete_order(){
        $data = $this->data;
        $CI =   & get_instance();
        $tablename  =$this->table;
        $query  =   "  UPDATE $tablename SET `order_process_status`=5,`is_set_info`=0  WHERE `region`='".$data['region']."'  and `order_id`='".$data['order_id']."' ";

        //echo $query;
        $CI->db->query( $query);
        $response = array(
            'msg' => 'Success Save',
            'data' => ''
        );
        $this->output($response);

    }
    public  function file_download()
    {
        $job_reg_date   =   $this->data;

        $table_name = "job_list";
        $where = array('register_time'=>$job_reg_date);
        $CI =  & get_instance();
        $CI->db->where($where);
        $result =   $CI->db->get($table_name);
        $data = $result->result()[0];
        $filename   =   $data->result_value;
        $DownloadPath =__DIR__."/../../files/temp/".$filename;
        $base_url =  'http://';//$_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
        $base_url =$base_url. $_SERVER['HTTP_HOST'];
        $file = $base_url."/amaze/ui/files/temp/".$filename;
        //if(strpos($filename,'.jpg') )
       // {
            //$this->image_download($DownloadPath,$filename);
        //    $this->image_download($file,$filename);
        //}
        //else{


            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"$filename\"");

            readfile ($file);
        //}

    }
    public function image_download($filepath,$filename)
    {
        Header("Content-type: application/x-msdownload");
        Header("Content-Disposition: attachment; filename=".$filename."");
        Header("Content-Transfer-Encoding: binary");
        Header("Pragma: no-cache");
        Header("Expires: 0");

        $handle    = fopen($filepath, "r");
        // while(!feof($handle)){
            echo fread($handle,4096);
        //};
    }
    function save_image($inPath,$outPath)
    { //Download images from remote server
        $in=    fopen($inPath, "rb");
        $out=   fopen($outPath, "wb");
        while ($chunk = fread($in,8192))
        {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }


}