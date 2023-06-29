<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/11/14
 * Time: 10:19 AM
 */

require_once __DIR__."/config.php";
require( 'ssp.class.php' );


class Setting{
    /**
     * Memeber vars
     */
    public $lang;

    /**
     * Member functions
     */
    function __construct(){
        //load all lang words
        $this->lang = $this->get_lang_data();
    }

    /**
     * @param $params
     * array = {
     *      action: 'register'      //'release'
     *      data: array()
     * }
     */
    public function exchange_setting_register($params,$userdata){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        //get exchage setting
        $exchange_settings = array(
            'user_id' => $user_id,
            'USD' => $params['USD'],
            'CAD' => $params['CAD'],
            'GBP' => $params['GBP'],
            'EUR' => $params['EUR']
        );
        //Check user profits are already set or new
        $strQuery = "SELECT user_id FROM rate_money_table WHERE `user_id`='".$user_id."'";
        $result = $CI->db->query($strQuery);
        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($exchange_settings as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE rate_money_table SET ".$str_set."  WHERE `user_id`='".$user_id."'";
        }else{
            $karry = $varry = array();
            foreach($exchange_settings as $key => $val){
                $karry[] = $key;
                $varry[] = "'".$val."'";
            }
            $kstr = implode(",",$karry);
            $vstr = implode(",",$varry);
            $strQuery = "INSERT INTO rate_money_table (".$kstr.") VALUES (".$vstr.")";
        }

        $result = $CI->db->query($strQuery);

        //print_r($setting);
        $str = array(
            "msg" => $this->lang['lang_exchange'].' '.$this->lang['lang_setting'].' '.$this->lang['lang_register'].' '.$this->lang['lang_success'],//"Exchange setting register success!",
            "data" => $result
        );
        $this->output($str);
    }

    public function exchange_setting_release($params){
        $str = array(
            "msg" => $this->lang['lang_exchange'].' '.$this->lang['lang_setting'].' '.$this->lang['lang_release'],//"Exchange setting release",
            "data" => $params
        );
        $this->output($str);
    }

