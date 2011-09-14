<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=plugins_url('scrapping')?>/js/jquery.mobile.css" type="text/css" />
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.mobile.min.js"></script>
	<title>Scrapping.</title>
</head>
<body>
<div data-role="page" id="top">

	<div data-role="header">
		<h1>Scrapping</h1>
	</div>

	<div data-role="content">
		<?php $latest_scraps = Scrap::recent_scraps(1); ?>
		<?php if ($latest_scraps) { $scrap = $latest_scraps[0]; ?>
		<div style="text-align:center;">
			<p><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><?=Scrap::get_short_title($post->ID)?></a></p>
			<p><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'medium')?>"/></a></p>
		</div>
		<?php } ?>

		<p></p>
		<ul data-role="listview">
			<li><a href="#popular_tags">人気タグ</a></li>
			<li><a href="#popular_scraps">人気スクラップ</a></li>
			<li><a href="#latest_scraps">最新スクラップ</a></li>
		</ul>
	</div>

	<?php include(dirname(__FILE__).'/footer.php'); ?>
</div>

<div data-role="page" id="popular_tags">

	<div data-role="header" data-position="inline">
		<a href="#top" data-icon="home">ホーム</a>
		<h1>人気タグ</h1>
	</div>

	<div data-role="content">
		<?php $popular_tags = Scrap::get_popular_tags(50); ?>
		<?php if ( $popular_tags ) { ?>
		<ul data-role="listview" data-theme="a">
		<?php foreach ($popular_tags as $tag) { ?>
			<li><a href="<?=get_term_link($tag->tag,'post_tag')?>" rel="tag"><?=htmlspecialchars($tag->tag)?></a></li>
		<?php } ?>
		</ul>
		<?php } ?>

		<p></p>
		<ul data-role="listview">
			<li><a href="#popular_tags">人気タグ</a></li>
			<li><a href="#popular_scraps">人気スクラップ</a></li>
			<li><a href="#latest_scraps">最新スクラップ</a></li>
		</ul>
	</div>

	<?php include(dirname(__FILE__).'/footer.php'); ?>
</div>

<div data-role="page" id="popular_scraps">

	<div data-role="header" data-position="inline">
		<a href="#top" data-icon="home">ホーム</a>
		<h1>人気スクラップ</h1>
	</div>

	<div data-role="content">
	<?php $popular_scraps = Scrap::get_popular_scraps(10); ?>
	<?php if ( $popular_scraps ) { ?>
		<div style="text-align:center;">
		<?php for ($i=0; $i<count($popular_scraps); $i++) { $scrap=$popular_scraps[$i];?>
			<p><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><?=Scrap::get_short_title($scrap->ID)?></a></p>
			<p><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'medium')?>"/></a></p>
		<?php } ?>
		</div>
	<?php } else { ?>
		<p>スクラップがありません。</p>
	<?php } ?>

		<p></p>
		<ul data-role="listview">
			<li><a href="#popular_tags">人気タグ</a></li>
			<li><a href="#popular_scraps">人気スクラップ</a></li>
			<li><a href="#latest_scraps">最新スクラップ</a></li>
		</ul>
	</div>

	<?php include(dirname(__FILE__).'/footer.php'); ?>
</div>

<div data-role="page" id="latest_scraps">

	<div data-role="header" data-position="inline">
		<a href="#top" data-icon="home">ホーム</a>
		<h1>最新スクラップ</h1>
	</div>

	<div data-role="content">
	<?php $latest_scraps = Scrap::recent_scraps(10); ?>
	<?php if ( $latest_scraps ) { ?>
		<div style="text-align:center;">
		<?php for ($i=0; $i<count($latest_scraps); $i++) { $scrap=$latest_scraps[$i];?>
			<p><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><?=Scrap::get_short_title($scrap->ID)?></a></p>
			<p><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'medium')?>"/></a></p>
		<?php } ?>
		</div>
	<?php } else { ?>
		<p>スクラップがありません。</p>
	<?php } ?>

		<p></p>
		<ul data-role="listview">
			<li><a href="#popular_tags">人気タグ</a></li>
			<li><a href="#popular_scraps">人気スクラップ</a></li>
			<li><a href="#latest_scraps">最新スクラップ</a></li>
		</ul>
	</div>
	<?php include(dirname(__FILE__).'/footer.php'); ?>
</div>

</body>
</html>
