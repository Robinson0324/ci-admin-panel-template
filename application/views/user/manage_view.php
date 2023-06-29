<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/11/14
 * Time: 1:44 AM
 */

//URL DEFINE
$this->load->helper('url');
$current_theme_url = base_url().THEME_URL.CURRENT_THEME_NAME;
$menu_url = base_url()."index.php/index/menu";

//header
require_once FCPATH."/ui/pages/usermanage/header.php";
//menu & sidebar
require_once FCPATH."/ui/pages/menu.php";
//content
require_once FCPATH."/ui/pages/usermanage/index.php";
//footer
require_once FCPATH."/ui/pages/footer.php";
require_once FCPATH."/ui/pages/usermanage/footer.php";