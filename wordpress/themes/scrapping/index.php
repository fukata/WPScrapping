<?php get_header(); ?>

<h2>人気タグ</h2>
<p>実装中...</p>

<?php $popular_scraps = Scrap::get_popular_scraps() ?>
<?php if ( $popular_scraps ) { ?>
	<div id="popular_scraps">
		<h2>人気スクラップ</h2>
		<?php foreach ($popular_scraps as $scrap) { ?>
			<div class="scrap">
				<div class="capture" data-title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>" data-description="<?=htmlspecialchars($scrap->post_content)?>"><a href="<?=Scrap::get_meta_url($scrap->ID)?>" target="_blank" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'large')?>" class="medium_capture"/></a>
					<div class="description">
						<p class="title"><a href="<?=Scrap::get_meta_url($scrap->ID)?>" target="_blank" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><?=Scrap::get_meta_title($scrap->ID)?>【View:<?=$scrap->view_count?>】</a></p>
						<p><?=$scrap->post_content?></p>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>

<br clear="all"/>

<?php $latest_scraps = get_posts('numberposts=15&category=scrap'); ?>
<?php if ( $latest_scraps ) { ?>

	<div id="latest_scraps">
		<h2>最新スクラップ</h2>
	<?php foreach ($latest_scraps as $scrap) { ?>
		<div class="scrap">
			<div class="capture" data-title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>" data-description="<?=htmlspecialchars($scrap->post_content)?>"><a href="<?=Scrap::get_meta_url($scrap->ID)?>" target="_blank" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'large')?>" class="medium_capture"/></a>
				<div class="description">
					<p class="title"><a href="<?=Scrap::get_meta_url($scrap->ID)?>" target="_blank" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><?=Scrap::get_meta_title($scrap->ID)?></a></p>
					<p><?=$scrap->post_content?></p>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>

<?php } ?>

<?php get_footer(); ?>
