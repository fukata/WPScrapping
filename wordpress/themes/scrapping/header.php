<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <title><?php bloginfo('name'); ?><?php if (is_home()) {echo '. '; bloginfo('description');} ?> <?php if ( is_single() )?> <?php wp_title(); ?></title>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
  <!--[if IE]><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" type="text/css" media="screen" /><![endif]-->
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS 2.0 Feed" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="alternate" type="text/xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss_url'); ?>" />
  <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
  <link rel="Shortcut Icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico" type="image/x-icon" />
  <?php wp_enqueue_script('jquery'); ?>
  <?php wp_head(); ?>
  <script type="text/javascript" src="<?=bloginfo('template_url')?>/js/common.js"></script>
</head>

<body>

<div id="header" class="clearfix">
	<h1 id="logo"><a href="<?=home_url( '/' )?>"><?=bloginfo('name')?></a></h1>
	<?php $hot_tags = Scrap::get_hot_tags(); ?>
	<?php if ($hot_tags) { ?>
	<div id="hot_tags">
		<span>注目タグ: </span>
		<ul>
		<?php foreach ($hot_tags as $tag) { ?>
			<li><a href="<?=get_term_link($tag->tag,'post_tag')?>"><?=$tag->tag?></a></li>
		<?php } ?>
		</ul>
	</div>
	<?php } ?>
	<div id="header_navi">
		<span class="navi_item"><a href="javascript:void(0);" class="down_menu_toggle"><span class="down_menu_toggle_mark"></span>メニュー</a></span> |
		<span class="navi_item"><a href="<?=home_url('/profile')?>">なかの人</a></span> |
		<span class="navi_item"><a href="<?php bloginfo('rss_url'); ?>">RSS</a></span>
	</div>
</div>

<div id="down_menu">
	<div id="down_menu_content">
		<h4>HTML5的な何か</h4>
		<ul>
			<li><a href="<?=home_url('/scrap-cube')?>">Scrap Cube</a></li>
		</ul>
	</div>
</div>

<div id="main">
<div id="content">
