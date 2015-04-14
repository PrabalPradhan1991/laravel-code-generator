$(document).ready(function(){
	
	var base_url = $('#base_url').val();
	var user_id = $('#user_id').val();


	$('#wish').on('input', function() {
    	$('#add-wish').attr('disabled', false);
	});
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////this is to add wish////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$('#add-wish').click
	(function()
	{
		//do ajax request here
		var user_wish;
		user_wish = $('#wish').val();

		var request = $.ajax({
								 url: base_url+'app-store'
								,type: 'POST'
								,data: {"wish" : user_wish,
									   "user_id" : user_id
									  }
							});
			request.done(function( response )
					   	{
					   
					   		result = JSON.parse(response);
					   		console.log(result.status);
					   		if(result.status == 'success')
					   		{
					   			$('#app-body-table').append("<tr class = 'wish-row'><input type = 'hidden' class = 'wish_id' value = '"+result.id+"'><td class = 'wish-text'>"+user_wish+"</td><td class = 'check-button'><input type = 'button' value = 'complete' class = 'wish-check'></td><td class = 'edit-button'><input type = 'button' value = 'edit' class = 'wish-edit'></td></tr>");
								$('#wish').val('');
								$(this).attr('disabled', true);	
					   		}
					   		else
					   		{
					   			alert('Oops! We could not save your wish. Please try again');
					   			$('#wish').val('');
								$(this).attr('disabled', true);	
					   		}
					   		
					   	});

			request.fail(function( jqXHR, textStatus ) 
										{
								   			alert('Oops! We could not save your wish. Please try again');
								   			$('#wish').val('');
											$(this).attr('disabled', true);	
										 	console.log(jqXHR);
										 	console.log(textStatus);
										});
	}
	);
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$(document).on('click', '.wish-check',
	function()
	{
		
		
		if($(this).val() == 'complete')
			{
				var par;
				
				par = $(this).parent();

				par = par.parent();

				var currentElement = $(this);
				var wish_id = $(par).find('.wish_id').val();
				
				//alert(wish_id);

				//make an ajax request to change status from pending to completed
				var request = $.ajax({
								 url: base_url+'app-edit'
								,type: 'POST'
								,data: {"id" : wish_id,
									   "status" : "completed"
									  }
								});
				request.done(function( response )
					   	{
					   
					   		result = JSON.parse(response);
					   		console.log(result.status);
					   		if(result.status == 'success')
					   		{
					   			currentElement.attr('value' , 'remove');
				
								$(par).find('.wish-text').toggleClass('complete');
								$(par).find('.wish-edit').parent().remove();
				
								par.append('<td class = "undo-button"><input type = "button" class = "wish-undo" value = "undo"></td>');
					   		}
					   		else
					   		{
					   			alert('Oops! We could not save your wish. Please try again');
					   		}
					   		
					   	});

				request.fail(function( jqXHR, textStatus ) 
										{
								   			alert('Oops! We could not save your wish. Please try again');
										});	
			}
			else
			{
				var par;
				
				par = $(this).parent();

				par = par.parent();

				var currentElement = $(this);
				var wish_id = $(par).find('.wish_id').val();

				var request = $.ajax({
								 url: base_url+'app-edit'
								,type: 'POST'
								,data: {"id" : wish_id,
									   "is_active" : "0"
									  }
								});
				request.done(function( response )
					   	{
					   
					   		result = JSON.parse(response);
					   		console.log(result.status);
					   		if(result.status == 'success')
					   		{
					   			currentElement.attr('value' , 'complete');
								/*var pos = $('.wish-check').index(currentElement);
						
								pos = pos + 1;

								$("#app-body-table tr:nth-child("+pos+")").remove();*/
								var par = currentElement.parent();
								par = par.parent();

								par.remove();
					   		}
					   		else
					   		{
					   			alert('Oops! We could not save your wish. Please try again');
					   		}
					   		
					   	});

				request.fail(function( jqXHR, textStatus ) 
										{
								   			alert('Oops! We could not save your wish. Please try again');
										});
				//this is of delete
				
			}
	});
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// this is for wish undo ///////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$(document).on('click', '.wish-undo',
	function()
	{
		
		var currentElement = $(this);
		var  par = $(this).parent();
		par = par.parent();
		var wish_id = $(par).find('.wish_id').val();
		
				var request = $.ajax({
								 url: base_url+'app-edit'
								,type: 'POST'
								,data: {"id" : wish_id,
									   "status" : "pending"
									  }
								});
				request.done(function( response )
					   	{
					   
					   		result = JSON.parse(response);
					   		console.log(result.status);
					   		if(result.status == 'success')
					   		{
					   			par.append("<td class = 'edit-button'><input type = 'button' value = 'edit' class = 'wish-edit'></td>");
								ele = $(par).find('.wish-check');
								$(par).find('.wish-text').toggleClass('complete');
								$(ele).attr('value','complete');
								currentElement.parent().remove();
					   		}
					   		else
					   		{
					   			alert('Oops! We could not save your wish. Please try again');
					   		}
					   		
					   	});

				request.fail(function( jqXHR, textStatus ) 
										{
								   			alert('Oops! We could not save your wish. Please try again');
										});
	});

////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////// this is for wish edit ///////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$(document).on('click', '.wish-edit',
	function()
	{
		

		if($(this).val()=='edit')
		{
			
			var par = $(this).parent();
			par = par.parent();

			ele = $(par).find('.wish-text');
			$(par).find('.wish-check').attr('disabled', true);
			//console.log(ele);
			var wish = ele.text();
			ele.text('');
			ele.append('<input type = "text" value = "'+wish+'" name = "edit-wish-text" class = "edit-wish-text">');

			$(this).attr('value','ok');
		}
		else //this is for when clicking ok. make ajax request here
		{
			
			
			var par = $(this).parent();
			par = par.parent();

			ele = $(par).find('.edit-wish-text');
			var wish = ele.val();

			var currentElement = $(this);
			var wish_id = $(par).find('.wish_id').val();
			
			var request = $.ajax({
								 url: base_url+'app-edit'
								,type: 'POST'
								,data: {"id" : wish_id,
									   "wish" : wish
									  }
								});
				request.done(function( response )
					   	{
					   
					   		result = JSON.parse(response);
					   		console.log(result.status);
					   		if(result.status == 'success')
					   		{
					   			$(par).find('.wish-check').attr('disabled', false);

								ele.remove();
								ele = $(par).find('.wish-text');
								ele.text(wish);
								currentElement.attr('value', 'edit');
					   		}
					   		else
					   		{
					   			alert('Oops! We could not save your wish. Please try again');
					   		}
					   		
					   	});

				request.fail(function( jqXHR, textStatus ) 
										{
								   			alert('Oops! We could not save your wish. Please try again');
										});
		}
		
	});	
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

});