    public function get_ship_ems_table(){
        // Table's primary key
        $primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
        $CI =   & get_instance();
        $columns = array(
            array( 'db' => 'id',           'dt' => 0 ),
            array( 'db' => 'weight_min',           'dt' => 1 ),
            array( 'db' => 'weight_max',         'dt' => 2 ),
            array( 'db' => 'com_price',          'dt' => 3 ),
            array( 'db' => 'uk_price',        'dt' => 4 )
        );

// SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        /*
        print_r($_GET);
        print_r($sql_details);
        print_r($table);
        print_r($primaryKey);
        print_r($columns);
        */
        $userdata   =   $CI->login_model->get_cur_user_info();
        $table  =   "shipping_ems_table";

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );

    }

    public function get_ship_sal_table(){
        // Table's primary key
        $primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
        $CI =   & get_instance();
        $columns = array(
            array( 'db' => 'id',          'dt' => 0 ),
            array( 'db' => 'weight_min',           'dt' => 1 ),
            array( 'db' => 'weight_max',         'dt' => 2 ),
            array( 'db' => 'price',        'dt' => 3 )
        );

// SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        /*
        print_r($_GET);
        print_r($sql_details);
        print_r($table);
        print_r($primaryKey);
        print_r($columns);
        */
        $userdata   =   $CI->login_model->get_cur_user_info();
        $table  =   "shipping_sal_table";

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );
    }

    public function get_ship_epacket_table(){
        // Table's primary key
        $primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
        $CI =   & get_instance();
        $columns = array(
            array( 'db' => 'id',          'dt' => 0 ),
            array( 'db' => 'weight_min',           'dt' => 1 ),
            array( 'db' => 'weight_max',         'dt' => 2 ),
            array( 'db' => 'price',        'dt' => 3 )
        );

// SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        /*
        print_r($_GET);
        print_r($sql_details);
        print_r($table);
        print_r($primaryKey);
        print_r($columns);
        */
        $userdata   =   $CI->login_model->get_cur_user_info();
        $table  =   "shipping_epacket_table";

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );
    }

    /**
     * @param $params
     * array = {
     *      action: 'register'      //'release'
     *      data: array()
     * }
     */
    public function set_profit_setting($params,$userdata){

        $type = $params['type'];
        $amount_value = $params['amount_val'];
        $percent_value = $params['percent_val'];

        //get current user email or id
        $user_id = $userdata['id'];

        //Save to database
        $profit_settings = array(
            'user_id' => $user_id,
            'type' => $type,
            'amount_val' => $amount_value,
            'percent_val' => $percent_value
        );


        $CI =   & get_instance();

        //Check user profits are already set or new
        $strQuery = "SELECT user_id FROM profit_table WHERE `user_id`='".$user_id."'";



        $result = $CI->db->query($strQuery);
        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($profit_settings as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE profit_table SET ".$str_set."  WHERE `user_id`='".$user_id."'";
        }else{
            $karry = $varry = array();
            foreach($profit_settings as $key => $val){
                $karry[] = $key;
                $varry[] = "'".$val."'";
            }
            $kstr = implode(",",$karry);
            $vstr = implode(",",$varry);
            $strQuery = "INSERT INTO profit_table (".$kstr.") VALUES (".$vstr.")";
        }


        $CI->db->query($strQuery);

        $str = array(
            "msg" => $this->lang['lang_set'].' '.$this->lang['lang_profit'].' '.$this->lang['lang_setting'].' '.$this->lang['lang_success'],//"Profit setting success!",
            "data" => array(
                'type' => $type,
                'amount_value' => $amount_value,
                'percent_value' => $percent_value
            )
        );
        $this->output($str);
    }

    public function get_profit_setting($userdata){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $strQuery = "SELECT * FROM profit_table WHERE `user_id`='".$user_id."'";
        $result = $CI->db->query($strQuery);
        $setting = $result->result()[0];

        $str = array(
            "msg" => 'Profit setting success!',//"Profit setting success!",
            "data" => array(
                'type' => $setting->type,
                'amount_value' => $setting->amount_val,
                'percent_value' => $setting->percent_val
            )
        );
        $this->output($str);
    }

    public function get_exchange_setting($userdata){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $strQuery = "SELECT * FROM rate_money_table WHERE `user_id`='".$user_id."'";

        $result = $CI->db->query($strQuery);
        $setting = $result->result()[0];

        $str = array(
            "msg" => "Get Exchange setting success!",
            "data" => $setting
        );
        $this->output($str);
    }

    public function get_buy_limit_asin_info($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table = "asin_aws_info_".$user_id;

        $asin = $this->clean($data['asin']);

        $strQuery = "SELECT * FROM ".$table." WHERE `asin`='".$asin."'";

        $result = $CI->db->query($strQuery);

        try{
            $setting = @$result->result()[0];
        }catch (Exception $e){
            $setting = array();
        }

        $str = array(
            "msg" => $this->lang['lang_asin'].' ['.$asin.'] '.$this->lang['lang_getting'].' '.$this->lang['lang_success'],//$this->lang['lang_asin'].$asin." Info Getting Success!",
            "data" => $setting
        );
        $this->output($str);
    }

    public function delete_buy_limit_asin($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];

        $asin = $this->clean($data);

        $strQuery = "DELETE FROM asin_restrict WHERE `asin`='".$asin."' AND `user_id`='".$user_id."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => $this->lang['lang_asin'].'['.$asin.'] '.$this->lang['lang_info'].''.$this->lang['lang_delete'].' '.$this->lang['lang_success'],//" Info Delete Success!",
            "data" => $result
        );
        $this->output($str);
    }

    public function get_all_buy_limit_asin($userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];

        $strQuery = "SELECT * FROM asin_restrict WHERE `user_id`='".$user_id."'";

        $result = $CI->db->query($strQuery);

        $arry = $result->result();

        foreach($arry as $item){
            //calc remain days
            $now = time(); // or your date as well
            $your_date = strtotime($item->expire_date);
            $datediff = $your_date - $now;
            $remain_days = floor($datediff/(60*60*24));

            $item->{'remain_days'} = $remain_days+1;
        }
        $str = array(
            "msg" => $this->lang['lang_all_asin_info_get_success'],//"All ASIN Info Getting Success!",
            "data" => $arry
        );
        $this->output($str);
    }

    public function save_reg_edit_asin_info($data,$userdata){


        if($this->clean($data['asin']) == ''){
            $str = array(
                "msg" => "Incorrect ASIN!",
                "data" => array()
            );
            $this->output($str);
            return;
        }

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table = "asin_aws_info_".$user_id;
        //Check user profits are already set or new
        $strQuery = "SELECT asin FROM ".$table." WHERE `asin`='".$data['asin']."'";
        $result = $CI->db->query($strQuery);

        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($data as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE ".$table." SET ".$str_set."  WHERE `asin`='".$data['asin']."'";
        }else{
            $karry = $varry = array();
            foreach($data as $key => $val){
                $karry[] = $key;
                $varry[] = "'".$val."'";
            }
            $kstr = implode(",",$karry);
            $vstr = implode(",",$varry);
            $strQuery = "INSERT INTO ".$table." (".$kstr.") VALUES (".$vstr.")";
        }


        $result =  $CI->db->query($strQuery);

        $str = array(
            "msg" => $this->lang['lang_asin'].' ['.$data['asin'].']'.$this->lang['lang_saved'],//"ASIN [".$data['asin']."] Info Save Success!",
            "data" => $result
        );
        $this->output($str);
    }

    public function get_reg_edit_search_info($data,$userdata){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];

        $asin = $this->clean($data['asin']);
        $table = "asin_aws_info_".$user_id;

        $strQuery = "SELECT asin,category,rank,title,manufacture,weight,height,length,width FROM ".$table." WHERE `asin`='".$asin."'";

        $result = $CI->db->query($strQuery);

        if(count($result->result()) > 0){
            $res_arry = $result->result()[0];
            /*** cast the object ***/
            $array = (array) $res_arry;


            $response = array(
                "msg" => $this->lang['lang_asin'].$asin." Info Getting Success!",
                "data" => $array
            );
            $this->output($response);
        }else{
            $response = array(
                "msg" => $this->lang['lang_asin'].'['.$asin.'] '.$this->lang['lang_not_found'],// Info Not Found!,
                "data" => array()
            );
            $this->output($response);
        }



    }
    /**
     * @param $params
     * array = {
     *      action: 'register'      //'release'
     *      data: array()
     * }
     */
    public function add_new_buy_limit_asin($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];

        $asin_info = array(
            'user_id' => $user_id,
            'asin' => $data['asin_info']['asin'],
            'product_name' => $data['asin_info']['product_name'],
            'manufacturer' => $data['asin_info']['manufacturer'],
            'expire_date' => date('Y-m-d', strtotime("+".$data['asin_info']['limit_days']." days"))
        );

        if($asin_info['asin'] == ''){
            $res = array(
                "msg" => "ASIN Empty!",
                "data" => array()
            );
            $this->output($res);
            exit;
        }

        //Check user profits are already set or new
        $strQuery = "SELECT * FROM asin_restrict WHERE `user_id`='".$user_id."' AND `asin`='".$asin_info['asin']."'";

        $result = $CI->db->query($strQuery);
        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($asin_info as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE asin_restrict SET ".$str_set."  WHERE `user_id`='".$user_id."' AND `asin`='".$asin_info['asin']."'";
        }else{
            $karry = $varry = array();
            foreach($asin_info as $key => $val){
                $karry[] = $key;
                $varry[] = "'".$val."'";
            }
            $kstr = implode(",",$karry);
            $vstr = implode(",",$varry);
            $strQuery = "INSERT INTO asin_restrict (".$kstr.") VALUES (".$vstr.")";
        }


        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ASIN[".$asin_info['asin']."] ".$this->lang['lang_saved'],
            "data" => $result
        );
        $this->output($str);
    }

    /***
     * Ship EMS Events
     * @param $data
     * @param $userdata
     */

    public function add_ship_ems_new_record($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];

        $karry = $varry = array();
        foreach($data as $key => $val){
            $karry[] = $key;
            $varry[] = "'".$val."'";
        }
        $kstr = implode(",",$karry);
        $vstr = implode(",",$varry);
        $strQuery = "INSERT INTO shipping_ems_table (".$kstr.") VALUES (".$vstr.")";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => $this->lang['lang_added_new_item'],//"Added New Item!",
            "data" => $result
        );
        $this->output($str);
    }

    public function save_ship_ems_edit_record($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
//print_r($data);die();
        //Check user profits are already set or new
        $strQuery = "SELECT * FROM shipping_ems_table WHERE `id`='".$this->clean($data['id'])."'";

        $result = $CI->db->query($strQuery);
        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($data as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE shipping_ems_table SET ".$str_set."  WHERE `id`='".$this->clean($data['id'])."'";
        }else{
            $karry = $varry = array();
            foreach($data as $key => $val){
                $karry[] = $key;
                $varry[] = "'".$val."'";
            }
            $kstr = implode(",",$karry);
            $vstr = implode(",",$varry);
            $strQuery = "INSERT INTO shipping_ems_table (".$kstr.") VALUES (".$vstr.")";
        }


        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($data['id'])."] ".$this->lang['lang_update'].' '.$this->lang['lang_success'],//Update Success!
            "data" => $result
        );
        $this->output($str);
    }

    public function delete_ship_ems_row($data,$userdata){
        $CI =   & get_instance();
        //Check user profits are already set or new
        $strQuery = "DELETE FROM shipping_ems_table WHERE `id`='".$this->clean($data['id'])."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($data['id'])."] ".$this->lang['lang_delete'].' '.$this->lang['lang_success'], //Delete Success!
            "data" => $result
        );
        $this->output($str);
    }

    /**
     * Ship ePacket Events
     *
     * @param $data
     * @param $userdata
     *
     */
    public function add_ship_epacket_new_record($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];

        $karry = $varry = array();
        foreach($data as $key => $val){
            $karry[] = $key;
            $varry[] = "'".$val."'";
        }
        $kstr = implode(",",$karry);
        $vstr = implode(",",$varry);
        $strQuery = "INSERT INTO shipping_epacket_table (".$kstr.") VALUES (".$vstr.")";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => $this->lang['lang_added_new_item'],//"Added New Item!",
            "data" => $result
        );
        $this->output($str);
    }

    public function save_ship_epacket_edit_record($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
//print_r($data);die();
        //Check user profits are already set or new
        $strQuery = "SELECT * FROM shipping_epacket_table WHERE `id`='".$this->clean($data['id'])."'";

        $result = $CI->db->query($strQuery);
        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($data as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE shipping_epacket_table SET ".$str_set."  WHERE `id`='".$this->clean($data['id'])."'";
        }else{
            $karry = $varry = array();
            foreach($data as $key => $val){
                $karry[] = $key;
                $varry[] = "'".$val."'";
            }
            $kstr = implode(",",$karry);
            $vstr = implode(",",$varry);
            $strQuery = "INSERT INTO shipping_epacket_table (".$kstr.") VALUES (".$vstr.")";
        }


        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($data['id'])."] Update Success!",
            "data" => $result
        );
        $this->output($str);
    }

    public function delete_ship_epacket_row($data,$userdata){
        $CI =   & get_instance();
        //Check user profits are already set or new
        $strQuery = "DELETE FROM shipping_epacket_table WHERE `id`='".$this->clean($data['id'])."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($data['id'])."] Delete Success!",
            "data" => $result
        );
        $this->output($str);
    }

    /**
     * Ship SAL Events
     *
     * @param $data
     * @param $userdata
     *
     */
    public function add_ship_sal_new_record($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];

        $karry = $varry = array();
        foreach($data as $key => $val){
            $karry[] = $key;
            $varry[] = "'".$val."'";
        }
        $kstr = implode(",",$karry);
        $vstr = implode(",",$varry);
        $strQuery = "INSERT INTO shipping_sal_table (".$kstr.") VALUES (".$vstr.")";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => $this->lang['lang_added_new_item'],//"Added New Item!",
            "data" => $result
        );
        $this->output($str);
    }

    public function save_ship_sal_edit_record($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
//print_r($data);die();
        //Check user profits are already set or new
        $strQuery = "SELECT * FROM shipping_sal_table WHERE `id`='".$this->clean($data['id'])."'";

        $result = $CI->db->query($strQuery);
        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($data as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE shipping_sal_table SET ".$str_set."  WHERE `id`='".$this->clean($data['id'])."'";
        }else{
            $karry = $varry = array();
            foreach($data as $key => $val){
                $karry[] = $key;
                $varry[] = "'".$val."'";
            }
            $kstr = implode(",",$karry);
            $vstr = implode(",",$varry);
            $strQuery = "INSERT INTO shipping_sal_table (".$kstr.") VALUES (".$vstr.")";
        }


        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($data['id'])."] ".$this->lang['lang_update'].' '.$this->lang['lang_success'],//Update Success!
            "data" => $result
        );
        $this->output($str);
    }

    public function delete_ship_sal_row($data,$userdata){
        $CI =   & get_instance();
        //Check user profits are already set or new
        $strQuery = "DELETE FROM shipping_sal_table WHERE `id`='".$this->clean($data['id'])."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($data['id'])."] ".$this->lang['lang_delete'].' '.$this->lang['lang_success'],//Delete Success!
            "data" => $result
        );
        $this->output($str);
    }

    /************
     * MWS part
     * @param $data
     * @param $userdata
     */
    public function register_mws_info($data,$userdata){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table = 'mws_info_table';

        //make db matching data
        $db_data = array(
            'user_id' => $user_id,
            'region' => $data['site'],
            'mws_access_key' => $data['access_key'],
            'mws_secret_key' => $data['security_key'],
            'merchantId' => $data['merchant_id'],
            'marketpaceId' => $data['marketplace_id']
        );
        //Check user profits are already set or new
        $strQuery = "SELECT * FROM ".$table." WHERE `user_id`='".$user_id."' AND `region`='".$data['site']."'";

        $result = $CI->db->query($strQuery);
        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($db_data as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE ".$table." SET ".$str_set."  WHERE `user_id`='".$user_id."' AND `region`='".$data['site']."'";
        }else{
            $karry = $varry = array();
            foreach($db_data as $key => $val){
                $karry[] = $key;
                $varry[] = "'".$val."'";
            }
            $kstr = implode(",",$karry);
            $vstr = implode(",",$varry);
            $strQuery = "INSERT INTO ".$table." (".$kstr.") VALUES (".$vstr.")";
        }


        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => $this->lang['lang_register']." ".$this->lang['lang_success'],//"Register Success!",
            "data" => $result
        );
        $this->output($str);
    }

    public function release_mws_info($data,$userdata){

        $CI =   & get_instance();

        //get current user email or id
        $user_id = $userdata['id'];
        $table = 'mws_info_table';

        //Check user profits are already set or new
        $strQuery = "DELETE FROM ".$table." WHERE `user_id`='".$user_id."' AND `region`='".$data['site']."'";

        $result = $CI->db->query($strQuery);

        $msg = 'Release Success!';
        if(!$result){
            $msg = $this->lang['lang_register']." ".$this->lang['lang_error'];//'Release Error!';
            $result = array();
        }
        $str = array(
            "msg" => $msg,
            "data" => $result
        );
        $this->output($str);
    }

    public function get_mws_info($data,$userdata){

        $CI =   & get_instance();

        //get current user email or id
        $user_id = $userdata['id'];
        $table = 'mws_info_table';

        //Check user profits are already set or new
        $strQuery = "SELECT * FROM ".$table." WHERE `user_id`='".$user_id."' AND `region`='".$data."'";

        $result = $CI->db->query($strQuery);

        if($result->num_rows == 0){
            $msg = $this->lang['lang_get']." ".$this->lang['lang_error'];//'Get Error!';
            $str = array(
                "msg" => $msg,
                "data" => array()
            );
            $this->output($str);exit;
        }else{
            $msg = $this->lang['lang_get']." ".$this->lang['lang_success'];//'Get Success!';
            $str = array(
                "msg" => $msg,
                "data" => $result->result()[0]
            );
            $this->output($str);
        }
    }

    /************
     * AWS part
     * @param $data
     * @param $userdata
     */
    public function register_aws_info($data,$userdata){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table = 'aws_info_table';

        $new_aws_key_group = $data;

        //Get all pre key groups
        $strQuery = "SELECT aws_keys FROM ".$table." WHERE `user_id`='".$user_id."'";
        $result = $CI->db->query($strQuery);

        if(count($result->result()) > 0){
            $key_groups = unserialize($result->result()[0]->aws_keys);
            $key_groups[] = $data;

            $key_groups = array_unique($key_groups, SORT_REGULAR);
            //make db matching data
            $db_data = array(
                'user_id' => $user_id,
                'aws_keys' => serialize($key_groups)
            );
            $set_arry = array();
            foreach($db_data as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE ".$table." SET ".$str_set."  WHERE `user_id`='".$user_id."'";
        }else{
            //make db matching data
            $key_groups = array();
            $key_groups[] = $data;
            $db_data = array(
                'user_id' => $user_id,
                'aws_keys' => serialize($key_groups)
            );
            $karry = $varry = array();
            foreach($db_data as $key => $val){
                $karry[] = $key;
                $varry[] = "'".$val."'";
            }
            $kstr = implode(",",$karry);
            $vstr = implode(",",$varry);
            $strQuery = "INSERT INTO ".$table." (".$kstr.") VALUES (".$vstr.")";
        }


        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => $this->lang['lang_register']." ".$this->lang['lang_success'],//"Register Success!",
            "data" => $result
        );
        $this->output($str);
    }

    public function release_aws_info($data,$userdata){

        $CI =   & get_instance();

        //get current user email or id
        $user_id = $userdata['id'];
        $table = 'aws_info_table';

        $strQuery = "SELECT aws_keys FROM ".$table." WHERE `user_id`='".$user_id."'";
        $result = $CI->db->query($strQuery);
        //get key_group list
        $key_groups = unserialize($result->result()[0]->aws_keys);
        //remove current_key
        $new_group_list = array();
        foreach($key_groups as $key_group){
            if($key_group['access_key'] != $data['access_key']){
                $new_group_list[] = $key_group;
            }
        }
        //make db matching data
        $db_data = array(
            'user_id' => $user_id,
            'aws_keys' => serialize($new_group_list)
        );
        $set_arry = array();
        foreach($db_data as $key => $val){
            $set_arry[] = $key."='".$val."'";
        }
        $str_set = implode(",",$set_arry);
        $strQuery = "UPDATE ".$table." SET ".$str_set."  WHERE `user_id`='".$user_id."'";
        $result = $CI->db->query($strQuery);

        $msg = 'Release Success!';
        if(!$result){
            $msg = $this->lang['lang_register']." ".$this->lang['lang_error'];//'Release Error!';
            $result = array();
        }
        $str = array(
            "msg" => $msg,
            "data" => $result
        );
        $this->output($str);
    }

    public function get_aws_info($data,$userdata){

        $CI =   & get_instance();

        //get current user email or id
        $user_id = $userdata['id'];
        $table = 'aws_info_table';

        $strQuery = "SELECT aws_keys FROM ".$table." WHERE `user_id`='".$user_id."'";
        $result = $CI->db->query($strQuery);

        if($result->num_rows == 0){

            $msg = $this->lang['lang_get']." ".$this->lang['lang_error'];//'Get Error!';
            $str = array(
                "msg" => $msg,
                "data" => array()
            );
            $this->output($str);exit;
        }else{
            //get key_group list
            $key_groups = unserialize($result->result()[0]->aws_keys);

            $msg = $this->lang['lang_get']." ".$this->lang['lang_success'];//'Get Success!';
            $str = array(
                "msg" => $msg,
                "data" => $key_groups
            );
            $this->output($str);
        }
    }
    /**
     * @param $str
     */
    public function output($str){
        print_r(json_encode(
            array(
                'response' => $str
            )
        ));
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    /**
     * Get all lang data
     * @return mixed
     *
     */
    public function get_lang_data(){

        $CI =   & get_instance();
        $lang = $CI->lang_model->get_textdata();
        return $lang;
    }
}


