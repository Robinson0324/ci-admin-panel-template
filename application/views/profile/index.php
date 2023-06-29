<?php
/**
 * We can use global deliveried data as below
 *
 * $data['parent_data'] = array('data' => array());
 * ...
 * output:
 * Array ( [data] => Array ( ) )
 *
 * echo FCPATH; //  server root path
 * echo BASEPATH;   //
 * echo APPPATH;
 *
 * For use these site_url() and base_url(),please include below code
 * $this->load->helper('url');
 */
//URL DEFINE
$this->load->helper('url');
$current_theme_url = base_url().THEME_URL.CURRENT_THEME_NAME;
$menu_url = base_url()."index.php/index/menu";
//GLOBAL VARS
$brand = 'AmazonMaster';

//header
require_once FCPATH."/ui/template/components/profile/header.php";
//menu & sidebar
require_once FCPATH."/ui/template/components/menu.php";
//content
require_once FCPATH."/ui/template/components/profile/index.php";
//footer
require_once FCPATH."/ui/template/components/footer.php";
require_once FCPATH."/ui/template/components/profile/footer.php";
