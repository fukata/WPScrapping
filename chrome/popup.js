$(function(){
	$('#debug').text('debug mode');
	$('#register').click(function(){
		var url = '';
		var data = {
			title: $('#title').val(),
			url: $('#url').val(),
			tags: $('#tags').val(),
			description: $('#description').val()
		};
		$.ajax({
			cache: false,
			type: 'POST',
			url: url,
			data: data,
			dataType: 'json',
			success: function(data, dataType) {
				$('#errors').empty();
				if ( "errors" in data ) {
					var errors = "";
					for (var i=0; i<data.errors.length; i++) {
						errors += data.errors[i];
						if (i+1 < data.errors.length) errors += "<br/>";
					}
					$('#errors').html(errors);
				}
			},
			error: function(request, textStatus, errorThrown) {
			},
			complete: function(request, textStatus) {
				$('#debug').text(textStatus);
			}
		});
		$('#debug').text('submited');
	});

	chrome.extension.getBackgroundPage().current_page_info(function(page_info) {
		$('#title').val(page_info.title);
		$('#url').val(page_info.url);
	});
});
