<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 11:31 PM
 */

class SettingHandler {
    public $data;
    public $userdata;
    public $table;

    function __construct($data=array(),$userdata=array()){
        $CI =   & get_instance();
        $this->data = $data;
        $this->userdata = $userdata;
        $this->table = $userdata['id']."_setting";
        if($this->is_empty_setting()){
            //insert
            $db_data = array(
                'aws' => json_encode(array())
            );
            $result = $CI->db->insert($this->table, $db_data);
        }
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
     * Convert object to array,array to object function
     * @param $d
     * @return array
     */
    public function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            //return array_map(__FUNCTION__, $d);
            return array_map(__METHOD__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }

    public function arrayToObject($d) {
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return (object) array_map(__METHOD__, $d);
        }
        else {
            // Return object
            return $d;
        }
    }

    public function is_empty_setting(){
        $CI =   & get_instance();
        $row_cnt = $CI->db->count_all_results($this->table);
        if($row_cnt >0 )return false;
        return true;
    }

    /**
     * Get AWS info
     */
    public function get_aws_info(){

        $CI =   & get_instance();

        $CI->db->select('aws');
        $result = $CI->db->get($this->table);

        //json_decode
        if($result->num_rows == 0){
            $response = array();
        }else{
            $response = json_decode($result->result()[0]->aws);
        }
        $str = array(
            "msg" => "Success Get AWS info all!",
            "data" => $response
        );
        $this->output($str);
    }

    public function register_aws_info(){
        $CI =   & get_instance();
        /**
         * if table empty then insert new record
         * else update record
         */
        if($this->is_empty_setting()){
            //insert
            $db_data = array(
                'aws' => json_encode($this->data)
            );
            $result = $CI->db->insert($this->table, $db_data);
        }else{
            //update
            //make new db data
            $CI->db->select('aws');
            $result = $CI->db->get($this->table);
            //json_decode
            if($result->num_rows == 0){
                $opt_arry = array();
            }else{
                $opt_arry = $this->objectToArray(json_decode($result->result()[0]->aws));
            }
            $opt_arry[]=$this->data;
            //unique process
            $opt_arry = array_unique($opt_arry,SORT_REGULAR);
            $db_data = array(
                'aws' => json_encode($opt_arry)
            );
            $result = $CI->db->update($this->table, $db_data);
        }
    }

    public function delete_aws_info(){
        $CI =   & get_instance();
        //get current aws setting
        $CI->db->select('aws');
        $result = $CI->db->get($this->table);
        //json_decode
        if($result->num_rows == 0){
            $opt_arry = array();
        }else{
            $opt_arry = json_decode($result->result()[0]->aws);
        }
        //Remove request aws info
        $new_arry= array();
        foreach($opt_arry as $k => $item){
            if(!(($item->access_key === $this->data['access_key'])&&($item->security_key === $this->data['security_key']))){
                $new_arry[] = $item;
            }
        }
        //make db data
        $db_data = array(
            'aws' => json_encode($new_arry)
        );
        $result = $CI->db->update($this->table, $db_data);
    }

    /**
     * Get MWS info
     */
    public function get_mws_info($site=''){

        $CI =   & get_instance();

        $CI->db->select('mws');
        $result = $CI->db->get($this->table);

        //json_decode
        if($result->num_rows == 0){
            $response = array();
        }else{
            $response = $this->objectToArray(json_decode($result->result()[0]->mws));
        }
        if(!isset($response))return array();

        if($site == '')return $response;

        foreach($response as $key => $item){

            if($item['site'] == $site){
                return $item;
            }
        }
        return array();
    }

    public function register_mws_info(){
        $CI =   & get_instance();
        /**
         * if table empty then insert new record
         * else update record
         */
        //update
        //make new db data
        $opt_arry = $this->get_mws_info();

        if($this->is_exist_site($opt_arry,$this->data['site'])){
            $opt_arry = $this->replace_mws($opt_arry,$this->data);

        }else{
            $opt_arry[] = $this->data;
        }

        $db_data = array(
            'mws' => json_encode($opt_arry)
        );
        $result = $CI->db->update($this->table, $db_data);
    }

