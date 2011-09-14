<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=plugins_url('scrapping')?>/js/jquery.mobile.css" type="text/css" />
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.mobile.min.js"></script>
	<title>Scrapping | <?=Scrap::get_meta_title($post->ID)?></title>
</head>
<body>
<div data-role="page">
	<?php $prev_post = get_adjacent_post(true, '', true); ?>
	<?php $next_post = get_adjacent_post(true, '', false); ?>

	<div data-role="header" data-position="inline">
		<a href="<?=home_url( '/' )?>" data-icon="home">ホーム</a>
		<h1><?=Scrap::get_meta_title($post->ID)?></h1>
	</div>

	<div data-role="navbar">
		<ul>
			<li>
			<?php if ( $prev_post ) { ?>
			<a href="<?=get_permalink($prev_post)?>" title="<?=get_the_title($prev_post->ID)?>" data-icon="arrow-l"><?=Scrap::get_short_title($prev_post->ID)?></a>
			<?php } ?>
			</li>
			<li>
			<?php if ( $next_post ) { ?>
			<a href="<?=get_permalink($next_post)?>" title="<?=get_the_title($next_post->ID)?>" data-icon="arrow-r"><?=Scrap::get_short_title($next_post->ID)?></a>
			<?php } ?>
			</li>
		</ul>
	</div><!-- /navbar -->

	<div data-role="content">
		<p style="text-align:center;"><a href="<?=Scrap::get_meta_url($post->ID)?>"><?=Scrap::get_meta_title($post->ID)?></a></p>
		<p style="text-align:center;"><a href="<?=Scrap::get_meta_url($post->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($post->ID))?>" rel="nofollow"><img src="<?=Scrap::get_thumbnail_url($post->ID, 'medium')?>"/></a></p>

		<p><?=Scrap::get_description($post)?></p>
	</div>

	<div data-role="navbar">
		<ul>
			<li>
			<?php if ( $prev_post ) { ?>
			<a href="<?=get_permalink($prev_post)?>" title="<?=get_the_title($prev_post->ID)?>" data-icon="arrow-l"><?=Scrap::get_short_title($prev_post->ID)?></a>
			<?php } ?>
			</li>
			<li>
			<?php if ( $next_post ) { ?>
			<a href="<?=get_permalink($next_post)?>" title="<?=get_the_title($next_post->ID)?>" data-icon="arrow-r"><?=Scrap::get_short_title($next_post->ID)?></a>
			<?php } ?>
			</li>
		</ul>
	</div><!-- /navbar -->

	<?php include(dirname(__FILE__).'/footer.php'); ?>
</div>

<?php include(dirname(__FILE__).'/ga.php'); ?>
</body>
</html>
