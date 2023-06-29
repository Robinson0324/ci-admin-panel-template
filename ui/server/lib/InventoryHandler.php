<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 11:32 PM
 */

class InventoryHandler {

    public $data;
    public $userdata;
    public $table;

    function __construct($data=array(),$userdata=array()){
        $this->data = $data;
        $this->userdata = $userdata;
        $this->table = $userdata['id']."_product";
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

    public function get_inventory_tb(){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        //if user no exist then create table
        // Select 1 from table_name will return false if the table does not exist.
        $table_name = $user_id."_product";
        //Set primary key field
        $primaryKey = 'asin';
        //Columns define
        $columns = array(
            array( 'db' => 'asin',     'dt' => 'asin' ),
            array( 'db' => 'jan',      'dt' => 'jan' ),

            array( 'db' => 'title',      'dt' => 'title' ),
            array( 'db' => 'image',      'dt' => 'image' ),
            array( 'db' => 'manufacture',      'dt' => 'manufacture' ),
            array( 'db' => 'category',      'dt' => 'category' ),
            array( 'db' => 'release_date',      'dt' => 'release_date' ),


            array( 'db' => 'condition',      'dt' => 'condition' ),

            array( 'db' => 'weight',      'dt' => 'weight' ),
            array( 'db' => 'height',      'dt' => 'height' ),
            array( 'db' => 'length',      'dt' => 'length' ),
            array( 'db' => 'width',      'dt' => 'width' ),

            array( 'db' => 'import_date',      'dt' => 'import_date' ),
            array( 'db' => 'us_last_update_date',      'dt' => 'us_last_update_date' ),
            array( 'db' => 'import_file_name',      'dt' => 'import_file_name' ),

            array( 'db' => 'jp_fba_status',      'dt' => 'ship_type' ),
            array( 'db' => 'jp_lowest_price',      'dt' => 'jp_lowest_price' ),
            array( 'db' => 'jp_lowest_ship_price',      'dt' => 'jp_lowest_ship_price' ),
            array( 'db' => 'jp_rank',      'dt' => 'jp_rank' ),
            array( 'db' => 'jp_seller_num',      'dt' => 'jp_seller_num' ),
            array( 'db' => 'jp_fba_status',      'dt' => 'jp_fba_status' ),
            array( 'db' => 'jp_status',      'dt' => 'jp_status' ),

            array( 'db' => 'us_sku',      'dt' => 'sku' ),
            array( 'db' => 'us_lowest_price',      'dt' => 'us_lowest_price' ),
            array( 'db' => 'us_rank',      'dt' => 'us_rank' ),
            array( 'db' => 'us_amazon_fee',      'dt' => 'us_amazon_fee' ),

            array( 'db' => 'us_weight',      'dt' => 'us_weight' ),
            array( 'db' => 'us_size',      'dt' => 'us_size' ),

            array( 'db' => 'us_ship_price',      'dt' => 'us_ship_price' ),
            array( 'db' => 'us_ship_mode',      'dt' => 'us_ship_mode' ),

            array( 'db' => 'jp_feedback_count',      'dt' => 'jp_feedback_count' ),
            array( 'db' => 'jp_feedback_rate',      'dt' => 'jp_feedback_rate' ),

            array( 'db' => 'us_is_listed',      'dt' => 'us_is_listed' ),
            array( 'db' => 'us_is_out_ban',      'dt' => 'us_is_out_ban' ),

            array( 'db' => 'us_profit_amount',      'dt' => 'us_profit_amount' ),
            array( 'db' => 'us_price',      'dt' => 'us_price' ),
            array( 'db' => 'us_stock',      'dt' => 'us_stock' ),
            array( 'db' => 'us_handling_time',      'dt' => 'us_handling_time' ),
            array( 'db' => 'us_comment',      'dt' => 'us_comment' )
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
        if(isset($_GET['param']) && $param['type']=='filter'){
            $filter_where = $this->get_filter_condition($param);
        }
        echo json_encode(
            SSP::get_tb_by_filter_condition( $_GET, $sql_details, $table_name, $primaryKey, $columns ,$filter_where )
        );
    }

    public function get_filter_condition($param){
        $res = array();
        switch($param['value']){
            case 'inventory_all':
                return "`us_is_listed`=1";
                break;
            case 'is_new':
                return "`condition`='New' AND `us_is_listed`=1";
                break;
            case 'is_used':
                return "`condition`='Used' AND `us_is_listed`=1";
                break;
            case 'profit_plus':
                return "`us_prev_profit`>=0 AND `us_is_listed`=1";
                break;
            case 'profit_minus':
                return "`us_prev_profit`<0 AND `us_is_listed`=1";
                break;
            case 'export_ban':
                return "`us_is_out_ban`=1 AND `us_is_listed`=1";
                break;
            case 'is_adult':
                return "`is_adult`=1 AND `us_is_listed`=1";
                break;
            case 'is_listed':
                return "`us_stock`>0 AND `us_is_listed`=1";
                break;
            case 'is_stop':
                return "`us_stock`=0 AND `us_is_listed`=1";
                break;
            case 'is_none_listed':
                break;
            case 'has_jp_sellers':
                return "`jp_seller_num`>0 AND `us_is_listed`=1";
                break;
            case 'is_ship_ems':
                return "`us_ship_mode`='EMS' AND `us_is_listed`=1";
                break;
            case 'is_none_price':
                return "`us_price`=0";
                break;
            case 'us_unregistered_listed':
                return "`us_lowest_price`=0 AND (`us_info_update_date`!='' OR `us_info_update_date`!=NULL) AND `us_is_listed`=1";
                break;
            case 'preorder':
                return "`jp_status`=1 AND `us_is_listed`=1";
                break;
        }
        return $res;
    }

    public function get_product_status(){
        $asin = $this->data['asin'];
        $condition = $this->data['condition'];
        $filed_name = $this->data['field'];

        $CI =   & get_instance();
        $CI->db->where(array('asin' => $asin,'condition' => $condition));
        $CI->db->select($filed_name);
        $result = $CI->db->get($this->table);

        $data = $result->result()[0]->{$filed_name};

        $response = array(
            'msg' => '',
            'data' => $data
        );
        $this->output($response);
    }

    public function get_product_info(){
        $asin = $this->data['asin'];
        $condition = $this->data['condition'];

        $CI =   & get_instance();
        $CI->db->where(array('asin' => $asin,'condition' => $condition));
        $CI->db->select('*');
        $result = $CI->db->get($this->table);

        $data = $result->result()[0];

        $response = array(
            'msg' => $data,
            'data' => $data
        );
        $this->output($response);
    }
} 