    public function release_mws_info(){
        $CI =   & get_instance();
        //get current mws setting
        //make new db data
        $opt_arry = $this->get_mws_info();

        //Remove request aws info
        $new_arry= array();
        foreach($opt_arry as $k => $item){
            //print_r($item);
            if($item['site'] !== $this->data['site']){
                $new_arry[] = $item;
            }
        }
        //make db data
        $db_data = array(
            'mws' => json_encode($new_arry)
        );

        $result = $CI->db->update($this->table, $db_data);

    }

    public function replace_mws($src_arry,$new_mws){
        $new_arry = array();
        foreach($src_arry as $key => $val){
            if(($val['site'] == $new_mws['site'])){
                $new_arry[] = $new_mws;
            }else{
                $new_arry[] = $val;
            }
        }
        return $new_arry;
    }

    public function is_exist_site($src_arry,$site){

        foreach($src_arry as $key => $val){
            if(($val['site'] == $site))return true;
        }
        return false;
    }

    /**
     * Get exchange rates
     */
    public function get_rates_info(){
        $CI =   & get_instance();

        $CI->db->select('currency');
        $result = $CI->db->get($this->table);

        //json_decode
        if($result->num_rows == 0){
            $response = array();
        }else{
            $response = $this->objectToArray(json_decode($result->result()[0]->currency));
        }
        if(!isset($response))return array();

        return $response;
    }

    public function set_rates_info(){
        $CI =   & get_instance();
        /**
         * if table empty then insert new record
         * else update record
         */
        //add date field
        $this->data['date'] = date('Y-m-d h:i:s');
        //update
        $db_data = array(
            'currency' => json_encode($this->data)
        );
        return $CI->db->update($this->table, $db_data);
    }

    /**
     * Get shipping
     */
    public function get_ship_ems_table(){
        $CI =   & get_instance();

        $columns = array(
            array( 'db' => 'id',           'dt' => 0 ),
            array( 'db' => 'weight_min',           'dt' => 1 ),
            array( 'db' => 'weight_max',         'dt' => 2 ),
            array( 'db' => 'com_price',          'dt' => 3 ),
            array( 'db' => 'uk_price',        'dt' => 4 )
        );
        // Table's primary key
        $primaryKey = 'id';
        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        $table  =   $this->userdata['id']."_ship_ems_price";

        $order = "ORDER BY weight_min ASC ";
        echo json_encode(
            SSP::get_tb_by_custom_order( $_GET, $sql_details, $table, $primaryKey, $columns ,$order )
        );
    }

    public function get_ship_epacket_table(){
        // Table's primary key
        $primaryKey = 'id';

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

        $table  =   $this->userdata['id']."_ship_epacket_price";

        $order = "ORDER BY weight_min ASC ";
        echo json_encode(
            SSP::get_tb_by_custom_order( $_GET, $sql_details, $table, $primaryKey, $columns ,$order )
        );
    }

    public function get_ship_sal_table(){
        // Table's primary key
        $primaryKey = 'id';

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

        $table  =   $this->userdata['id']."_ship_sal_price";

        $order = "ORDER BY weight_min ASC ";
        echo json_encode(
            SSP::get_tb_by_custom_order( $_GET, $sql_details, $table, $primaryKey, $columns ,$order )
        );
    }
    public function get_content_tb(){
        $CI =   & get_instance();

        $columns = array(
            array( 'db' => 'id',           'dt' => 0 ),
            array( 'db' => 'content',           'dt' => 1 )
        );
        // Table's primary key
        $primaryKey = 'id';
        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        $table  =   $this->userdata['id']."_content_tb";

        $order = "ORDER BY content  ASC ";
        echo json_encode(
            SSP::get_tb_by_custom_order( $_GET, $sql_details, $table, $primaryKey, $columns ,$order )
        );
    }
    /**
     * Shipping options part
     * @param $data
     * @param $userdata
     */

