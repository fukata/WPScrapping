<?php get_header(); ?>

<?php
	the_post();
	if ( in_category('scrap') ) {
		include(dirname(__FILE__).'/single-scrap.php');
	} else {
		include(dirname(__FILE__).'/single-default.php');
	}
?>

<?php get_footer(); ?>
