<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 4:45 PM
 */

class page_model extends CI_Model {


    function __construct()
    {
        parent::__construct();
    }

    function get_header($data = array()){
        require_once FCPATH."/ui/pages/header.php";
    }

    function get_footer($data = array()){
        require_once FCPATH."/ui/pages/footer.php";
    }

    function get_content($data = array()){
        require_once FCPATH."/ui/pages/content.php";
    }

    function get_menu($data = array()){
        require_once FCPATH."/ui/pages/menu.php";
    }

    function get_sidebar($data = '',$location = 'left'){
        require_once FCPATH."/ui/pages/sidebar.php";
    }

    function load_page_template($data = array()){
        // load view content
        $this->get_header($data);
        $this->get_menu($data);
        //$this->get_sidebar($data);
        $this->get_content($data);
        $this->get_footer($data);
    }
}
?>