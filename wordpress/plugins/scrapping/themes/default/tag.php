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

<div data-role="header">
	<h1>Tag: <?=urldecode(get_query_var('tag'))?></h1>
</div>

<div data-role="content">
<?php $scraps = Scrap::get_scrap_by_tag(urldecode(get_query_var('tag'))); ?>
<?php $blocks = array('a','b','c'); ?>
<?php if ( $scraps ) { ?>
	<?php foreach ($scraps as $scrap) { ?>
		<div class="ui-block-<?=$blocks[$i%3]?>"><div class=" ">
			<a href="<?=get_permalink($scrap->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($scrap->ID))?>"><img src="<?=Scrap::get_thumbnail_url($scrap->ID, 'small')?>"/></a>
		</div></div>
	<?php } ?>
<?php } else { ?>
	<p>スクラップがありません。</p>
<?php } ?>
</div>

<div data-role="footer">
	<h4>&copy; 2011 fukata.org</h4>
</div>

</div>
</body>
</html>
