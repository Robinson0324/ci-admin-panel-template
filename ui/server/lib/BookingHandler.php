<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 11:32 PM
 */

class BookingHandler {

    public $data;
    public $userdata;
    public $table;

    function __construct($data=array(),$userdata=array()){
        $this->data = $data;
        $this->userdata = $userdata;
        $this->table = "booking_tb";
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

    public function get_research_tb(){
	
	    $CI =   & get_instance();
        //get current user email or id
        $user_id = $this->userdata['id'];

        //if user no exist then create table
        // Select 1 from table_name will return false if the table does not exist.
        $table_name = $this->table;
        //Set primary key field
        $primaryKey = 'booking_id';
        //Columns define
        $columns = array(
            array( 'db' => 'booking_tb.booking_id',     'dt' => 'booking_id' ),
            array( 'db' => 'booking_tb.booking_name',     'dt' => 'booking_name' ),
            array( 'db' => 'booking_tb.student_id',      'dt' => 'student_id' ),
            array( 'db' => 'booking_tb.subject_id',      'dt' => 'subject_id' ),
            array( 'db' => 'booking_tb.tutor_id',      'dt' => 'tutor_id' ),
            array( 'db' => 'booking_tb.start_date',      'dt' => 'start_date' ),
            array( 'db' => 'booking_tb.end_date',      'dt' => 'end_date' ),
            array( 'db' => 'booking_tb.status',      'dt' => 'status' ),
            array( 'db' => 'booking_tb.additional_info',      'dt' => 'additional_info' ),
            array( 'db' => 'subject_tb.subject_name',      'dt' => 'subject_name' ),
            array( 'db' => 'subject_tb.price_per_hour',      'dt' => 'price_per_hour' ),
            array( 'db' => 'user.user_email',      'dt' => 'user_email' ),


        );
        /**
         * Custom filter apply part
         */

        $param = $_GET['param'];
        if($param['type']=='filter'){
            $filter_where = $this->get_filter_condition($param);
        }
        //echo $filter_where;
//=========date =========
        $filter_where='';
        $start_date='';
        $end_date='';
        if(isset($param['start_date']))
            $start_date=$param['start_date'];
        if(isset($param['end_date']))
            $end_date=$param['end_date'];
        if($start_date!='')
        {
            if($filter_where!='')
                $filter_where.=' and ';
            $filter_where.=" booking_tb.start_date>=date('".$start_date."')";
        }
        if($end_date!='')
        {
            if($filter_where!='')
                $filter_where.=' and ';
            $filter_where.=" booking_tb.start_date<=date_add(date('".$end_date."'),interval 1 day)";

        }
        if($this->userdata['role']!=='admin'){
            if($filter_where!='')
                $filter_where.=' and ';
            $filter_where.=$this->userdata['role']==="tutor" ? " booking_tb.tutor_id=".$this->userdata['id'] : " booking_tb.student_id=".$this->userdata['id'];
        }
        // SQL server connection information
        $sql_details = array(
            'user' => $CI->db->username,
            'pass' =>  $CI->db->password,
            'db'   =>  $CI->db->database,
            'host' =>  $CI->db->hostname,
        );


        $join_table_array=array();
        $join_table="user";
        $join_where=" booking_tb.student_id=user.id";

        $join_table_array[]=array("table"=>$join_table,"where"=>$join_where);

        $join_table="subject_tb";
        $join_where="subject_tb.subject_id=booking_tb.subject_id";
        $join_table_array[]=array("table"=>$join_table,"where"=>$join_where);


        echo json_encode(
            SSP::get_tb_by_join_condition( $_GET, $sql_details,$table_name, $join_table_array, $primaryKey, $columns ,$filter_where )
        );
    }

    /**
     * Get CSV ASIN data from file and it insert to database
     */
    public function file_db_insert_handler(){
        $str_msg = '';
        $file = $this->data['file'];

        //check file type
        if($this->is_valid_file($file)){
            //true
        }else{
            //false
        }

        //target table for insert
        $table_name = $this->table;

        if($this->insertCSVToDB($table_name,$file))
        {
            //pre process

            //make message
            $str_msg .= $file." data insert success";
        }
        else
        {
            //make message
            $str_msg .= $file." data insert failed"; //$file." data insert failed"
        }

        //if needs ,remove inserted file
        $this->remove_file($file);

        //response
        $response = array(
            'msg' => $str_msg,
            'data' => array()
        );
        $this->output( $response );
    }

    public function insertCSVToDB($table,$file){
        $CI =   & get_instance();
        $absFilePath = $this->get_abs_file_path($file);
        //insert data to db from csv file
        try{
/*
            //backup
            $tmp_table = "csv_upload_tmp_table";
            $strQuery = "DROP TABLE IF EXISTS `".DB_NAME."`.`". $tmp_table. "`;";
            $result = $CI->db->query($strQuery);
            $strQuery = "CREATE TABLE IF NOT EXISTS  $tmp_table (
                        `asin` varchar(100) NOT NULL DEFAULT '',
                        `jan` varchar(255) DEFAULT NULL,
                        `condition` varchar(30) NOT NULL DEFAULT '',
                         PRIMARY KEY (`asin`,`condition`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AS SELECT * FROM $table;";
            $result = $CI->db->query($strQuery);
*/
            //new items insert
            $strQuery   =   "
             LOAD DATA LOCAL INFILE '$absFilePath'
                  INTO TABLE `$table`
                  CHARACTER SET utf8
                  FIELDS
                    TERMINATED BY ','
                    OPTIONALLY
                    ENCLOSED BY '".'"'."'
                    ESCAPED BY '".'"'."'
                  LINES
                    TERMINATED BY '\r\n' IGNORE 1 LINES
                  (`asin`);";

            $result = $CI->db->query($strQuery);

            //update
            //$strQuery   =   "";
            //$result = $CI->db->query($strQuery);
            return true;
        }catch( PDOException $Exception ) {
            //throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
            //$this->output(array('msg' => $Exception));
            return false;
        }
    }

    public function get_abs_file_path($file){
        /**
         * This will work on windows folder system
         */
        $absFilePath = FCPATH."ui/files/".$file;
        //$absFilePath = str_replace("/", "\\", $absFilePath);
        //$absFilePath = str_replace("\\", "\\\\", $absFilePath);
        return $absFilePath;
    }

    public function remove_file($file){

        $abs_path = $this->get_abs_file_path($file);

        unlink($abs_path);
    }

    public function is_valid_file($file){
        $abs_path = $this->get_abs_file_path($file);

        //get file header column number
        $handle = fopen($abs_path, "r");
        $titles = fgetcsv($handle, 2000, ",");
        fclose($handle);

        if(count($titles)==13){
            //if csv file header column number is 13 then jp
            return true;
        }else{
            //if csv file header column number is 13 then world
            return false;
        }
    }

    public function get_filter_condition($param){
        $res = '';
        switch($param['value']){
            case 'no_weight':
                return "weight=0";
                break;
            case 'weight':
                return "weight>0";
                break;
            case 'is_used':
                return "`condition`='Used'";
                break;
            case 'profit_plus':
                return "`us_prev_profit`>0";
                break;
            case 'profit_minus':
                return "`us_prev_profit`<= 0";
                break;
            case 'export_ban':
                return "`us_is_out_ban`=1";
                break;
            case 'is_adult':
                return "`is_adult`=1";
                break;
            case 'is_listed':
                return "`us_stock`>0 AND `us_is_listed`=1";
                break;
            case 'is_stop':
                return "`us_stock`=0 AND `us_is_listed`=1";
                break;
            case 'is_none_listed':
                return "`us_is_listed`=0";
                break;
            case 'has_jp_sellers':
                return "`jp_seller_num`>0";
                break;
            case 'is_none_price':
                return "`us_price`=0";
                break;
            case 'is_ship_ems':
                return "`us_ship_mode`='EMS'";
                break;
            case 'us_unregistered':
                return "`us_lowest_price`=0 AND (`us_info_update_date`!='' OR `us_info_update_date`!=NULL)";
                break;
            case 'preorder':
                return "`jp_status`=1";
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
            'msg' => $data,
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

    public function set_product_info(){
        $asin = $this->data['asin'];
        $condition = $this->data['condition'];

        $CI =   & get_instance();
        $CI->db->where(array('asin' => $asin,'condition' => $condition));
        $db_data = array(
            'weight' => $this->data['weight'],
            'width' => $this->data['width'],
            'height' => $this->data['height'],
            'length' => $this->data['length']
        );

        $result = $CI->db->update($this->table,$db_data);

        $msg = "正常に保存!";
        if(!isset($result) || $result==false)$msg = "保存に失敗しました!";

        $response = array(
            'msg' => $msg,
            'data' => $result
        );
        $this->output($response);
    }
    public function start_auto_research(){



        $response = array(
            'msg' => 'Success',
            'data' => 'Success'
        );
        $this->output($response);
    }
    public function update_booking(){
        $data = $this->data;

        $response = array(
            'result' => 'OK',
            'msg' => '',
            'data' => ''
        );

        $CI =   & get_instance();

        $CI->db->where(array('booking_id '=>$data['booking_id']));
        $result = $CI->db->update($this->table,$data);
        if(!isset($result) || $result==false){
            $response['msg'] = "Update Failed !";
            $response['result'] = "Err";

        }
        $this->output($response);
    }
    public function delete_booking(){
        $data = $this->data;

        $response = array(
            'result' => 'OK',
            'msg' => '',
            'data' => ''
        );

        $CI =   & get_instance();

        $CI->db->where(array('booking_id '=>$data['booking_id']));
        $result = $CI->db->delete($this->table);
        if(!isset($result) || $result==false){
            $response['msg'] = "Delete Failed !";
            $response['result'] = "Err";

        }
        $this->output($response);
    }
    public  function file_download()
    {

        $filename   =   "aws_log.txt";
        $action=$_POST['data'];

        switch($action){
            case 'aws_download':
                $filename   =   "aws_log.txt";
                break;
            case 'fee_download':
                $filename   =   "fee_log.txt";
                break;
            case 'detail_download':
                $filename   =   "detail_log.txt";
                break;
            case 'price_download':
                $filename   =   "price_log.txt";
                break;
            case 'brand_download':
                $filename   =   "brand_log.txt";
                break;
            case 'key_download':
                $filename   =   "key_log.txt";
                break;
        }
        $DownloadPath =__DIR__."/../../files/tmp/".$filename;
        $base_url =  'http://';//$_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
        $base_url =$base_url. $_SERVER['HTTP_HOST'];
        $file = $base_url."/Amazing/ui/files/tmp/".$filename;

        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        readfile ($file);
        //}

    }

    public function add_booking_infor_mobile($member_id,$data){
        $response = array(
            'result' => 'ERR',
            'msg' => '',
            'data' => ''
        );
        $data['student_id']=$member_id;
        $CI =   & get_instance();
        $CI->db->where(array('booking_name' => $data['booking_name'],'student_id' => $data['student_id']));
        $result=$CI->db->get($this->table);

        if($result && $result->num_rows()>0){

            return "Already Exist Booking Name!";
        }
        else{

            $result = $CI->db->insert($this->table,$data);
            if(!isset($result) || $result==false){
                return  "Insert Failed !";
            }
        }
        return "";
    }
    public function update_booking_infor_mobile($member_id,$data){
        $response = array(
            'result' => 'ERR',
            'msg' => '',
            'data' => ''
        );
        $data['student_id']=$member_id;
        $CI =   & get_instance();
        $CI->db->where(array('booking_id !='=>$data['booking_id'],'booking_name' => $data['booking_name'],'student_id' => $data['student_id']));
        $result=$CI->db->get($this->table);

        if($result && $result->num_rows()>0){

            return "Already Exist Booking Name!";
        }
        else{
            $CI->db->where(array('booking_id '=>$data['booking_id']));
            $result = $CI->db->update($this->table,$data);
            if(!isset($result) || $result==false){
                return  "Update Failed !";

            }
        }
        return "";
    }
    public function delete_booking_infor_mobile($member_id,$data){
        $response = array(
            'result' => 'ERR',
            'msg' => '',
            'data' => ''
        );
        $data['student_id']=$member_id;
        $CI =   & get_instance();
        $CI->db->where(array('booking_id '=>$data['booking_id']));
        $result=$CI->db->delete($this->table);
        if(!isset($result) || $result==false){
            return  "Delete Failed !";
        }

        return "";
    }
}