    public function get_ship_options(){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        $table = $this->userdata['id'].'_ship_option';

        $result = $CI->db->get($table);

        /*** cast the object ***/
        if(!empty($result)){
            $result_arry = (array) $result->result();
        }else{
            $result_arry = array();
        }

        $response = array(
            "msg" => "",
            "data" =>$result_arry
        );
        $this->output($response);
    }

    public function set_ship_options(){
        $CI =   & get_instance();
        //get current user email or id
        $table = $this->userdata['id'].'_ship_option';
        //ready data
        //make db matching data
        $db_data = array(
            'ship_mode' => $this->data['ship_mode'],
            'fee' => $this->data['fee'],
            'track_number' => $this->data['track_number'],
            'track_number_over' => $this->data['track_number_over'],
            'discount' => $this->data['discount'],
            'default_weight' => $this->data['default_weight'],
            'default_size' => $this->data['default_size'],
            'default_length' => $this->data['default_length']
        );
        //Check user profits are already set or new
        $where = array('ship_mode' => $this->data['ship_mode']);
        $result = $CI->db->get_where($table, $where);

        if(!empty($result) && (count($result->result()) > 0)){
            $CI->db->where('ship_mode', $this->data['ship_mode']);
            $query = $CI->db->update($table,$db_data);
        }else{
            $query = $CI->db->insert($table,$db_data);
        }

        //response
        $msg = 'Shipping options stored successfully!';
        $str = array(
            "msg" => $msg,
            "data" => $query
        );
        $this->output($str);
    }

    /**
     * Shipping record part
     */
    public function add_content_record(){
        $CI =   & get_instance();

        $db_data = array(
            'content' => $this->data['content']
        );

        $table = $this->userdata['id']."_content_tb";

        $result = $CI->db->insert($table, $db_data);

        $str = array(
            "msg" => "Added New Item!",
            "data" => $result
        );
        $this->output($str);
    }
    public function add_ems_record(){
        $CI =   & get_instance();

        $db_data = array(
            'weight_min' => $this->data['weight_min'],
            'weight_max' => $this->data['weight_max'],
            'com_price' => $this->data['us_ship'],
            'uk_price' => $this->data['euro_ship']
        );

        $table = $this->userdata['id']."_ship_ems_price";

        $result = $CI->db->insert($table, $db_data);

        $str = array(
            "msg" => "Added New Item!",
            "data" => $result
        );
        $this->output($str);
    }

    public function add_epacket_record(){
        $CI =   & get_instance();

        $db_data = array(
            'weight_min' => $this->data['weight_min'],
            'weight_max' => $this->data['weight_max'],
            'price' => $this->data['ship']
        );
        $table = $this->userdata['id']."_ship_epacket_price";

        $result = $CI->db->insert($table, $db_data);

        $str = array(
            "msg" => "Added New Item!",
            "data" => $db_data
        );
        $this->output($str);

    }

    public function add_sal_record(){
        $CI =   & get_instance();

        $db_data = array(
            'weight_min' => $this->data['weight_min'],
            'weight_max' => $this->data['weight_max'],
            'price' => $this->data['ship']
        );
        $table = $this->userdata['id']."_ship_sal_price";

        $result = $CI->db->insert($table, $db_data);

        $str = array(
            "msg" => "Added New Item!",
            "data" => $result
        );
        $this->output($str);
    }
    public function save_content_record(){
        $CI =   & get_instance();
        //table
        $table = $this->userdata['id']."_content_tb";

        $db_data = array(
            'content' => $this->data['content']
        );
        $CI->db->where('id',$this->data['id']);
        $result = $CI->db->update($table, $db_data);

        $str = array(
            "msg" => " record updated!",//Update  成功！
            "data" => $db_data
        );
        $this->output($str);
    }
    public function save_ems_record(){
        $CI =   & get_instance();
        //table
        $table = $this->userdata['id']."_ship_ems_price";

        $db_data = array(
            'weight_min' => $this->data['weight_min'],
            'weight_max' => $this->data['weight_max'],
            'com_price' => $this->data['us_ship'],
            'uk_price' => $this->data['euro_ship']
        );
        $CI->db->where('id',$this->data['id']);
        $result = $CI->db->update($table, $db_data);

        $str = array(
            "msg" => "EMS record updated!",//Update  成功！
            "data" => $db_data
        );
        $this->output($str);
    }

