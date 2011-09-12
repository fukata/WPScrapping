<?php
/*
Plugin Name: Scrapping
Plugin URI: http://fukata.org/dev/wp-plugin/scrapping/
Description: Scrapping Site for WordPress.
Version: 0.1.0
Author: Tatsuya Fukata
Author URI: http://fukata.org
*/
require_once(dirname(__FILE__).'/scrap.php');

add_action('parse_query', array(Scrap, 'countup'));
add_action('wp_head', array(Scrap, 'ogp_head'));
add_action('admin_menu', array(Scrap, 'admin_menu'));
add_filter('whitelist_options', array(Scrap, 'admin_whitelist_options'));
?>
