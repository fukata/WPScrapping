<?php
class Amazon extends ScrapPostPlugin {
	// http://www.amazon.co.jp/gp/product/B000E7S3BC/ref=s9_simh_gw_p23_d0_g23_i2?pf_rd_m=AN1VRQENFRJN5&pf_rd_s=center-2&pf_rd_r=1AHWR5KJ0M3FPBN0TK07&pf_rd_t=101&pf_rd_p=463376756&pf_rd_i=489986
	const CHECK_URL_RE = '/^(?:https?)\:\/\/www\.amazon\.co\.jp\/gp\/product\/([a-zA-Z0-9]+)\/.*$/';
 
	function convert_content($post) {
		preg_match(self::CHECK_URL_RE, Scrap::get_meta_url($post->ID), $matches);
		$tracking_id = Scrap::option_amazon_tracking_id();
		$asins = $matches[1];
		$frame = <<<EOS
<iframe src="http://rcm-jp.amazon.co.jp/e/cm?lt1=_blank&bc1=CCCCCC&IS2=1&bg1=FFFFFF&fc1=000000&lc1=0000FF&t=$tracking_id&o=9&p=8&l=as4&m=amazon&f=ifr&ref=ss_til&asins=$asins" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
EOS;
		return $frame;
	}

	function check_scrap_url($post) {
		return preg_match(self::CHECK_URL_RE, Scrap::get_meta_url($post->ID));
	}
}