    public function save_epacket_record(){
        $CI =   & get_instance();
        //table
        $table = $this->userdata['id']."_ship_epacket_price";

        $db_data = array(
            'weight_min' => $this->data['weight_min'],
            'weight_max' => $this->data['weight_max'],
            'price' => $this->data['ship']
        );
        $CI->db->where('id',$this->data['id']);
        $result = $CI->db->update($table, $db_data);

        $str = array(
            "msg" => "ePacket record updated!",//Update  成功！
            "data" => $result
        );
        $this->output($str);
    }

    public function save_sal_record(){
        $CI =   & get_instance();
        //table
        $table = $this->userdata['id']."_ship_sal_price";

        $db_data = array(
            'weight_min' => $this->data['weight_min'],
            'weight_max' => $this->data['weight_max'],
            'price' => $this->data['ship']
        );
        $CI->db->where('id',$this->data['id']);
        $result = $CI->db->update($table, $db_data);

        $str = array(
            "msg" => "SAL record updated!",//Update  成功！
            "data" => $result
        );
        $this->output($str);
    }
    public function delete_content_row(){
        $CI =   & get_instance();
        $table = $this->userdata['id']."_content_tb";
        //Check user profits are already set or new
        $strQuery = "DELETE FROM ".$table." WHERE `id`='".$this->clean($this->data['id'])."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($this->data['id'])."] Delete  成功！",
            "data" => $result
        );
        $this->output($str);
    }

    public function delete_ship_ems_row(){
        $CI =   & get_instance();
        $table = $this->userdata['id']."_ship_ems_price";
        //Check user profits are already set or new
        $strQuery = "DELETE FROM ".$table." WHERE `id`='".$this->clean($this->data['id'])."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($this->data['id'])."] Delete  成功！",
            "data" => $result
        );
        $this->output($str);
    }

    public function delete_ship_epacket_row(){
        $CI =   & get_instance();
        $table = $this->userdata['id']."_ship_epacket_price";
        //Check user profits are already set or new
        $strQuery = "DELETE FROM ".$table." WHERE `id`='".$this->clean($this->data['id'])."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($this->data['id'])."] Delete  成功！",
            "data" => $result
        );
        $this->output($str);
    }

    public function delete_ship_sal_row(){
        $CI =   & get_instance();
        $table = $this->userdata['id']."_ship_sal_price";
        //Check user profits are already set or new
        $strQuery = "DELETE FROM ".$table." WHERE `id`='".$this->clean($this->data['id'])."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ID[".$this->clean($this->data['id'])."] Delete  成功！",
            "data" => $result
        );
        $this->output($str);
    }

    /**
     * Profit options part
     */
    public function get_profit_options(){
        $CI =   & get_instance();

        $CI->db->select('profit');
        $result = $CI->db->get($this->table);

        //json_decode
        if($result->num_rows == 0){
            $response = array();
        }else{
            $response = $this->objectToArray(json_decode($result->result()[0]->profit));
        }
        if(!isset($response))return array();

        return $response;
    }

    public function set_profit_options(){
        $CI =   & get_instance();
        /**
         * if table empty then insert new record
         * else update record
         */
        //add date field
        $this->data['date'] = date('Y-m-d h:i:s');
        //update
        $db_data = array(
            'profit' => json_encode($this->data)
        );
        return $CI->db->update($this->table, $db_data);
    }

    /**
     * Purchase ban part
     */
    public function get_purchase_limit_tb(){

        $CI = & get_instance();
        // Table's primary key
        $primaryKey = 'asin';
        //get current user email or id
        $user_id = $this->userdata['id'];
        //Column define
        $columns = array(
            array( 'db' => 'asin',          'dt' => 0 ),
            array( 'db' => 'expire_date',           'dt' => 1 )
        );
        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );
        //Result table
        $table = $user_id."_purchase_limit_asin";
        //Get result
        $result = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
        //Count remain days from expire_date
        $new_data = array();
        foreach($result['data'] as $item){
            //calc remain days
            $now = time(); // or your date as well
            $your_date = strtotime($item[1]);       //$item[1]  =  expire_date field
            $datediff = $your_date - $now;
            $remain_days = floor($datediff/(60*60*24));
            $new_data[] = array($item[0],$remain_days+1);
        }
        $result['data'] = $new_data;
        //Response
        echo json_encode($result);
    }

    public function delete_purchase_limit_asin(){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        $asin = $this->clean($this->data['asin']);

        $table = $user_id."_purchase_limit_asin";

        $strQuery = "DELETE FROM ".$table." WHERE `asin`='".$asin."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "ASIN release  成功！",
            "data" => $result
        );
        $this->output($str);
    }

    public function add_new_purchase_limit_asin(){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        $db_data = array(
            'asin' => $this->data['asin'],
            'expire_date' => date('Y-m-d', strtotime("+".$this->data['limit_days']." days"))
        );

        $table = $user_id."_purchase_limit_asin";

        $result = $CI->db->get_where($table, array('asin' => $this->data['asin']));

        if(count($result->result()) > 0){
            $CI->db->where('asin', $this->data['asin']);
            $result = $CI->db->update($table,$db_data);
        }else{
            $result = $CI->db->insert($table,$db_data);
        }

        $str = array(
            "msg" => "ASIN[".$db_data['asin']."] 保管されてい。",
            "data" => $result
        );
        $this->output($str);
    }

    /**
     * Export ban part
     * @param $data
     * @param $userdata
     */
    public function get_export_ban_asin_tb(){

        $CI =   & get_instance();

        //get current user email or id
        $table = $this->userdata['id'].'_export_ban_asin';
        // columns
        $columns = array(
            array( 'db' => 'asin',         'dt' => 0 ),
            array( 'db' => 'insert_date',  'dt' => 1 ),
            array( 'db' => 'region',       'dt' => 2 ),
            array( 'db' => 'id',           'dt' => 'id' )
        );
        // Table's primary key
        $primaryKey = 'id';
        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname
        );
        //filter by region
        $filter_arry = array(
            'region' => $this->data['region']
        );
        // response
        echo json_encode(
            SSP::filter_column( $_GET, $sql_details, $table, $primaryKey, $columns, $filter_arry )
        );
    }
    public function get_export_ban_title_tb(){
        $CI =   & get_instance();

        //get current user email or id
        $table = $this->userdata['id'].'_export_ban_title';
        // columns
        $columns = array(
            array( 'db' => 'title',        'dt' => 0 ),
            array( 'db' => 'insert_date',  'dt' => 1 ),
            array( 'db' => 'region',       'dt' => 2 ),
            array( 'db' => 'id',           'dt' => 'id' )
        );
        // Table's primary key
        $primaryKey = 'id';
        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname
        );
        //filter by region
        $filter_arry = array(
            'region' => $this->data['region']
        );
        // response
        echo json_encode(
            SSP::filter_column( $_GET, $sql_details, $table, $primaryKey, $columns, $filter_arry )
        );
    }
    public function get_export_ban_manufacture_tb(){
        $CI =   & get_instance();

        //get current user email or id
        $table = $this->userdata['id'].'_export_ban_manufacture';
        // columns
        $columns = array(
            array( 'db' => 'manufacture',  'dt' => 0 ),
            array( 'db' => 'insert_date',  'dt' => 1 ),
            array( 'db' => 'region',       'dt' => 2 ),
            array( 'db' => 'id',           'dt' => 'id' )
        );
        // Table's primary key
        $primaryKey = 'id';
        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );
        //filter by region
        $filter_arry = array(
            'region' => $this->data['region']
        );
        // response
        echo json_encode(
            SSP::filter_column( $_GET, $sql_details, $table, $primaryKey, $columns, $filter_arry )
        );
    }
    public function add_export_ban_asin(){
        $CI =   & get_instance();
        $response = array();
        //get current user email or id
        $table = $this->userdata['id'].'_export_ban_asin';
        //ready data
        $db_data = array(
            'asin' => $this->data['asin'],
            'region' => $this->data['region'],
            'insert_date' => date('Y-m-d h:i:s')
        );
        $result = $CI->db->get_where($table, array('asin' => $this->data['asin'],'region' => $this->data['region']));

        if(count($result->result()) > 0){
            $response = array(
                "msg" => '既に存在します。',
                "data" => array()
            );
            $this->output($response);
        }else{
            $result = $CI->db->insert($table, $db_data);
            if($result){
                $msg = '保管されてい。';
            }else{
                $msg = 'Failed!';
            }
            $response = array(
                "msg" => $msg,
                "data" => $result
            );
            $this->output($response);
        }
    }
    public function add_export_ban_title(){
        $CI =   & get_instance();
        //get current user email or id
        $table = $this->userdata['id'].'_export_ban_title';
        //ready data
        $db_data = array(
            'title' => $this->data['title'],
            'region' => $this->data['region'],
            'insert_date' => date('Y-m-d h:i:s')
        );
        $result = $CI->db->get_where($table, array('title' => $this->data['title'],'region' => $this->data['region']));

        if(count($result->result()) > 0){
            $response = array(
                "msg" => '既に存在します。',
                "data" => array()
            );
            $this->output($response);
        }else{
            $result = $CI->db->insert($table, $db_data);
            if($result){
                $msg = '保管されてい。';
            }else{
                $msg = 'Failed!';
            }
            $response = array(
                "msg" => $msg,
                "data" => $result
            );
            $this->output($response);
        }
    }
    public function add_export_ban_manufacture(){
        $CI =   & get_instance();
        //get current user email or id
        $table = $this->userdata['id'].'_export_ban_manufacture';
        //ready data
        $db_data = array(
            'manufacture' => $this->data['manufacture'],
            'region' => $this->data['region'],
            'insert_date' => date('Y-m-d h:i:s')
        );

        $result = $CI->db->get_where($table, array('manufacture' => $this->data['manufacture'],'region' => $this->data['region']));

        if(count($result->result()) > 0){
            $response = array(
                "msg" => '既に存在します。',
                "data" => array()
            );
            $this->output($response);
        }else{
            $result = $CI->db->insert($table, $db_data);
            if($result){
                $msg = '保管されてい。';
            }else{
                $msg = 'Failed!';
            }
            $response = array(
                "msg" => $msg,
                "data" => $result
            );
            $this->output($response);
        }
    }
    public function delete_export_ban_asin(){
        $CI =   & get_instance();
        //get current user email or id
        $table = $this->userdata['id'].'_export_ban_asin';
        //make query
        $strQuery = "DELETE FROM ".$table." WHERE id='$this->data'";
        //get result
        $result = $CI->db->query($strQuery);
        //response
        $msg = 'DELETE  成功！';
        $str = array(
            "msg" => $msg,
            "data" => $result
        );
        $this->output($str);
    }
    public function delete_export_ban_title(){
        $CI =   & get_instance();
        //get current user email or id
        $table = $this->userdata['id'].'_export_ban_title';
        //make query
        $strQuery = "DELETE FROM ".$table." WHERE id='$this->data'";
        //get result
        $result = $CI->db->query($strQuery);
        //response
        $msg = 'DELETE  成功！';
        $str = array(
            "msg" => $msg,
            "data" => $result
        );
        $this->output($str);
    }
    public function delete_export_ban_manufacture(){
        $CI =   & get_instance();
        //get current user email or id
        $table = $this->userdata['id'].'_export_ban_manufacture';
        //make query
        $strQuery = "DELETE FROM ".$table." WHERE id='$this->data'";
        //get result
        $result = $CI->db->query($strQuery);
        //response
        $msg = 'DELETE  成功！';
        $str = array(
            "msg" => $msg,
            "data" => $result
        );
        $this->output($str);
    }

    /**
     * Auto setting part
     */
    public function get_auto_option_value(){
        $option = $this->data['option'];

        $CI =   & get_instance();

        $result = $CI->db->get($this->table);

        //json_decode
        if($result->num_rows == 0){
            return array();
        }else{
            $response = $result->result()[0];
        }
        if(!isset($response))return array();

        switch($option){
            case 'auto_info_update_chk':
                return $response->auto_info_update_chk;
                break;
            case 'auto_price_update_chk':
                return $response->auto_price_update_chk;
                break;
            case 'auto_price_update_val':
                return array(
                    'interval' => $response->auto_price_update_interval
                );
                break;
            case 'auto_handling_time_chk':
                return $response->auto_handling_time_chk;
                break;
            case 'auto_handling_time_val':
                return array(
                    'handling_time' => $response->auto_handling_time
                );
                break;
            case 'auto_item_note_chk':
                return $response->auto_item_note_chk;
                break;
            case 'auto_item_note_val':
                return array(
                    'ems_note_new' => $response->ems_item_note_new,
                    'ems_note_used' => $response->ems_item_note_used,
                    'sal_note_new' => $response->sal_item_note_new,
                    'sal_note_used' => $response->sal_item_note_used,
                    'epacket_note_new' => $response->epacket_item_note_new,
                    'epacket_note_used' => $response->epacket_item_note_used
                );
                break;
            case 'auto_feedback_chk':
                return $response->auto_feedback_chk;
                break;
            case 'auto_feedback_val':
                return array(
                    'feedback_count' => $response->auto_feedback_count ,
                    'feedback_rates' => $response->auto_feedback_rates,
                    'jp_seller_count_condition' => $response->jp_seller_count_condition,
                    'jp_shipping_time' => $response->jp_shipping_time
                );
                break;
            case 'auto_diff_price_control_val':
                return  array(
                    'auto_diff_price_control_val' => $response->auto_diff_price_control_val
                );
                break;
            default:
                return array();
                break;
        }
    }
    public function save_auto_option_value(){
        $option = $this->data['option'];
        $values = $this->data['values'];

        $CI =   & get_instance();

        $db_data = array();
        switch($option){
            case 'auto_price_update_val':
                $db_data = array(
                    'auto_price_update_interval' => $values['interval']
                );
                break;
            case 'auto_handling_time_val':
                $db_data = array(
                    'auto_handling_time' => $values['handling_time']
                );
                break;
            case 'auto_item_note_val':
                $db_data = array(
                    'ems_item_note_new' => $values['ems_new_note'],
                    'ems_item_note_used' => $values['ems_used_note'],
                    'sal_item_note_new' => $values['sal_new_note'],
                    'sal_item_note_used' => $values['sal_used_note'],
                    'epacket_item_note_new' => $values['epacket_new_note'],
                    'epacket_item_note_used' => $values['epacket_used_note']
                );
                break;
            case 'auto_feedback_val':
                $db_data = array(
                    'auto_feedback_count' => $values['feedback_count'],
                    'auto_feedback_rates' => $values['feedback_rates'],
                    'jp_seller_count_condition' => $values['jp_seller_count'],
                    'jp_shipping_time' => $values['jp_shipping_time']
                );
                break;
            case 'auto_diff_price_control_val':
                $db_data = array(
                    'auto_diff_price_control_val' => $values['diff_price_control_val']
                );
                break;
            default:
                $db_data = array();
                break;
        }

        $CI->db->update($this->table,$db_data);

    }
    public function update_auto_option_status(){
        $option = $this->data['option'];
        $status = $this->data['status'];

        if($status == "true"){
            $status = 1;
        }else{
            $status = 0;
        }

        $CI =   & get_instance();

        $db_data = array();
        switch($option){
            case 'auto_info_update_chk':
                $db_data = array(
                    'auto_info_update_chk' => $status
                );
                break;
            case 'auto_price_update_chk':
                $db_data = array(
                    'auto_price_update_chk' => $status
                );
                break;
            case 'auto_handling_time_chk':
                $db_data = array(
                    'auto_handling_time_chk' => $status
                );
                break;
            case 'auto_item_note_chk':
                $db_data = array(
                    'auto_item_note_chk' => $status
                );
                break;
            case 'auto_feedback_chk':
                $db_data = array(
                    'auto_feedback_chk' => $status
                );
                break;
            default:
                $db_data = array();
                break;
        }

        $CI->db->update($this->table,$db_data);

    }

    /**
     * Get default setting values
     */
    public function get_default_settings(){
        $CI =   & get_instance();
        //make select columns
        $select_str = 'auto_handling_time,auto_item_note_new,auto_item_note_used';

        $CI->db->select($select_str);
        //exec
        $result = $CI->db->get_where($this->table, array('id' => 1));

        $tmp_obj =$result->result()[0];

        $handling_time = explode(",",$tmp_obj->auto_handling_time);
        if(count($handling_time)>1){
            $result_arry = array('handling_time' => $handling_time[1]);
        }else{
            $result_arry = array('handling_time' => $handling_time[0]);
        }

        if($this->data['condition'] == "New"){
            $result_arry = array_merge($result_arry, array('item_note' =>  $tmp_obj->auto_item_note_new));
        }else{
            $result_arry = array_merge($result_arry,array('item_note' =>  $tmp_obj->auto_item_note_used));
        }

        $response = array(
            "msg" => "",
            "data" =>$result_arry
        );
        $this->output($response);
    }

    /**
     * Get profit table
     */
    public function get_profit_table(){
        $CI =   & get_instance();

        $columns = array(
            array( 'db' => 'profit_min',           'dt' => 0 ),
            array( 'db' => 'profit_max',         'dt' => 1 ),
            array( 'db' => 'amount',          'dt' => 2 ),
            array( 'db' => 'percent',        'dt' => 3 ),
            array( 'db' => 'id',           'dt' => 4 ),
        );
        // Table's primary key
        $primaryKey = 'id';
        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        $table  =   $this->userdata['id']."_profit";

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );
    }
    public function add_profit_record(){
        $CI =   & get_instance();
        $table = $this->userdata['id']."_profit";

        $db_data = array(
            'profit_min' => $this->data['profit_min'],
            'profit_max' => $this->data['profit_max'],
            'amount' => $this->data['amount'],
            'percent' => $this->data['percent']
        );

        $result = $CI->db->insert($table, $db_data);

        $msg = "成功!";
        if(!$result)$msg="失敗!";
        $str = array(
            "msg" => $msg,
            "data" => $result
        );
        $this->output($str);
    }
    public function save_profit_record(){
        $CI =   & get_instance();
        //table
        $table = $this->userdata['id']."_profit";

        $db_data = array(
            'profit_min' => $this->data['profit_min'],
            'profit_max' => $this->data['profit_max'],
            'amount' => $this->data['amount'],
            'percent' => $this->data['percent']
        );
        $CI->db->where('id',$this->data['id']);
        $result = $CI->db->update($table, $db_data);

        $msg = "成功!";
        if(!$result)$msg="失敗";
        $str = array(
            "msg" => $msg,
            "data" => $db_data
        );
        $this->output($str);
    }
    public function delete_profit_row(){
        $CI =   & get_instance();
        $table = $this->userdata['id']."_profit";
        //Check user profits are already set or new
        $strQuery = "DELETE FROM ".$table." WHERE `id`='".$this->clean($this->data['id'])."'";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "削除成功！",
            "data" => $result
        );
        $this->output($str);
    }
}