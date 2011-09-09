<?php

class Scrap {

	const CAT_INFO = 56;
	const CAT_SCRAP = 5;

	const META_URL = 'sc_url';
	const META_TITLE = 'sc_title';
	const META_VIEW_COUNT = 'sc_view_count';

	const COOKIE_NAME = 'sc';

	private function __constcurt() {
	}

	public static function conv_content($content) {
		global $post;

		if ( ! self::is_scrap($post->ID) ) {
			return $content;
		}

		$url = self::get_meta_url($post->ID);
		$title = self::get_meta_title($post->ID);

		return "<a href=\"$url\" target=\"_blank\"><img src=\"" . self::get_thumbnail_url($post->ID) . "\"/></a>\n$content\n<p><a href=\"$url\">$title</a></p>";
	}

	public static function is_scrap($post_id) {
		$cats = wp_get_post_categories($post_id);
		if ( count($cats) == 0 ) return false;

		$scrap_cats = self::scrap_cats();
		foreach ($cats as $cat) {
			if ( ! in_array($cat, $scrap_cats) ) {
				return false;
			}
		}

		return true;
	}

	public static function scrap_cats() {
		return array(self::CAT_SCRAP);
	}

	public static function get_meta_url($post_id) {
		return get_post_meta($post_id, self::META_URL, true);
	}

	public static function get_meta_title($post_id, $len=0, $append='...') {
		$title = get_post_meta($post_id, self::META_TITLE, true);
		if ( $len > 0 && mb_strlen($title) > $len ) {
			$title = mb_substr($title, 0, $len) . $append;
		}
		return $title;
	}

	public static function get_short_title($post_id, $len=30, $append='...') {
		return self::get_meta_title($post_id, $len, $append);
	}
	
	public static function get_meta_view_count($post_id) {
		return get_post_meta($post_id, self::META_VIEW_COUNT, true);
	}

	public static function get_thumbnail_url($post_id, $size='medium') {
		$url = self::get_meta_url($post_id);
		//return plugins_url('scrapping') . "/thumbnail.php?url=" . urlencode($url) . "&size=$size";
		return "http://capture.heartrails.com/$size?$url";
	}

	public static function is_logged_view_post($post_id) {
		$cookie = self::logged_cookie();
		return isset($cookie["view_post-{$post_id}"]) && $cookie["view_post-{$post_id}"];
	}

	public static function is_logged_search_tag($tag) {
		$cookie = self::logged_cookie();
		return isset($cookie["search-{$tag}"]) && $cookie["search-{$tag}"];
	}

	public static function logged_cookie() {
		$cookie = isset($_COOKIE[self::COOKIE_NAME]) ? unserialize($_COOKIE[self::COOKIE_NAME]) : array();
		return $cookie;
	}

	public static function countup($wp_query) {
		global $post, $current_site;
		if ( is_user_logged_in() ) return;

		if ( is_single() ) {
			// count up for post
			if ( ! self::is_scrap($post->ID) ) return;
			// already read
			//if ( self::is_logged_view_post($post->ID) ) return;

			// expire a day.
/*
			$timeout = time() + 86400;
			$cookie = self::logged_cookie();
			$cookie["view_post-{$post->ID}"] = 1;
			setcookie(self::COOKIE_NAME, serialize($cookie), $timeout, SITECOOKIEPATH);
*/
			$count = get_post_meta($post->ID, self::META_VIEW_COUNT, true);
			if ( ! $count ) $count = 0;
			update_post_meta($post->ID, self::META_VIEW_COUNT, ++$count);

			// tags
			$tags = get_the_terms($post->ID, 'post_tag');
			foreach ($tags as $tag) {
				self::logging_tag_view($tag->name, 'post_view', $post->ID);
			}
		} else if ( is_tag() ) {
			$tag = urldecode(get_query_var('tag'));
			//if ( self::is_logged_search_tag($tag) ) return;

			self::logging_tag_view($tag, 'search');
/*
			$timeout = time() + 86400;
			$cookie = self::logged_cookie();
			$cookie["search-$tag"] = 1;
			setcookie(self::COOKIE_NAME, serialize($cookie), $timeout, SITECOOKIEPATH);
*/
		}
	}

	public static function logging_tag_view($tag, $view_type, $post_id=null) {
		global $wpdb;
		$wpdb->insert('sc_tag_view_logs', array(
			'tag' => $tag,
			'view_type' => $view_type,
			'post_id' => $post_id,
			'logged_at' => date("Y-m-d H:i:s")
		));
	}

	public static function get_popular_scraps($limit=10) {
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare("SELECT p.*, m.meta_value AS view_count FROM $wpdb->posts AS p INNER JOIN $wpdb->postmeta AS m ON (m.post_id = p.id AND p.post_status='publish') WHERE m.meta_key='%s' ORDER BY m.meta_value DESC, p.post_date DESC LIMIT %d", Scrap::META_VIEW_COUNT, $limit) );
	}

	public static function get_popular_tags($limit=10) {
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare("SELECT r.* FROM sc_tag_rankings AS r WHERE r.status = 'open' ORDER BY r.score DESC LIMIT %d", $limit) );
	}

	public static function get_scrap_by_tag($tag='',$limit=10) {
		global $wpdb;
		if (!trim($tag)) return array();

		return $wpdb->get_results( $wpdb->prepare("SELECT p.* FROM $wpdb->posts AS p INNER JOIN $wpdb->term_relationships AS tr ON (tr.object_id = p.id) INNER JOIN $wpdb->term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) INNER JOIN wp_terms AS t ON (t.term_id = tt.term_id) WHERE  p.post_status = 'publish' AND t.name = '%s' AND tt.taxonomy = 'post_tag' ORDER BY p.post_date DESC LIMIT %d", $tag, $limit) );
	}

	public static function get_short_description($post, $len=50, $append='...') {
		$content = $post->post_content;
		if ( strlen($content) == 0 ) return '';

		$content = str_replace(array("\r\n","\r","\n"), '', $content);
		if ( $len > 0 && mb_strlen($content) > $len ) {
			$content = mb_substr($content, 0, $len) . $append;
		}
		return $content;
	}

	public static function get_description($post) {
		$content = $post->post_content;
		if ( strlen($content)==0 ) return '';
	
		$content = nl2br($content);
		return $content;
	}

	public static function recent_scraps($limit=10) {
		return get_posts("numberposts=$limit&category=".self::CAT_SCRAP);
	}

	public static function recent_information($limit=10) {
		return get_posts("numberposts=$limit&category=".self::CAT_INFO);
	}
}
