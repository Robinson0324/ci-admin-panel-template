<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/13/14
 * Time: 6:01 PM
 */


require_once __DIR__."/config.php";
require_once __DIR__."/file_insert_db.php";
require( 'ssp.class.php' );


class Update{
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

    public function save_revise_setting($data,$userdata){

        if((count($data['revise_sites']) == 0 )|| ($data['revise_times'] < 0)){
            $str = array(
                "msg" => "Invalid input data!",
                "data" => array()
            );
            $this->output($str);
            return;
        }

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table = "status";
        //Check user profits are already set or new
        $strQuery = "SELECT user_id FROM ".$table." WHERE `user_id`='".$user_id."'";
        $result = $CI->db->query($strQuery);

        $db_data = array(
            'user_id' => $user_id,
            'revise_sites' => serialize($data['revise_sites']),
            'revise_daily_times' => $data['revise_times']
        );

        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($db_data as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE ".$table." SET ".$str_set."  WHERE `user_id`='".$user_id."'";
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

        $result =  $CI->db->query($strQuery);

        $str = array(
            "msg" => $this->lang['lang_saved'],
            "data" => $result
        );
        $this->output($str);
    }

    public function get_revise_setting($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table = "status";
        //Check user profits are already set or new
        $strQuery = "SELECT revise_sites,revise_status,revise_daily_times FROM ".$table." WHERE `user_id`='".$user_id."'";

        $result = $CI->db->query($strQuery);

        $res_arry = $result->result();

        $res_arry[0]->revise_sites = unserialize($res_arry[0]->revise_sites);

        $str = array(
            "msg" => 'Success get',
            "data" => $res_arry[0]
        );
        $this->output($str);
    }

    public function get_revise_status($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table = "status";
        //Check user profits are already set or new
        $strQuery = "SELECT revise_status,revise_daily_times,revise_start_date FROM ".$table." WHERE `user_id`='".$user_id."'";

        $result = $CI->db->query($strQuery);

        $res_arry = $result->result();

        $str = array(
            "msg" => 'Success get',
            "data" => $res_arry[0]
        );
        $this->output($str);
    }

    public function revise_start($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table = "status";
        //Check user profits are already set or new
        $strQuery = "SELECT user_id FROM ".$table." WHERE `user_id`='".$user_id."'";
        $result = $CI->db->query($strQuery);

        $db_data = array(
            'user_id' => $user_id,
            'revise_status' => 1,
            'revise_start_date' => date('Y-m-d h:i:s')
        );

        if(count($result->result()) > 0){
            $set_arry = array();
            foreach($db_data as $key => $val){
                $set_arry[] = $key."='".$val."'";
            }
            $str_set = implode(",",$set_arry);
            $strQuery = "UPDATE ".$table." SET ".$str_set."  WHERE `user_id`='".$user_id."'";
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

        $result =  $CI->db->query($strQuery);

        $str = array(
            "msg" => "revise_start signal sent",//$this->lang['lang_saved']
            "data" => $result
        );
        $this->output($str);
    }

    public function revise_stop($data,$userdata){
        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table = "status";

        $db_data = array(
            'user_id' => $user_id,
            'revise_status' => 0
        );

        $set_arry = array();
        foreach($db_data as $key => $val){
            $set_arry[] = $key."='".$val."'";
        }
        $str_set = implode(",",$set_arry);

        $strQuery = "UPDATE ".$table." SET ".$str_set."  WHERE `user_id`='".$user_id."'";

        $result =  $CI->db->query($strQuery);

        $str = array(
            "msg" => "revise_stop signal sent",//$this->lang['lang_saved']
            "data" => $result
        );
        $this->output($str);
    }

    public function get_revise_result_tb($data,$userdata){

        $CI =   & get_instance();

        //get current user email or id
        $user_id = $userdata['id'];
        $table_name = "asin_revise_result_$user_id";

        $result = $CI->db->query("SHOW TABLES LIKE '$table_name'");

        if($result->num_rows == 0)
        {
            //create or update datatable contents
            $this->create_revise_result_table($user_id);
        }

        // Table's primary key
        $primaryKey = 'asin';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array( 'db' => 'asin',           'dt' => 0 ),
            array( 'db' => 'jp_lowest_price',         'dt' => 1 ),
            array( 'db' => 'jp_lowest_ship_price',          'dt' => 2 ),
            array( 'db' => 'jp_price',         'dt' => 3 ),
            array( 'db' => 'us_lowest_price',          'dt' => 4 ),
            array( 'db' => 'us_lowest_ship_price',         'dt' => 5 ),
            array( 'db' => 'us_price',          'dt' => 6 ),
            array( 'db' => 'last_update_date',          'dt' => 7 )
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table_name, $primaryKey, $columns )
        );
    }

