(function($) {
$(function(){
	var toggle = {open:"[+]", close:"[-]"};
	var $menu = $('#down_menu');

	if ($menu.css('display') == 'block') {
		$('.down_menu_toggle_mark').text(toggle.open);
	} else {
		$('.down_menu_toggle_mark').text(toggle.close);
	}

	$('.down_menu_toggle_mark').text(toggle.open);

	$('.down_menu_toggle').click(function(){
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
