<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 11:32 PM
 */

class SubjectHandler {

    public $data;
    public $userdata;
    public $table;

    function __construct($data=array(),$userdata=array()){
        $this->data = $data;
        $this->userdata = $userdata;
        $this->table = "subject_tb";
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
        $primaryKey = 'subject_id';
        //Columns define
        $columns = array(
            array( 'db' => 'subject_tb.subject_id',     'dt' => 'subject_id' ),
            array( 'db' => 'subject_tb.subject_name',     'dt' => 'name' ),
            array( 'db' => 'subject_tb.tutor_id',      'dt' => 'tutor_id' ),
            array( 'db' => 'subject_tb.price_per_hour',      'dt' => 'price_per_hour' ),
            array( 'db' => 'subject_tb.start_date',      'dt' => 'start_time' ),
            array( 'db' => 'subject_tb.end_date',      'dt' => 'end_time'),

            array( 'db' => 'user.user_email',      'dt' => 'user_email')

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
            $filter_where.=" subject_tb.start_date>=date('".$start_date."')";
        }
        if($end_date!='')
        {
            if($filter_where!='')
                $filter_where.=' and ';
            $filter_where.=" subject_tb.start_date<=date_add(date('".$end_date."'),interval 1 day)";

        }
         if($this->userdata['role']!=='admin'){
             if($filter_where!='')
                 $filter_where.=' and ';
             $filter_where.= " subject_tb.tutor_id=".$this->userdata['id'];
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
        $join_where="user.id=subject_tb.tutor_id";
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
    public function add_subject_infor_mobile($member_id,$data){
        $response = array(
            'result' => 'ERR',
            'msg' => '',
            'data' => ''
        );
        $data['tutor_id']=$member_id;
        $CI =   & get_instance();
        $CI->db->where(array('subject_name' => $data['subject_name'],'tutor_id' => $data['tutor_id']));
        $result=$CI->db->get($this->table);

        if($result && $result->num_rows()>0){

            return "Already Exist Subject Name!";
        }
        else{
            $result = $CI->db->insert($this->table,$data);
            if(!isset($result) || $result==false){
                return  "Insert Failed !";
            }
        }
        return "";
    }
    public function update_subject_infor_mobile($member_id,$data){
        $response = array(
            'result' => 'ERR',
            'msg' => '',
            'data' => ''
        );
        $data['tutor_id']=$member_id;
        $CI =   & get_instance();
        $CI->db->where(array('subject_id !='=>$data['subject_id'],'subject_name' => $data['subject_name'],'tutor_id' => $data['tutor_id']));
        $result=$CI->db->get($this->table);

        if($result && $result->num_rows()>0){
            return "Already Exist Subject Name!";
        }
        else{
            $CI->db->where(array('subject_id '=>$data['subject_id']));
            $result = $CI->db->update($this->table,$data);
            if(!isset($result) || $result==false){
                return  "Update Failed !";

            }
        }
        return "";
    }
    public function delete_subject_infor_mobile($member_id,$subject_data){
        $data=$subject_data;
        $data['tutor_id']=$member_id;

        $CI =   & get_instance();

        $table="booking_tb";
        $CI->db->where(array('subject_id '=>$data['subject_id']));
        $result=$CI->db->get($table);
        if($result && $result->num_rows()>0){
            return "The Subject Exist into Booking List.";
        }
        $CI->db->where(array('subject_id '=>$data['subject_id'],'tutor_id' => $data['tutor_id']));
        $result=$CI->db->delete($this->table);
        if(!isset($result) || $result==false){
            return  "Delete Failed !";
        }
        return "";
    }
    public function delete_subject_infor(){
        $response = array(
            'result' => 'ERR',
            'msg' => '',
            'data' => ''
        );
        $data=$this->data;
        $data['tutor_id']=$this->userdata['id'];
        $CI =   & get_instance();
        $msg = "Success!";
        $res="OK";
        $table="booking_tb";
        $CI->db->where(array('subject_id '=>$data['subject_id']));

        $result=$CI->db->get($table);
        if($result && $result->num_rows()>0){
            $res="ERR";
            $msg="The Subject Exist into Booking List.";

        }
        else{
            $CI->db->where(array('subject_id '=>$data['subject_id'],'tutor_id' => $data['tutor_id']));
            $result=$CI->db->delete($this->table);
            if(!isset($result) || $result==false){
                $res="ERR";
                $msg="Delete Failed !";

            }
            $result='OK';
        }

        $response['msg'] = $msg;
        $response['data'] = $data;
        $response['result'] = $result;
        $this->output($response);

    }
    public function add_subject_infor($isMobile=false){
        $response = array(
            'result' => 'ERR',
            'msg' => '',
            'data' => ''
        );
        $data=$this->data;
        $data['tutor_id']=$this->userdata['id'];
        $CI =   & get_instance();
        $CI->db->where(array('subject_name' => $data['subject_name'],'tutor_id' => $data['tutor_id']));
        $result=$CI->db->get($this->table);
        $msg = "Success!";
        $res="OK";
        if($result && $result->num_rows()>0){
            $res="ERR";
            $msg="Already Exist Subject Name!";
        }
        else{
            $result = $CI->db->insert($this->table,$data);


            if(!isset($result) || $result==false){
                $msg = "Failed !";
                $res="ERR";
            }
        }
        $response['msg'] = $msg;
        $response['data'] = $data;
        $response['result'] = $res;

        if($isMobile)
            return $response;
        else
            $this->output($response);
    }
    public function update_subject_infor($isMobile=false){
        $response = array(
            'result' => 'ERR',
            'msg' => '',
            'data' => ''
        );
        $data=$this->data;
        $data['tutor_id']=$this->userdata['id'];

        $CI =   & get_instance();
        $CI->db->where(array('subject_id !='=>$data['subject_id'],'subject_name' => $data['subject_name'],'tutor_id' => $data['tutor_id']));
        $result=$CI->db->get($this->table);
        $msg = "Success!";
        $res="OK";
        if($result && $result->num_rows()>0){
            $res="ERR";
            $msg="Already Exist Subject Name!";
        }
        else{
            $CI->db->where(array('subject_id '=>$data['subject_id']));
            $result = $CI->db->update($this->table,$data);
            if(!isset($result) || $result==false){
                $msg = "Failed !";
                $res="ERR";
            }
        }
        $response['msg'] = $msg;
        $response['data'] = $data;
        $response['result'] = $res;

        if($isMobile)
            return $response;
        else
            $this->output($response);
    }
    public function delete_subject(){
        $response = array(
            'result' => 'ERR',
            'msg' => '',
            'data' => ''
        );
        $data=$this->data;
        $data['tutor_id']=$this->userdata['id'];

        $CI =   & get_instance();
        $CI->db->where(array('subject_id !='=>$data['subject_id'],'subject_name' => $data['subject_name'],'tutor_id' => $data['tutor_id']));
        $result=$CI->db->get($this->table);
        $msg = "Success!";
        $res="OK";
        if($result && $result->num_rows()>0){
            $res="ERR";
            $msg="Already Exist Subject Name!";
        }
        else{
            $CI->db->where(array('subject_id '=>$data['subject_id']));
            $result = $CI->db->update($this->table,$data);
            if(!isset($result) || $result==false){
                $msg = "Failed !";
                $res="ERR";
            }
        }
        $response['msg'] = $msg;
        $response['data'] = $data;
        $response['result'] = $res;

        if($isMobile)
            return $response;
        else
            $this->output($response);
    }
    public function exist_subject_name(){


        $tutor_id=$this->userdata['id'];
        $subject_name=$_POST['subject_name'];
        $subject_id=isset($_POST['subject_id'])?$_POST['subject_id']:0;
        $count=0;
        //echo $subject_id;
        print_r($this->data);
        $CI =   & get_instance();
        if($this->data['isAdd']!=='true')
            $count++;

        $CI->db->where(array('subject_name' => $subject_name,'tutor_id' => $tutor_id));
        //else        $CI->db->where(array('subject_id !='=>$subject_id,'subject_name' => $subject_name,'tutor_id' => $tutor_id));

        $result=$CI->db->get($this->table);
        if($result && $result->num_rows()>$count){
            echo 'false';
        }
        else{
            echo 'true';
        }
    }
    public function set_id_product_info(){
        $id_product = $this->data['id_product'];
        $select_no = $this->data['select_no'];
        $asin = $this->data['asin'];

        $CI =   & get_instance();
        $CI->db->where(array('id_product' => $id_product,'id_lang' => 1));
        $db_data = array(
            'asin1' => $asin,
            'select_no' => $select_no
        );
        $table="ps_marketplace_product_option";
        $result = $CI->db->update($table,$db_data);

        $msg = "Success Save!";
        if(!isset($result) || $result==false)$msg = "Failed Save!";

        $response = array(
            'msg' => $msg,
            'data' => $result
        );
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

}
