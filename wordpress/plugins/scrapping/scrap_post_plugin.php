<?php
class ScrapPostPluginManager {
	static $plugins = array();
	static function load_all() {
		self::load('Amazon');
	}

	static function load($plugin) {
		require_once dirname(__FILE__) . '/post_plugins/' . strtolower($plugin) . '.php';
		$class = ucfirst($plugin);
		self::$plugins[strtolower($plugin)] = new $class();
	}

	static function convert_content($post) {
		foreach (self::$plugins as $name => $plugin) {
			if ($plugin->check_scrap_url($post)) {
				return $plugin->convert_content($post);
			}
		}
		return $post->post_content;
	}

	static function has_plugin($post) {
		foreach (self::$plugins as $name => $plugin) {
			if ($plugin->check_scrap_url($post)) {
				return true;
			}
		}
		return false;
	}
}

abstract class ScrapPostPlugin {
	abstract function convert_content($post);

	abstract function check_scrap_url($post);
}
