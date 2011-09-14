<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=plugins_url('scrapping')?>/js/jquery.mobile.css" type="text/css" />
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.mobile.min.js"></script>
	<title>Scrapping | Tag: <?=urldecode(get_query_var('tag'))?></title>
</head>
<body>
<div data-role="page">
	<div data-role="header" data-position="inline">
		<a href="<?=home_url( '/' )?>" data-icon="home">ホーム</a>
		<h1>Tag: <?=urldecode(get_query_var('tag'))?></h1>
	</div>

	<div data-role="content">
	<?php $scraps = Scrap::get_scrap_by_tag(urldecode(get_query_var('tag'))); ?>
	<?php if ( $scraps ) { ?>
		<div style="text-align:center;">
		<?php foreach ($scraps as $scrap) { ?>
			<p><a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><?=Scrap::get_short_title($scrap->ID)?></a></p>
			<p>	<a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'medium')?>"/></a></p>
		<?php } ?>
		</div>
	<?php } else { ?>
		<p>スクラップがありません。</p>
	<?php } ?>
	</div>

	<?php include(dirname(__FILE__).'/footer.php'); ?>
</div>
</body>
</html>
