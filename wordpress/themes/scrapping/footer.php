<br clear="all"/>

</div> <!-- content -->

</div> <!-- main -->

<div id="footer">
	<div id="footer_menu">
		<h4>HTML5的な何か</h4>
		<ul>
			<li><a href="<?=home_url('/scrap-cube')?>">Scrap Cube</a></li>
		</ul>
	</div>
	<p>Copyright (C) 2011 <a href="http://fukata.org">fukata.org</a> All Rights Reserved.</p>
</div>

<!-- Place this tag in your head or just before your close body tag -->
<script type="text/javascript" src="http://apis.google.com/js/plusone.js">
  {lang: 'ja'}
</script>

<?php if (!is_user_logged_in()) { ?>

<?php // google tracking code ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19570640-11']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php } ?>

<?php
    /* Always have wp_footer() just before the closing </body>
     * tag of your theme, or you will break many plugins, which
     * generally use this hook to reference JavaScript files.
     */

    wp_footer();
?>
</body>
</html>