    /*****
     * This function is generate new table for revise datatable
     *
     * @param $user_id
     */
    public function create_revise_result_table($user_id){
        $CI = & get_instance();
        $table_name = "asin_revise_result_$user_id";
        $src_table = "asin_revise_info_$user_id";

        $result = $CI->db->query("SHOW TABLES LIKE '$table_name'");

        if($result->num_rows == 0)
        {
            $query = "CREATE TABLE IF NOT EXISTS  `".DB_NAME."`.`". $table_name. "` (
                          `asin` varchar(255) ,

                          `jp_price` double,
                          `jp_lowest_price` double,
                          `jp_lowest_ship_price` double ,

                          `us_price` double,
                          `us_lowest_price` double,
                          `us_lowest_ship_price` double ,

                          `last_update_date` datetime ,
                          PRIMARY KEY (`asin`)
                     ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ; ";

            $result = $CI->db->query($query);
        }
        //delete all the old data
        $query = "DELETE  FROM $table_name WHERE 1;";
        $result = $CI->db->query($query);
        /**
        DELETE FROM asin_revise_result_1 WHERE 1;
        INSERT INTO asin_revise_result_1 ( asin, jp_price, jp_lowest_price, jp_lowest_ship_price, us_price, us_lowest_price, us_lowest_ship_price ,last_update_date)
        SELECT a.asin, a.price, a.lowest_price, a.lowest_ship_price, n.price, n.lowest_price, n.lowest_ship_price,n.last_update_date
        FROM (SELECT asin,price,lowest_price,lowest_ship_price,last_update_date FROM asin_revise_info_1 WHERE region="jp") a
        LEFT JOIN (SELECT asin,price,lowest_price,lowest_ship_price,last_update_date FROM asin_revise_info_1 WHERE region="us") n ON n.asin = a.asin
         */
        $strQuery   =  "INSERT INTO `$table_name` ( asin, jp_price, jp_lowest_price, jp_lowest_ship_price, us_price, us_lowest_price, us_lowest_ship_price ,last_update_date)
                        SELECT a.asin, a.price, a.lowest_price, a.lowest_ship_price, n.price, n.lowest_price, n.lowest_ship_price,n.last_update_date
                        FROM (SELECT asin,price,lowest_price,lowest_ship_price,last_update_date FROM `$src_table` WHERE region='jp')  a
                        LEFT JOIN (SELECT asin,price,lowest_price,lowest_ship_price,last_update_date FROM `$src_table` WHERE region='us') n ON n.asin = a.asin";

        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "Success refreshed revise result!",//$this->lang['lang_saved']
            "data" => $strQuery
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
}
/***********************************************************************************
 * Main process
 **********************************************************************************/
$update_handler = new Update();

switch($action){
    case 'save_revise_setting':
        $update_handler->save_revise_setting($data,$userdata);
        break;
    case 'get_revise_setting':
        $update_handler->get_revise_setting($data,$userdata);
        break;
    case 'get_revise_status':
        $update_handler->get_revise_status($data,$userdata);
        break;
    case 'revise_start':
        $update_handler->revise_start($data,$userdata);
        break;
    case 'revise_stop':
        $update_handler->revise_stop($data,$userdata);
        break;
    case 'revise_result_tb':
        $update_handler->get_revise_result_tb($data,$userdata);
        break;
    case 'create_revise_result_tb':
        $update_handler->create_revise_result_table($userdata['id']);
        break;
    case 'get_mws_info':
        $update_handler->get_mws_info($data,$userdata);
        break;
    default:
        $update_handler->output(array($action,$data));
        break;
}