<?php get_header(); ?>

<?php the_post(); ?>
<h2><?php the_title(); ?></h2>
<div id="page_content">
	<?php the_content(); ?>
</div>

<?php get_footer(); ?>
