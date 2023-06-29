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
    $data['theme_url'] = base_url().THEME_URL.CURRENT_THEME_NAME;

    $this->load->view("user/login_header.php",$data);
    $this->load->view("user/login_content.php",$data);
    $this->load->view("user/login_footer.php",$data);
