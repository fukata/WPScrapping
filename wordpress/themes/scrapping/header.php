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
</head>

<body>

<div id="header" class="clearfix">
	<h1 id="logo"><a href="<?=home_url( '/' )?>"><?=bloginfo('name')?></a></h1>
	<div id="header_navi">
		<span class="navi_item"><a href="<?=home_url('/profile')?>">なかの人</a></span> |
		<span class="navi_item"><a href="<?php bloginfo('rss_url'); ?>">RSS</a></span>
	</div>
</div>

<div id="main">
<div id="content">
