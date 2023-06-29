<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:42 AM
 */
/**
 * Needs related include files
 */

$this->load->helper('url');
$current_theme_url = base_url().THEME_URL.CURRENT_THEME_NAME;

require_once __DIR__."/header.php";
require_once __DIR__."/content.php";
require_once __DIR__."/footer.php";
