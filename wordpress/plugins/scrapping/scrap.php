<?php

class Scrap {

	const META_URL = 'sc_url';
	const META_TITLE = 'sc_title';

	private function __constcurt() {
	}

	public static function conv_content($content) {
		global $post;

		$cats = wp_get_post_categories($post->ID);
		if ( count($cats) == 0 ) {
			return $content;
		}

		$scrap_cats = self::scrap_cats();
		foreach ($cats as $cat) {
			if ( ! in_array($cat, $scrap_cats) ) {
				return $content;
			}
		}

		$url = self::get_meta_url($post->ID);
		$title = self::get_meta_title($post->ID);

		return "<a href=\"$url\" target=\"_blank\"><img src=\"" . self::get_thumbnail_url($post->ID) . "\"/></a>\n$content\n<p><a href=\"$url\">$title</a></p>";
	}

	public static function scrap_cats() {
		return array('5');
	}

	public static function get_meta_url($post_id) {
		return get_post_meta($post_id, self::META_URL, true);
	}

	public static function get_meta_title($post_id) {
		return get_post_meta($post_id, self::META_TITLE, true);
	}

	public static function get_thumbnail_url($post_id, $size='medium') {
		$url = self::get_meta_url($post_id);
		//return plugins_url('scrapping') . "/thumbnail.php?url=" . urlencode($url) . "&size=$size";
		return "http://capture.heartrails.com/$size?$url";
	}
}
