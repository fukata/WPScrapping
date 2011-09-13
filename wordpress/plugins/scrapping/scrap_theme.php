<?php

class ScrapTheme {
	var $smartphone;
	static $useragents = array(             
        "iPhone",                   // Apple iPhone
        "iPod",                         // Apple iPod touch
        "incognito",                // Other iPhone browser
        "webmate",              // Other iPhone browser
        "Android",              // 1.5+ Android
        "dream",                    // Pre 1.5 Android
        "CUPCAKE",              // 1.5+ Android
        "blackberry9500",       // Storm
        "blackberry9530",       // Storm
        "blackberry9520",       // Storm v2
        "blackberry9550",       // Storm v2
        "blackberry 9800",  // Torch
        "webOS",                    // Palm Pre Experimental
        "s8000",                    // Samsung Dolphin browser
        "bada",                     // Samsung Dolphin browser
        "Googlebot-Mobile"  // the Google mobile crawler
    ); 

	function __construct() {
		$this->smartphone = false;
		
		if (!is_admin()) {
			add_filter( 'stylesheet', array(&$this, 'get_stylesheet') );
			add_filter( 'theme_root', array(&$this, 'theme_root') );
			add_filter( 'theme_root_uri', array(&$this, 'theme_root_uri') );
			add_filter( 'template', array(&$this, 'get_template') );	
		}

		$this->detect_smartphone();
	}

	function get_stylesheet($stylesheet) {
		if ($this->smartphone) {
			return 'default';
		} else {
			return $stylesheet;
		}
	}
		  
	function get_template($template) {
		if ($this->smartphone) {
			return 'default';
		} else {	   
			return $template;
		}
	}

	function theme_root($path) {
		$theme_root = dirname(__FILE__);
		if ($this->smartphone) {
			return "$theme_root/themes";
		} else {
			return $path;
		}
	}

	function theme_root_uri($url) {
		$theme_url = plugins_url('scrapping');
		if ($this->smartphone) {
			return "$theme_url/themes";
		} else {
			return $url;
		}
	}

	function detect_smartphone() {
		$ua = $_SERVER['HTTP_USER_AGENT'];
        foreach ( self::$useragents as $useragent ) {
			if ( preg_match( "#$useragent#i", $ua ) ) {
				$this->smartphone = true;
				return;
			}
		}
		$this->smartphone = false;
	}
}
