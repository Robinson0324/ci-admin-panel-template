<?php
/*
Plugin Name: Web Scraper Shortcode
Plugin URI: http://MyWebsiteAdvisor.com
Description: Web Scraper Shortcode
Version: 1.0.1
Author: MyWebsiteAdvisor
Author URI: http://MyWebsiteAdvisor.com
*/

/*
Web Scraper Shortcode (Wordpress Plugin)
Copyright (C) 2011 MyWebsiteAdvisor
Contact me at http://MyWebsiteAdvisor.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/


//tell wordpress to register the shortcode
//add_shortcode("web-scraper", "web_scraper_shortcode");


function web_scraper_shortcode($atts, $content = null){

	$url = $atts['url'];
	$element = $atts['element'];
  	$limit = $atts['limit'];
  
  	if($limit < 1){$limit = 100;}

        if(!class_exists('simple_html_dom')){
          require_once('simple_html_dom.php');
        }
  
	$html = file_get_html($url);
		
    $output = "";
  	$i = 0;
  
  
        foreach( $html->find($element) as $item){
          	if($i < $limit){
	        	$output .= $item->innertext;
                print_r($item->src);
        	}
          	$i++;
        }
                                      
	return $output;

}
// [web-scraper url="https://www.freelancer.com/job/" element="#jobCat1 a" limit=""]
$params = array(
    'url' => "http://www.amazon.co.jp/dp/4798607827",
    'element' => "#imgBlkFront",
    'limit' => ""
);
$result = web_scraper_shortcode($params);
print_r($result);

$params = array(
    'url' => "http://www.amazon.co.jp/dp/4798607827",
    'element' => "#productTitle",
    'limit' => ""
);
$result = web_scraper_shortcode($params);
print_r($result);

$params = array(
    'url' => "http://www.amazon.co.jp/dp/4798607827",
    'element' => "#title",
    'limit' => ""
);
$result = web_scraper_shortcode($params);
print_r($result);



?>