<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?=plugins_url('scrapping')?>/js/jquery.mobile.css" type="text/css" />
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.mobile.min.js"></script>
	<title>Scrapping - Smartphone</title>
</head>
<body>
<div data-role="page">

<div data-role="header">
	<h1>Scrapping</h1>
</div>

<div data-role="collapsible-set">
	<div data-role="collapsible" data-collapsed="true">
		<h3>人気タグ</h3>
<?php $popular_tags = Scrap::get_popular_tags(10); ?>
<?php if ( $popular_tags ) { ?>
	<div id="popular_tags">
		<ul data-role="listview" data-theme="a">
		<?php foreach ($popular_tags as $tag) { ?>
			<li><a href="<?=get_term_link($tag->tag,'post_tag')?>" rel="tag"><?=htmlspecialchars($tag->tag)?></a></li>
		<?php } ?>
		</ul>
	</div>
<?php } ?>

	</div>

	<div data-role="collapsible" data-collapsed="true">
		<h3>人気スクラップ</h3>
<?php $popular_scraps = Scrap::get_popular_scraps(9); ?>
<?php $blocks = array('a','b','c'); ?>
<?php if ( $popular_scraps ) { ?>
	<div id="popular_scraps" class="ui-grid-b">
	<?php for ($i=0; $i<count($popular_scraps); $i++) { $scrap=$popular_scraps[$i];?>
		<div class="ui-block-<?=$blocks[$i%3]?>"><div class=" ui-bar ui-bar-a">
			<a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'small')?>"/></a>
		</div></div>
	<?php } ?>
	</div>
<?php } else { ?>
	<p>スクラップがありません。</p>
<?php } ?>
	</div>

	<div data-role="collapsible" data-collapsed="false">
		<h3>最新スクラップ</h3>
<?php $latest_scraps = Scrap::recent_scraps(9); ?>
<?php $blocks = array('a','b','c'); ?>
<?php if ( $latest_scraps ) { ?>
	<div id="latest_scraps" class="ui-grid-b">
	<?php for ($i=0; $i<count($latest_scraps); $i++) { $scrap=$latest_scraps[$i];?>
		<div class="ui-block-<?=$blocks[$i%3]?>"><div class=" ui-bar ui-bar-a">
			<a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'small')?>"/></a>
		</div></div>
	<?php } ?>
	</div>
<?php } else { ?>
	<p>スクラップがありません。</p>
<?php } ?>
	</div>
</div>

<div data-role="footer">
	<h4>&copy; 2011 fukata.org</h4>
</div>

</div>
</body>
</html>
