<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?=plugins_url('scrapping')?>/js/jquery.mobile.css" type="text/css" />
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/jquery.mobile.min.js"></script>
	<title>Scrapping | <?=Scrap::get_meta_title($post->ID)?></title>
</head>
<body>

<div data-role="header">
	<h1><?=Scrap::get_meta_title($post->ID)?></h1>
</div>

<div data-role="content">
	<a href="<?=Scrap::get_meta_url($post->ID)?>" title="<?=htmlspecialchars(Scrap::get_meta_title($post->ID))?>" rel="nofollow"><img src="<?=Scrap::get_thumbnail_url($post->ID, 'large')?>"/></a>

	<p><?=Scrap::get_description($post)?></p>

<div id="fb-root"></div>
<script>(function(d){
  var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
  js = d.createElement('script'); js.id = id; js.async = true;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  d.getElementsByTagName('head')[0].appendChild(js);
}(document));</script>
<div class="fb-comments" data-href="wp3.org" data-num-posts="10"></div>
</div>

<div data-role="footer">
	<h4>&copy; 2011 fukata.org</h4>
</div>

</body>
</html>
