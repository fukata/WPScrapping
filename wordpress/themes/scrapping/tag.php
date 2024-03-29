<?php get_header(); ?>

<h2>Tag: <?=urldecode(get_query_var('tag'))?></h2>

<?php $scraps = Scrap::get_scrap_by_tag(urldecode(get_query_var('tag'))); ?>
<?php if ( $scraps ) { ?>
	<div id="search_scraps">
		<?php foreach ($scraps as $scrap) { ?>
			<div class="scrap">
				<div class="capture"><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'large')?>" class="medium_capture"/></a>
					<div class="description">
						<p class="title"><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><?=Scrap::get_meta_title($scrap->ID)?>【View:<?=$scrap->view_count?>】</a></p>
						<p><?=Scrap::get_short_description($scrap)?></p>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>

<?php get_footer(); ?>
