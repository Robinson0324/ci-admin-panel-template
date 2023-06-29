=== Plugin Name ===
Name: Web Scraper Shortcode
Contributors: MyWebsiteAdvisor, ChrisHurst
Tags: Scraper, Shortcode
Requires at least: 2.9
Tested up to: 3.3
Stable tag: 1.0.1


== Description ==
use the [web-scraper] shortcode where you want to display the contents of a a specific section of another web page or site.
the shortcode takes several parameters, url and target.
The url is the url of the page you would like to scrape.
The element is the target element of the content from the remote page you would like.
You could specify the body element if you would like the entire page, or you could specify something like div#div_id_name to get the contents of that specific div.
The limit is the maximum number of entries to display if your element is a class and has returned multiple results, the first n results will be displayed.

Requirements:



To-do:



== Installation ==

1. Upload `web-scraper/` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. use the [web-scraper] shortcode where you want to display the excerpts of the child pages.


== Frequently Asked Questions ==



== Screenshots ==

1. example use of the plugin shortcode.
2. example output of the plugin shortcode.


== Changelog ==

= 1.0 =
* Initial release


= 1.0.1 =
* fixed opening php tag
