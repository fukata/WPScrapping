(function($) {
$(function(){
	var toggle = {open:"[+]", close:"[-]"};
	$('.down_menu_toggle').click(function(){
		var $menu = $('#down_menu');
		if ($menu.css('display') == 'block') {
			$menu.slideUp(300, function() {
				$('.down_menu_toggle_mark').text(toggle.open);
				$menu.css('display', 'none');
			});
		} else {
			$menu.slideDown(300, function() {
				$('.down_menu_toggle_mark').text(toggle.close);
				$menu.css('display', 'block');
			});
		}
	});
});
})(jQuery);
