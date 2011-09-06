<?php
require_once(dirname(__FILE__).'/../check_settings.php');

$params = sc_get_params();
$errors = sc_invalid_params($params);
if ( ! empty($errors) ) {
	sc_display_error($errors);
}

$errors = sc_register_scrapping($params);
if ( ! empty($errors) ) {
	sc_display_error($errors);
}

sc_display_success();

function sc_get_params() {
	$params = array();

	$params['url'] = trim($_POST['url']);
	$params['title'] = trim($_POST['title']);
	$params['description'] = trim($_POST['description']);
	$params['tags'] = trim($_POST['tags']);

	return $params;
}

function sc_invalid_params($params) {
	$errors = array();

	// url
	$url = $params['url'];
	if ( strlen($url) == 0 ) {
		$errors[] = "Required URL.";
	} else if ( ! preg_match('/^(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url) ) {
		$errors[] = "Invalid URL is Regex.";
	} else if ( sc_already_post_by_url($url) ) {
		$errors[] = "Already registered post.";
	}

	// title
	$title = $params['title'];
	if ( strlen($title) == 0 ) {
		$errors[] = "Required Title.";
	}
	
	// description
	$description = $params['description'];
	if ( strlen($description) == 0 ) {
		$errors[] = "Required Description.";
	}

	return $errors;
}

function sc_already_post_by_url($url) {
	global $wpdb;
	return $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'sc_scrapping_url' AND meta_value = '%s'", $url) );
}

function sc_register_scrapping($params) {
	$post_id = wp_insert_post(array(
		'post_status' => 'publish',
		'post_content' => sc_post_content($params),
		'post_title' => $params['title'],
		'post_category' => sc_post_category($params),
	));

	if ( !$post_id ) {
		return array(
			'Failed register post.'
		);
	}

	// update postmeta
	update_post_meta($post_id, 'sc_scrapping_url', $params['url']);
}

function sc_post_content($params) {
	$content = "<p>{$params['description']}</p>\n";
	$content .= "<p><a href=\"{$params['url']}\">{$params['title']}</a></p>";
	return $content;
}

function sc_post_category($params) {
	return '';
}

function sc_display_error($errors) {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json");
	echo json_encode(array(
		'status' => 0,
		'errors' => $errors
	));
	exit();
}

function sc_display_success() {
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json");
	echo json_encode(array(
		'status' => 1
	));
	exit();
}
