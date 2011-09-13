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

	<div data-role="header">
		<h1><?=Scrap::get_meta_title($post->ID)?></h1>
	</div>

	<div data-role="content">
		<p style="text-align:center;"><a href="<?=Scrap::get_meta_url($post->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($post->ID))?>" rel="nofollow"><img src="<?=Scrap::get_thumbnail_url($post->ID, 'medium')?>"/></a></p>

		<p><?=Scrap::get_description($post)?></p>
	</div>

	<?php include(dirname(__FILE__).'/footer.php'); ?>
</div>
</body>
</html>
