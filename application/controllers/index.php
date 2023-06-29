<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:26 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //$this->login_model->logout();
        //$this->login_model->login();        
    }
  
    public function index()
    {

        //$this->test();
        redirect('dashboard/main/');
    }
    public function test()
	{
		$result =   $this->db->get('user');
        print_r($result->result());
	}
    /**
     * Menu part
     */
    public function menu($page){
        $redirect_url = ''.$page."/main";
        if(empty($page)){
            $redirect_url = "user/login";
        }
        redirect($redirect_url);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
