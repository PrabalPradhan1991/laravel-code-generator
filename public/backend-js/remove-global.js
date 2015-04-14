$(document).ready(function()
		{
			$('.alert .close').click(function(){
				var url = $('.global-remove-url').val();
				
				var request = $.ajax
								({
									type: 'POST',
									url: url
								});

			});
		});