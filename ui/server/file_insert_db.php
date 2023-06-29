<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/9/14
 * Time: 9:54 AM
 */
/**
 * Insert file to db
 *  1.get filename
 *  2.insert file to db
 *  3.delete inserted file
 */

require_once __DIR__.'/config.php';

/**
 * Class Parser
 *
 * Control csv file parse status
 */
Class Parser{
    /* language process */
    public $lang;
    /***
     * Constructor
     */
    public function __construct(){
        //load all lang words
        $this->lang = $this->get_lang_data();
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

    public function insertCSVToDB($table,$absFilePath,$ignore_line1=""){
        //insert data to db from csv file
        try{
            /*
            LOAD DATA LOCAL INFILE 'file.csv' INTO TABLE t1
            FIELDS TERMINATED BY ',' ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\r\n'
            (@col1) set asin=@col1;
            */

            $arr = explode("\\",$absFilePath);
            $file = end($arr);

            $strQuery   =   "LOAD DATA LOCAL INFILE '$absFilePath' REPLACE INTO TABLE `$table` FIELDS TERMINATED BY ',' ";
            $strQuery   .=  " ENCLOSED BY '".'"'."' ESCAPED BY '".'"'."' LINES TERMINATED BY '\r\n' " . $ignore_line1;
            $strQuery   .=  " (@col1) set asin=@col1 ";
            $this->exec_jquery($strQuery);
           
            return true;
        }catch( PDOException $Exception ) {
            //throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
            //$this->output(array('msg' => $Exception));
            return false;
        }
    }
    
    public function update_aws_table($user_id,$file){
        //upload relate info update
        $table = 'asin_aws_info_'.$user_id;
        $src_table = "jp_asin_aws_info";
        /***
         * Query sample:
         *
        UPDATE
        `".$table."`,
        `".$src_table."`
        SET

        `".$table."`.`number_of_sellers` = 0,

        `".$table."`.`length` = `".$src_table."`.`length_cm`,
        `".$table."`.`height` = `".$src_table."`.`height_cm`,
        `".$table."`.`width` = `".$src_table."`.`width_cm`,
        `".$table."`.`weight` = `".$src_table."`.`weight_kg`,

        `".$table."`.`lowest_price` = `".$src_table."`.`lowest_new_price`,
        `".$table."`.`lowest_ship_price` = 0,
        `".$table."`.`category` = `".$src_table."`.`category`,
        `".$table."`.`rank` = `".$src_table."`.`rank`,
        `".$table."`.`release_date` = `".$src_table."`.`release_date`,

        `".$table."`.`title` = `".$src_table."`.`title`,
        `".$table."`.`manufacture` = `".$src_table."`.`manufacture`,
        `".$table."`.`image` = `".$src_table."`.`image`,
        `import_date`='".date("Y-m-d h:i:s")."',
        `import_file_name`='".$file."'
        WHERE
        `".$table."`.`asin` = `".$src_table."`.`asin` AND `".$table."`.`import_file_name` IS NULL
         */

        $strQuery   =   "UPDATE
                        `".$table."`,
                        `".$src_table."`
                         SET
                        `".$table."`.`number_of_sellers` = `".$src_table."`.`total_new`+`".$src_table."`.`total_used`,

                        `".$table."`.`length` = `".$src_table."`.`length_cm`,
                        `".$table."`.`height` = `".$src_table."`.`height_cm`,
                        `".$table."`.`width` = `".$src_table."`.`width_cm`,
                        `".$table."`.`weight` = `".$src_table."`.`weight_kg`,

                        `".$table."`.`lowest_price` = `".$src_table."`.`lowest_new_price`,
                        `".$table."`.`lowest_ship_price` = `".$src_table."`.`lowest_ship_price`,
                        `".$table."`.`category` = `".$src_table."`.`category`,
                        `".$table."`.`rank` = `".$src_table."`.`rank`,
                        `".$table."`.`release_date` = `".$src_table."`.`release_date`,

                        `".$table."`.`title` = `".$src_table."`.`title`,
                        `".$table."`.`manufacture` = `".$src_table."`.`manufacture`,
                        `".$table."`.`image` = `".$src_table."`.`image`,
                        `import_date`='".date("Y-m-d h:i:s")."',
                        `import_file_name`='".$file."'
                         WHERE
                        `".$table."`.`asin` = `".$src_table."`.`asin` AND
                        `".$table."`.`import_file_name` IS NULL";

        $this->exec_jquery($strQuery);
    }

    public function update_mws_table($user_id,$file){

        $table = 'asin_mws_info_'.$user_id;
        $asin_table = 'asin_aws_info_'.$user_id;
        $region_arry = array(
            'jp',
            'us'
        );

        foreach($region_arry as $region){

            //insert all asin for user to mws table
            $src_table = $region."_asin_mws_info";
            /**
             * insert into asin_mws_info_43 (asin, region, number_of_sellers, lowest_price, lowest_ship_price, import_date, last_update_date, import_file_name)
             * select b.asin, "jp", b.total_new+b.total_used, b.lowest_new_price, 0, Now(), Now(),"ss" from asin_aws_info_43 a inner join jp_asin_aws_info b on a.asin=b.asin
             */
            $strQuery   =  "INSERT INTO ".$table." (asin, region, number_of_sellers, lowest_price, lowest_ship_price, import_date, last_update_date, import_file_name) ";
            $strQuery   .= "select b.asin, '".$region."', b.total_new+b.total_used, b.lowest_price, b.lowest_shipping, Now(), Now(),'".$file."' from ".$asin_table." a inner join ".$src_table." b on a.asin=b.asin";

            $this->exec_jquery($strQuery);
        }
    }

    public function initialize_aws_table($table,$file){
        $strQuery   =   "UPDATE
                        `".$table."`
                         SET
                        `last_update_date`='".date("Y-m-d h:i:s")."',
                        `import_date`='".date("Y-m-d h:i:s")."',
                        `import_file_name`='".$file."'
                         WHERE
                        `".$table."`.`import_file_name` IS NULL";
        return $this->exec_jquery($strQuery);
    }

    public function initialize_mws_table($user_id,$file){

        $table = 'asin_mws_info_'.$user_id;
        $asin_table = 'asin_aws_info_'.$user_id;
        $region_arry = array(
            'jp',
            'us'
        );

        $strQuery   = "DELETE FROM $table WHERE 1;";
        $this->exec_jquery($strQuery);

        foreach($region_arry as $region){

            /**
             * insert into asin_mws_info_43 (asin, region, number_of_sellers, lowest_price, lowest_ship_price, import_date, last_update_date, import_file_name)
             * select b.asin, "jp", b.total_new+b.total_used, b.lowest_new_price, 0, Now(), Now(),"ss" from asin_aws_info_43 a inner join jp_asin_aws_info b on a.asin=b.asin
             */
            $strQuery   =  "INSERT INTO ".$table." (asin, region, import_date, last_update_date, import_file_name) ";
            $strQuery   .= "select a.asin, '".$region."', Now(), Now(),a.import_file_name from ".$asin_table." a ";

            $this->exec_jquery($strQuery);
        }
    }

    public function exec_jquery($query)
    {
        $CI = & get_instance();
        return $CI->db->query($query);
    }

    public function valid_file($file_path){
        /****
         * 1.check file exist
         * 2.check file type,that has or not asin field
         **/
        if (file_exists($file_path)) {
            //check csv file has 'asin' field or not
            $handle = fopen($file_path, "r");
            $titles = fgetcsv($handle, 2000, ",");
            fclose($handle);
            //$titles convert to lower
            $lower_titles = array();
            foreach($titles as $title){
                $lower_titles[] = strtolower($title);
            }

            if (in_array("asin", $lower_titles)) {
                return true;
            }else{
                $this->output(
                    array(
                        'msg'=> $this->lang['lang_asin_field_no_exist'],
                        'data' => array()
                    )
                );
                exit();       //'ASIN field no exist!'
            }
        } else {
            $this->output(
                array(
                    'msg' => $this->lang['lang_file_no_exist'],
                    'data' => array()
                )
            );
            exit();         //'File no exist!'
        }
    }

    public function get_imported_data($userdata){

        $CI =   & get_instance();
        //get current user email or id
        $user_id = $userdata['id'];
        $table_name = "asin_aws_info_".strval($userdata['id']);
        //Check user profits are already set or new
        $strQuery = "SELECT DISTINCT import_file_name,import_date FROM ".$table_name;

        $result = $CI->db->query($strQuery);

        $res_arry = $result->result();

        $response = array(
            "msg" => 'Success get',
            "data" => $res_arry
        );
        $this->output($response);
    }

    public function delete_file_on_db($data,$userdata){
        /**
         * 1.delete from aws info table
         * 2.delete from mws info table
         */
        $CI =   & get_instance();
        //res
        $result = array();
        //get delete file name
        $file = $data['file'];
        //Delete from asin_aws_table_[id]
        $table_name = "asin_aws_info_".$userdata['id'];
        $strQuery = "DELETE FROM $table_name WHERE import_file_name='$file'";

        $result['aws_delete'] = $CI->db->query($strQuery);

        //Delete from asin_mws_table_[id]
        $table_name = "asin_mws_info_".$userdata['id'];
        $strQuery = "DELETE FROM $table_name WHERE import_file_name='$file'";

        $result['mws_delete'] = $CI->db->query($strQuery);

        $response = array(
            "msg" => "Success deleted all data of $file from db",
            "data" => $result
        );
        $this->output($response);
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
}

/**
 * Main process
 */
// main process

$parser = new Parser();

switch($action){
    case 'file_insert_db':

        $CI = & get_instance();

        $file = $data['file'];
        $filepath = __DIR__.'/files/'.$file;
        $absFilePath = __DIR__."/files/".$file;
        $absFilePath = str_replace("/", "\\", $absFilePath);
        $absFilePath = str_replace("\\", "\\\\", $absFilePath);

        $userdata = $CI->login_model->get_cur_user_info();
        //check $file_path is valid
        if(!$parser->valid_file($absFilePath)){
            //if file is invalid,then remove the file
            unlink($absFilePath);
            $response = array(
                'msg' => $file.$parser->lang['lang_invalid_file_format'],       //invalid file format
                'data' => array()
            );
            $parser->output($response);
            exit();
        }

        $str_msg = '';
        //insert to AWS info table
        $table_name = "asin_aws_info_".strval($userdata['id']);

        $ignore_line1 = "IGNORE 1 LINES";
        if($parser->insertCSVToDB($table_name,$absFilePath,$ignore_line1)){

            //aws initialize
            $parser->initialize_aws_table($table_name,$file);

            //mws initialize
            $parser->initialize_mws_table($userdata['id'],$file);

            //update some fields from main src table
            $parser->update_aws_table($userdata['id'],$file);

            //update some fields from main src table
            $parser->update_mws_table($userdata['id'],$file);

            $str_msg .= $file.$parser->lang['lang_data_insert_success']; //$file." data insert success"
        }
        else{
            $str_msg .= $file." data insert failed"; //$file." data insert failed"
        }

        //remove inserted file
        unlink($absFilePath);
        $response = array(
            'msg' => $str_msg,
            'data' => array()
        );
        $parser->output( $response );
        break;
    case 'get_imported_data':
        $parser->get_imported_data($userdata);
        break;
    case 'delete_file_on_db':
        $parser->delete_file_on_db($data,$userdata);
        break;
    default:
        break;
}






