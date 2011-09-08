<?php get_header(); ?>

<div id="content">

<?php $prev_post = get_adjacent_post(true, '', true); ?>
<?php if ( $prev_post ) { ?>
<a href="<?=get_permalink($prev_post)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($prev_post->ID))?>" class="pager"><div id="prev_scrap"><span class="button">&lt;&lt;<span></div></a>
<?php } ?>

<?php $next_post = get_adjacent_post(true, '', false); ?>
<?php if ( $next_post ) { ?>
<a href="<?=get_permalink($next_post)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($next_post->ID))?>" class="pager"><div id="next_scrap"><span class="button">&gt;&gt;</span></div></a>
<?php } ?>

<h1><?=Scrap::get_meta_title($post->ID)?></h1>
<div class="postmeta">
	<span class="view_count">閲覧回数:<?=Scrap::get_meta_view_count($post->ID)?></span>
|
	<?php
		$tags = get_the_tag_list( '', ', ' );
		if ( $tags ) {
	?>
	<span class="tags">
    	<?php printf( __( '<span class="%1$s">タグ:</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags ); ?>
    </span>
    <?php } ?>
</div>

<div class="scrap">
	<a href="<?=Scrap::get_meta_url($post->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($post->ID))?>"><img src="<?=Scrap::get_thumbnail_url($post->ID, 'large')?>" class="large_capture"/></a>
</div>

<p id="description"><?=Scrap::get_description($post)?></p>

<script>(function(d){
  var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
  js = d.createElement('script'); js.id = id; js.async = true;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  d.getElementsByTagName('head')[0].appendChild(js);
}(document));</script>
<div class="fb-comments" data-href="<?=get_permalink($post->ID)?>" data-num-posts="10" data-width="960"></div>

</div> <!-- content -->

<?php get_footer(); ?>
