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

//add_filter('the_content', array(Scrap, 'conv_content'));
add_action('wp_footer', array(Scrap, 'countup'));
?>
