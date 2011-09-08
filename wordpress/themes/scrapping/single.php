<?php get_header(); ?>

<h1><?=Scrap::get_meta_title($post->ID)?></h1>
<div class="postmeta">
	<span class="view_count"><?=Scrap::get_meta_view_count($post->ID)?> views</span>
	<?php
		$tags = get_the_tag_list( '', ', ' );
		if ( $tags ) {
	?>
	<span class="tags">
    	<?php printf( __( '<span class="%1$s">Tag</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags ); ?>
    </span>
    <?php } ?>
</div>

<div class="capture">
	<a href="<?=Scrap::get_meta_url($post->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($post->ID))?>"><img src="<?=Scrap::get_thumbnail_url($post->ID, 'large')?>" class="medium_capture"/></a>
</div>

<p><?=$post->post_content?></p>

<script>(function(d){
  var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
  js = d.createElement('script'); js.id = id; js.async = true;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  d.getElementsByTagName('head')[0].appendChild(js);
}(document));</script>
<div class="fb-comments" data-href="<?=get_permalink($post->ID)?>" data-num-posts="10" data-width="500"></div>

<?php get_footer(); ?>
