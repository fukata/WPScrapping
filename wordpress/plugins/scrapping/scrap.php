<?php

class Scrap {

	const META_URL = 'sc_url';
	const META_TITLE = 'sc_title';
	const META_VIEW_COUNT = 'sc_view_count';

	const COOKIE_NAME = 'sc';

	const BOTS = '/(zenback bot|Googlebot|Birubot|Twitterbot|UnwindFetchor|JS-Kit|PaperLiBot)/';

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
		$categories = self::option_cat_scrap();
		if (empty($categories)) {
			return array();
		} else {
			return explode(',', $categories);
		}
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
		if ( is_user_logged_in() || !self::can_countup() ) return;

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

	public static function can_countup() {
		$ua = $_SERVER['HTTP_USER_AGENT'];

		if ( preg_match(self::BOTS, $ua) ) {
			return false;
		}

		return true;
	}

	public static function logging_tag_view($tag, $view_type, $post_id=null) {
		global $wpdb;
		$wpdb->insert('sc_tag_view_logs', array(
			'tag' => $tag,
			'view_type' => $view_type,
			'post_id' => $post_id,
			'ua' => $_SERVER['HTTP_USER_AGENT'],
			'referrer' => $_SERVER['HTTP_REFERER'],
			'ip' => $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'],
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

	public static function get_hot_tags($limit=3) {
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare("SELECT r.* FROM sc_tag_rankings AS r WHERE r.status = 'open' ORDER BY RAND() LIMIT %d", $limit) );
	}

	public static function get_scrap_by_tag($tag='',$limit=10) {
		global $wpdb;
		if (!trim($tag)) return array();

		return $wpdb->get_results( $wpdb->prepare("SELECT p.* FROM $wpdb->posts AS p INNER JOIN $wpdb->term_relationships AS tr ON (tr.object_id = p.id) INNER JOIN $wpdb->term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) INNER JOIN $wpdb->terms AS t ON (t.term_id = tt.term_id) WHERE  p.post_status = 'publish' AND (t.name = '%s' OR t.slug = '%s') AND tt.taxonomy = 'post_tag' ORDER BY p.post_date DESC LIMIT %d", $tag, $tag, $limit) );
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
		return get_posts("numberposts=$limit&category=" . self::option_cat_scrap());
	}

	public static function random_scraps($limit=10) {
		return get_posts("numberposts=$limit&orderby=rand&category=" . self::option_cat_scrap());
	}

	public static function recent_information($limit=10) {
		return get_posts("numberposts=$limit&category=" . self::option_cat_info());
	}

	public static function ogp_head() {
		global $post;
		if ( self::is_scrap($post->ID) ) {
			echo "<!-- BEGIN: OGP by Scrapping -->\n";
			echo '<meta property="og:title" content="'.get_bloginfo('name').' | '.self::get_meta_title($post->ID).'" />'."\n";
			echo '<meta property="og:type" content="article" />'."\n";
			echo '<meta property="og:image" content="'.self::get_thumbnail_url($post->ID, 'medium').'" />'."\n";
			echo '<meta property="image_src" content="'.self::get_thumbnail_url($post->ID, 'medium').'" />'."\n";
			echo '<meta property="og:url" content="'.get_permalink($post->ID).'" />'."\n";
			echo '<meta property="og:site_name" content="'.get_bloginfo('name').'" />'."\n";
			echo '<meta property="og:description" content="'.self::get_short_description($post, 100).'" />'."\n";
			echo "<!-- END: OGP by Scrapping -->\n";
		}
	}

	public static function option_key($key) {
		return "sc_$key";
	}

	public static function option($key) {
		return get_option(self::option_key($key), '');
	}

	public static function option_cat_scrap() {
		return self::option('cat_scrap');
	}

	public static function option_cat_info() {
		return self::option('cat_info');
	}

	public static function option_amazon_tracking_id() {
		return self::option('amazon_tracking_id');
	}

	public static function admin_menu() {
		add_options_page('Scrapping Options', 'Scrapping', 8, __FILE__, array(Scrap, 'admin_option_form'));
	}

	public static function admin_register_settings() {
		register_setting('scrapping', self::option_key('cat_scrap'));
		register_setting('scrapping', self::option_key('cat_info'));
		register_setting('scrapping', self::option_key('amazon_tracking_id'));
	}

	public static function admin_option_form() {
?>
<div class="wrap">
	<h2>Scrapping</h2>
	<form method="post" action="options.php">
		<?php settings_fields('scrapping'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<p><?php echo __('Scrap Categories'); ?></p>
				</th>
				<td>
					<p><input type="text" name="<?php echo Scrap::option_key('cat_scrap'); ?>" value="<?php echo Scrap::option_cat_scrap(); ?>" size="50"/></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<p><?php echo __('Information Category'); ?></p>
				</th>
				<td>
					<p><input type="text" name="<?php echo Scrap::option_key('cat_info'); ?>" value="<?php echo Scrap::option_cat_info(); ?>" size="50"/></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<p><?php echo __('Amazon Tracking ID'); ?></p>
				</th>
				<td>
					<p><input type="text" name="<?php echo Scrap::option_key('amazon_tracking_id'); ?>" value="<?php echo Scrap::option_amazon_tracking_id(); ?>" size="50"/></p>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php echo __('Save Changes'); ?>" />
		</p>
	</form>
</div>
<?php	
	}
}
