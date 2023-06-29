<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/1/14
 * Time: 9:36 AM
 */

require_once __DIR__."/config.php";
require( 'ssp.class.php' );


class Search{
    public $request;
    public $db_con;
    public $result_table;
    public function __construct(){
        $this->request = $_GET;
        /**
         * DB setting
         */
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $this->db_con = new PDO("mysql:host=$db_host;dbname=$db_name", DB_USER, DB_PASSWORD);
        $this->result_table = "search_result_";
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
     * Get all japan asin result that user uploaded
     * @param $userdata
     */
    public function get_jp_asin_table($userdata){

        // Table's primary key
        $primaryKey = 'asin';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $CI =   & get_instance();
        $columns = array(
            array( 'db' => 'asin',              'dt' => 0 ),
            array( 'db' => 'number_of_sellers', 'dt' => 1 ),
            array( 'db' => 'lowest_price',      'dt' => 2 ),
            array( 'db' => 'lowest_ship_price',   'dt' => 3 ),
            array( 'db' => 'title',             'dt' => 4 ),
            array( 'db' => 'manufacture',       'dt' => 5 ),
            array( 'db' => 'category',         'dt' => 6 ),
            array( 'db' => 'rank',             'dt' => 7 ),
            array( 'db' => 'release_date',     'dt' => 8 ),
            array( 'db' => 'weight',          'dt' => 9 ),
            array( 'db' => 'length',          'dt' => 10 ),
            array( 'db' => 'height',          'dt' => 11 ),
            array( 'db' => 'width',           'dt' => 12 ),
            array( 'db' => 'image',           'dt' => 13 ),
            array( 'db' => 'import_date',     'dt' => 14 ),
            array( 'db' => 'last_update_date',     'dt' => 15 )
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );

        $table  =   "asin_aws_info_". strval($userdata['id']);

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );
    }

    /**
     * @param $userdata
     */
    public function get_world_asin_table($userdata){

        $CI =   & get_instance();

        $table_name = "asin_world_result_".$userdata['id'];

        $result = $CI->db->query("SHOW TABLES LIKE '$table_name'");

        if($result->num_rows == 0)
        {
            //create or update datatable contents
            $this->create_world_asin_result_table($userdata['id']);
        }

        // Table's primary key
        $primaryKey = 'asin';

        $columns = array(
            array( 'db' => 'asin',          'dt' => 0),
            array( 'db' => 'jp_number_of_sellers',          'dt' => 1 ),
            array( 'db' => 'jp_lowest_price',          'dt' => 2 ),
            array( 'db' => 'jp_lowest_ship_price',          'dt' => 3 ),
            array( 'db' => 'us_number_of_sellers',          'dt' => 4 ),
            array( 'db' => 'us_lowest_price',          'dt' => 5 ),
            array( 'db' => 'us_lowest_ship_price',          'dt' => 6 ),
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
     * This function is generate new table for world-asin datatable
     *
     * @param $user_id
     */
    public function create_world_asin_result_table($user_id){
        $CI = & get_instance();
        $table_name = "asin_world_result_$user_id";
        $src_table = "asin_mws_info_$user_id";

        $result = $CI->db->query("SHOW TABLES LIKE '$table_name'");

        if($result->num_rows == 0)
        {
            $query = "CREATE TABLE IF NOT EXISTS  `".DB_NAME."`.`". $table_name. "` (
                          `asin` varchar(255) ,

                          `jp_number_of_sellers` double,
                          `jp_lowest_price` double,
                          `jp_lowest_ship_price` double ,

                          `us_number_of_sellers` double,
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
        $strQuery   =  "INSERT INTO `$table_name` ( asin, jp_number_of_sellers, jp_lowest_price, jp_lowest_ship_price, us_number_of_sellers, us_lowest_price, us_lowest_ship_price ,last_update_date) ";
        $strQuery   .=  "SELECT a.asin, a.number_of_sellers, a.lowest_price, a.lowest_ship_price, n.number_of_sellers, n.lowest_price, n.lowest_ship_price,n.last_update_date ";
        $strQuery   .=  "FROM (SELECT asin,number_of_sellers,lowest_price,lowest_ship_price,last_update_date FROM `$src_table` WHERE region='jp')  a ";
        $strQuery   .=  "LEFT JOIN (SELECT asin,number_of_sellers,lowest_price,lowest_ship_price,last_update_date FROM `$src_table` WHERE region='us') n ON n.asin = a.asin";
print_r($strQuery);
        $result = $CI->db->query($strQuery);

        $str = array(
            "msg" => "Success refreshed world asin table result!",//$this->lang['lang_saved']
            "data" => $strQuery
        );
        //$this->output($str);
    }
}

$search = new Search();

switch($action){
    case 'get_world_asin_tb':
        $search->get_world_asin_table($userdata);
        break;
    case 'get_jp_asin_tb':
        $search->get_jp_asin_table($userdata);
        break;
    case 'create_world_asin_tb':
        $search->create_world_asin_result_table($userdata['id']);
    default:
        $search->output(array($action,$data));
        break;
}