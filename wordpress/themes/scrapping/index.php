<?php get_header(); ?>

<h2>人気タグ</h2>
<?php $popular_tags = Scrap::get_popular_tags(); ?>
<?php if ( $popular_tags ) { ?>
	<div id="popular_tags">
		<?php foreach ($popular_tags as $tag) { ?>
			<span class="tag"><a href="<?=get_term_link($tag->tag,'post_tag')?>" rel="tag"><?=htmlspecialchars($tag->tag)?></a></span>
		<?php } ?>
	</div>
<?php } ?>


<h2>人気スクラップ</h2>
<?php $popular_scraps = Scrap::get_popular_scraps(); ?>
<?php if ( $popular_scraps ) { ?>
	<div id="popular_scraps">
		<?php foreach ($popular_scraps as $scrap) { ?>
			<div class="scrap">
				<div class="capture"><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'large')?>" class="medium_capture"/></a>
					<div class="description">
						<p class="title"><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><?=Scrap::get_meta_title($scrap->ID)?>【View:<?=$scrap->view_count?>】</a></p>
						<p><?=$scrap->post_content?></p>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>

<br clear="all"/>

<h2>最新スクラップ</h2>
<?php $latest_scraps = get_posts('numberposts=15&category=scrap'); ?>
<?php if ( $latest_scraps ) { ?>
	<div id="latest_scraps">
	<?php foreach ($latest_scraps as $scrap) { ?>
		<div class="scrap">
			<div class="capture"><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'large')?>" class="medium_capture"/></a>
				<div class="description">
					<p class="title"><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><?=Scrap::get_meta_title($scrap->ID)?></a></p>
					<p><?=$scrap->post_content?></p>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>

<?php } ?>

<?php get_footer(); ?>