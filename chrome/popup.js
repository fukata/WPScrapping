$(function(){
	$('#register').click(function(){
		$('#register').attr('disabled', true).val('Registering...');

		var url = '';
		var data = {
			title: $('#title').val(),
			url: $('#url').val(),
			tags: $('#tags').val(),
			categories: [],
			description: $('#description').val()
		};
		$.ajax({
			cache: false,
			type: 'POST',
			url: url,
			data: data,
			dataType: 'json',
			success: function(data, dataType) {
				$('#console').empty();
				$('#errors').empty();
				if ( data.status ) {
					$('#console').text('Registered!!');
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
			},
			complete: function(request, textStatus) {
				$('#register').attr('disabled', false).val('Register');
			}
		});
	});

	chrome.extension.getBackgroundPage().current_page_info(function(page_info) {
		$('#title').val(page_info.title);
		$('#url').val(page_info.url);
		$('#tags').focus();
	});
});
