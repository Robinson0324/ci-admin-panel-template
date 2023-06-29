<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/28/14
 * Time: 11:32 PM
 */

class JobHandler {
    public $data;
    public $userdata;
    public $table;
    public $JobRegDate;
    function __construct($data=array(),$userdata=array()){
        $this->data = $data;
        $this->userdata = $userdata;
        $this->table = 'job_list';
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

    public function register_new_job(){
        $CI =   & get_instance();

        $job = $this->data['job'];
        $param = $this->data['param'];
        /*
        $param = array(
            'type' => $this->data['param']['type'],
            'value' => $this->data['param']['value']
        );
        */
        $register_time = date('Y-m-d H:i:s');
        $user_id = $this->userdata['id'];

        if($this->is_instant_job($job)){
            //Regsiter new job on job_list with complete
            $db_data = array(
                'user_id' => $user_id,
                'action' => $job,
                'param' => json_encode($param),
                'complete' => 1,
                'percent' => 100,
                'message' => "完成",
                'instant' => 1,
                'register_time' => $register_time
            );
            //$result = $CI->db->insert($this->table,$db_data);
            //Process Instant Jobs
            $this->process_instant_jobs($this->data);
            return '';
        }else{

                $this->JobRegDate=$register_time;

            return '';
        }
    }

    public function process_instant_jobs($data=array()){

        switch($data['job']){
            case 'product_detail':
                $this->product_detail($data['param']);
                break;
            case 'product_delete':
                $this->product_delete($data['param']);
                break;

        }
    }
    public function product_detail($param){

        $CI =   & get_instance();
        $table = "product_tb";
        $target = $param['type'];
        $id_product=$param['value'];
        $query=" select * from  $table  where id=$id_product";
        $result = $CI->db->query($query);
        //=====================
        print_r($result->result());// $query;

    }
    public function product_delete($param){

        $CI =   & get_instance();
        $table = "product_tb";
        $target = $param['type'];
        $id_product=$param['value'];
        $query=" delete  from $table  where id=$id_product";
        $CI->db->query($query);
        //echo $query;
    }
    public function get_filter_condition($param){
        $res ='';
        switch($param){

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

    public function is_instant_job($action){
        $instant_actions = array("product_detail",
            "product_delete"
        );

        if (in_array($action, $instant_actions))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_job_status(){

        /*$action = $this->data['job'];
        //$param = json_encode($this->data['param']);
        $CI =   & get_instance();
        //print_r( $this->data['param']);
        $CI->db->where(array('action' => $action,'register_time' => $this->data['param']));
        $CI->db->select('*');
        $result = $CI->db->get($this->table);
        $data = 0;$msg = '';
        if(isset($result) && !empty($result)){
            $last = end($result->result());
            if(isset($last) && is_object($last)){
                $data = $last->complete;
                $msg = $last->message;
            }
        }*/
        $response = array(
            'msg' => 'Success',
            'data' => 'ok'
        );
        $this->output($response);
    }

    public function save_product_edit_info(){
        $CI =   & get_instance();
        $table = $this->userdata['id']."_product";

        $data = array(
            'asin' => $this->data['asin'],
            'us_sku' => $this->data['sku'],
            'condition' => $this->data['condition'],
            'us_comment' => $this->data['comment'],
            'us_handling_time' => $this->data['handling_time'],
            'us_price' => $this->data['list_price'],
            'us_stock' => $this->data['stock'],
            'us_amazon_fee' => $this->data['fee'],
            'us_ship_price' => $this->data['ship_price'],
            'us_ship_mode' => $this->data['ship_mode'],
            'us_profit_amount' => $this->data['profit_amount']
        );

        $CI->db->where('asin', $data['asin']);
        $CI->db->where('condition', $data['condition']);
        $result = $CI->db->update($table, $data);

        $this->output(array(
            'msg' => 'Update success!',
            'data' => $result
        ));
    }
}
