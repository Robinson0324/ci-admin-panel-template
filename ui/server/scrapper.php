<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 9/29/14
 * Time: 2:40 AM
 */
require_once __DIR__.'/config.php';

function get_asin_detail_from_db($asin){
    $db_host = DB_HOST;
    $db_name = DB_NAME;
    $db_con = new PDO("mysql:host=$db_host;dbname=$db_name", DB_USER, DB_PASSWORD);

    $sth = $db_con->prepare("SELECT compe FROM ".DB_PRODUCT_TABLE." WHERE asin='".$asin."' ORDER BY DATE ASC LIMIT 0 , 1");
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $sth->execute();
    //get result row
    $result = $sth->fetch();
    return $result;
}

function web_scraper_shortcode($atts, $content = null){

    $url = $atts['url'];
    $element = $atts['element'];
    $limit = $atts['limit'];

    if($limit < 1){$limit = 100;}

    if(!class_exists('simple_html_dom')){
        require_once __DIR__.'/simple_html_dom.php';
    }

    $html = file_get_html($url);

    $output = "";
    $i = 0;

    foreach( $html->find($element) as $item){
        if($i < $limit){
            $output .= $item->innertext;
        }
        $i++;
    }

    return $output;

}

function get_html($url){

    if(!class_exists('simple_html_dom')){
        require_once __DIR__.'/simple_html_dom.php';
    }

    $html = file_get_html($url);
    return $html;
}

function get_dom($html,$element){
    $limit = 100;
    $output = "";
    $i = 0;

    foreach( $html->find($element) as $item){
        if($i < $limit){
            $output .= $item->outertext;
        }
        $i++;
    }

    return $output;
}

function get_property($html,$element){
    $limit = 100;
    $output = "";
    $i = 0;

    foreach( $html->find($element) as $item){
        if($i < $limit){
            $output .= $item->innertext;
        }
        $i++;
    }

    return $output;
}

function get_attr($html,$element,$attr){
    $limit = 100;
    $output = "";
    $i = 0;

    foreach( $html->find($element) as $item){
        if($i < $limit){
            $output .= $item->{$attr};
        }
        $i++;
    }

    return $output;
}

function objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    }
    else {
        // Return array
        return $d;
    }
}


$asin = trim($_REQUEST['asin']);
$url = "https://sellercentral.amazon.co.jp/gp/fba/revenue-calculator/data/product-matches.html?model={%22searchString%22:%22".$asin."%22,%22lang%22:%22ja_JP%22,%22marketPlace%22:%22A1VC38T7YXB528%22}";

$html = get_html($url);
$dec = objectToArray(json_decode($html->root->nodes[0]->_[4]));
$item = $dec['data'][0];
//Amazon compe value setting
$info = get_asin_detail_from_db($asin);
$item['amazon_compe'] = $info['compe'];
print_r(json_encode($item));
