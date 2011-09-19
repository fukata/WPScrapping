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
	<span class="posted_on">スクラップ日: <?=get_the_date()?></span>
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

<div class="single_scrap">
	<?php if (ScrapPostPluginManager::has_plugin($post)) { ?>
		<?=ScrapPostPluginManager::convert_content($post)?>
	<?php } else { ?>
		<a href="<?=Scrap::get_meta_url($post->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($post->ID))?>" rel="nofollow"><img src="<?=Scrap::get_thumbnail_url($post->ID, 'large')?>" class="large_capture"/></a>
		<p><a href="<?=Scrap::get_meta_url($post->ID)?>" rel="nofollow"><?=htmlspecialchars(Scrap::get_meta_title($post->ID))?></a></p>
	<?php } ?>
</div>

<div id="description">
	<?=Scrap::get_description($post)?>
</div>

<!-- X:S ZenBackWidget --><script type="text/javascript">document.write(unescape("%3Cscript")+" src='http://widget.zenback.jp/?base_uri=http%3A//s.fukata.org&nsid=95584166460009577%3A%3A99010428838908808&rand="+Math.ceil((new Date()*1)*Math.random())+"' type='text/javascript'"+unescape("%3E%3C/script%3E"));</script><!-- X:E ZenBackWidget -->
