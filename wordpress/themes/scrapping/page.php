<?php get_header(); ?>

<?php the_post(); ?>

<?php if ( file_exists(dirname(__FILE__).'/page-'.$post->slug.'.php') ) { ?>
	<?php include(dirname(__FILE__).'/page-'.$post->slug.'.php'); ?>
<?php } else { ?>
	<?php include(dirname(__FILE__).'/page-default.php'); ?>
<?php } ?>

<?php get_footer(); ?>
