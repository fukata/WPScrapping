$(function(){
	var localStorage;

	$('#save').click(function(){
		var post = {
			title: $('#title').val(),
			url: $('#url').val(),
			tags: $('#tags').val(),
			description: $('#description').val(),
			status: $('#status').val()
		};

		chrome.extension.getBackgroundPage().save_cache(post.url, post, function(_post) {
			$('#console').text('Saved!!');
			//setTimeout(function(){ window.close(); }, 1000);
		});
	});

	$('#register').click(function(){
		if (typeof localStorage['blog_url'] === 'undefined' || localStorage['blog_url'] == '') {
			$('#errors').html("Your need setting Blog URL.<br/>");
			return;
		}
		$('#register').attr('disabled', true).val('Registering...');

		var blog_url = localStorage['blog_url'] + '/wp-content/plugins/scrapping/api/register.php';
		var categories = [];
		if (typeof localStorage['categories'] !== 'undefined') {
			categories = localStorage['categories'].split(',');
		}

		var post = {
			title: $('#title').val(),
			url: $('#url').val(),
			tags: $('#tags').val(),
			categories: categories,
			description: $('#description').val(),
			status: $('#status').val()
		};
		$.ajax({
			cache: false,
			type: 'POST',
			url: blog_url,
			data: post,
			dataType: 'json',
			success: function(data, dataType) {
				$('#console').empty();
				$('#errors').empty();
				if ( data.status ) {
					$('#console').text('Registered!!');
					chrome.extension.getBackgroundPage().remove_cache(post.url);
					setTimeout(function(){ window.close(); }, 1000);
				} else if ( "errors" in data ) {
					var errors = "";
					for (var i=0; i<data.errors.length; i++) {
						errors += data.errors[i];
						if (i+1 < data.errors.length) errors += "<br/>";
					}
					$('#errors').html(errors);
				}
			},
			error: function(request, textStatus, errorThrown) {
				// if contain "loginform" in textStatus.
				if (textStatus === 'parsererror' && request.responseText.match(/loginform/g)) {
					$('#errors').html("Please Login<br/>");
				}
			},
			complete: function(request, textStatus) {
				$('#register').attr('disabled', false).val('Register');
			}
		});
	});

	chrome.extension.getBackgroundPage().get_storage(function(_localStorage){
		localStorage = _localStorage;
		$('#option_blog_url').text(localStorage['blog_url']);
		$('#option_categories').text(localStorage['categories']);
	});

	chrome.extension.getBackgroundPage().current_page_info(function(page_info) {
		$('#title').val(page_info.title);
		$('#url').val(page_info.url);
		$('#tags').focus();

		chrome.extension.getBackgroundPage().get_cache($('#url').val(), function(post) {
			if (post) {
				$('#title').val(post.title);
				$('#url').val(post.url);
				$('#tags').val(post.tags);
				$('#description').val(post.description);
				$('#status').val(post.status);
			}
		});
	});
});
