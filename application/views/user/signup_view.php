<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/10/14
 * Time: 9:44 PM
 */

$data['theme_url'] = base_url().THEME_URL.CURRENT_THEME_NAME;

$this->load->view("user/signup_header.php",$data);
$this->load->view("user/signup_content.php",$data);
$this->load->view("user/signup_footer.php",$data);
