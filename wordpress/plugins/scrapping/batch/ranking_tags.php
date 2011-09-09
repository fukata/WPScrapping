<?php
require_once(dirname(__FILE__).'/config.php');

//$BLOG_ID = $argv[1];

$DB = mysql_pconnect(DB_HOST, DB_USER, DB_PASSWORD);
if ( ! $DB ) {
	die("Can't not connect database.");
}

if ( ! mysql_select_db(DB_NAME, $DB) ) {
	die("Can't not select database.");
}

mysql_query("SET NAMES UTF8");

mysql_query("BEGIN");

$rankings = sc_publish_rankings();
sc_range_calculate($rankings);

sc_ranking_update($rankings);

mysql_query("COMMIT");
mysql_close($DB);

// ==============================================
// functions
// ==============================================
function sc_option() {
//	global $table_prefix, $BLOG_ID;
	return (Object) array(
//		'table_prefix' => "{$table_prefix}{$BLOG_ID}",
		'range' => false
	);
}

function sc_publish_rankings() {
	$option = sc_option();
	if ( ! $option->range ) return array();

	$sql = "SELECT r.* FROM sc_tag_rankings AS r WHERE r.status = 'publish';";
	$rs = mysql_query($sql);
	$rankings = array();
	while ( $r = mysql_fetch_object($rs) ) {
		$rankings[$r->tag] = $r;
	}
	return $rankings;
}

function sc_range_calculate(&$rankings) {
	$option = sc_option();
	$sql = "SELECT l.* FROM sc_tag_view_logs AS l;";
	$rs = mysql_query($sql);
	while ( $r = mysql_fetch_object($rs) ) {
		if ( !isset($rankings[$r->tag]) ) {
			$rankings[$r->tag] = new stdClass();
			$rankings[$r->tag] = $r;
			$rankings[$r->tag]->score = 0;
		}

		$rankings[$r->tag]->score += sc_score($r);
	}
	return $rankings;
}

function sc_score($log) {
	$score = 0;

	if ( $log->view_type == 'post_view' ) {
		$score = 1;
	} else if ( $log->view_type == 'search' ) {
		$score = 2;
	}

	return $score;
}

function sc_sort_rank($rankings) {	
}

function sc_ranking_update(&$rankings) {
	mysql_query("DELETE FROM sc_tag_rankings AS r WHERE r.status = 'prev';");
	mysql_query("UPDATE sc_tag_rankings AS r SET r.status = 'prev' WHERE r.status='open';");
	
	foreach ($rankings as $r) {
		if ( trim($r->tag) == '' ) continue;
		mysql_query(sprintf("INSERT INTO sc_tag_rankings (tag, score, status, rankinged_at, updated_at) VALUES ('%s', %d, '%s', NOW(), NOW());",
			mysql_real_escape_string($r->tag), $r->score, 'open'));
	}
}