/**
 * Main Process
 */
$settings = new Setting();
switch($action){
    case 'exchange_setup_register':
        $settings->exchange_setting_register($data,$userdata);
        break;
    case 'exchange_setup_release':
        $settings->exchange_setting_release($data,$userdata);
        break;
    case 'ship_ems_tb':
        $settings->get_ship_ems_table();
        break;
    case 'ship_sal_tb':
        $settings->get_ship_sal_table();
        break;
    case 'ship_epacket_tb':
        $settings->get_ship_epacket_table();
        break;
    case 'set_profit_setting':
        $settings->set_profit_setting($data,$userdata);
        break;
    case 'get_profit_setting':
        $settings->get_profit_setting($userdata);
        break;
    case 'get_exchange_setting':
        $settings->get_exchange_setting($userdata);
        break;
    case 'get_buy_limit_asin_info':
        $settings->get_buy_limit_asin_info($data,$userdata);
        break;
    case 'get_all_buy_limit_asin':
        $settings->get_all_buy_limit_asin($userdata);
        break;
    case 'add_new_buy_limit_asin':
        $settings->add_new_buy_limit_asin($data,$userdata);
        break;
    case 'delete_buy_limit_asin':
        $settings->delete_buy_limit_asin($data,$userdata);
        break;
    case 'get_reg_edit_search_info':
        $settings->get_reg_edit_search_info($data,$userdata);
        break;
    case 'save_reg_edit_asin_info':
        $settings->save_reg_edit_asin_info($data,$userdata);
        break;
    case 'add_ship_ems_new_record':
        $settings->add_ship_ems_new_record($data,$userdata);
        break;
    case 'save_ship_ems_edit_record':
        $settings->save_ship_ems_edit_record($data,$userdata);
        break;
    case 'delete_ship_ems_row':
        $settings->delete_ship_ems_row($data,$userdata);
        break;
    case 'add_ship_epacket_new_record':
        $settings->add_ship_epacket_new_record($data,$userdata);
        break;
    case 'save_ship_epacket_edit_record':
        $settings->save_ship_epacket_edit_record($data,$userdata);
        break;
    case 'delete_ship_epacket_row':
        $settings->delete_ship_epacket_row($data,$userdata);
        break;
    case 'add_ship_sal_new_record':
        $settings->add_ship_sal_new_record($data,$userdata);
        break;
    case 'save_ship_sal_edit_record':
        $settings->save_ship_sal_edit_record($data,$userdata);
        break;
    case 'delete_ship_sal_row':
        $settings->delete_ship_sal_row($data,$userdata);
        break;
    case 'register_mws_info':
        $settings->register_mws_info($data,$userdata);
        break;
    case 'release_mws_info':
        $settings->release_mws_info($data,$userdata);
        break;
    case 'get_mws_info':
        $settings->get_mws_info($data,$userdata);
        break;
    case 'register_aws_info':
        $settings->register_aws_info($data,$userdata);
        break;
    case 'release_aws_info':
        $settings->release_aws_info($data,$userdata);
        break;
    case 'get_aws_info':
        $settings->get_aws_info($data,$userdata);
        break;
    default:
        $settings->output(array($action,$data));
        break;
}
