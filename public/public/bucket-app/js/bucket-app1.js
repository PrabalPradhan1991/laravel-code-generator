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

	/////////////////////////////////////// for place and activity ////////////////////////////////////////////
	$('.place_name').click(function()
	{
		var placename = $(this).text();
		var place_id = $(this).find('.list_place_id').val();

		$('.place-name').html('<strong>'+placename+'</strong>');
		$('#place_id').val(place_id);

		$('#add-wish').attr('disabled', false);
	});

	$('.activity_name').click(function()
	{
		var activityname = $(this).text();
		var activity_id = $(this).find('.list_activity_id').val();

		$('.activity-name').html('<strong>'+activityname+'</strong>');
		$('#activity_id').val(activity_id);

		$('#add-wish').attr('disabled', false);
	});
	///////////////////////////////// after clicking add button ////////////////////////////////////////////////
	$('#add-wish').click
	(function()
	{
		var place_id = $('#place_id').val();
		var activity_id = $('#activity_id').val();

		$(this).attr('disabled', true);
		//do ajax request here
		var user_wish;
		user_wish = $('#wish').text();

		var request = $.ajax({
								 url: base_url+'app-store' //base_url defined at top
								,type: 'POST'
								,data: {"wish" : user_wish,
									   "user_id" : user_id,
									   "place_id" : place_id,
									   "activity_id" : activity_id
									  }
							});
			request.done(function( response )
					   	{
					   
					   		result = JSON.parse(response);
					   		console.log(result.status);
					   		if(result.status == 'success')
					   		{
					   			$('#app-body-table').append("<tr class = 'wish-row'><input type = 'hidden' class = 'wish_id' value = '"+result.id+"'><td class = 'wish-text'>"+user_wish+"<input type = 'hidden' name = 'place_id' id = 'place_id' value = '"+place_id+"'><input type = 'hidden' name = 'activity_id' class = 'activity_id' value = '"+activity_id+"'></td><td class = 'check-button'><input type = 'button' value = 'complete' class = 'wish-check btn btn-info'></td><td class = 'edit-button btn btn-default'><input type = 'button' value = 'edit' class = 'wish-edit btn btn-default'></td></tr>");
								$('.activity-name').text('');
								$('.place-name').text('');
								$(this).attr('disabled', true);	
					   		}
					   		else
					   		{
					   			alert('Oops! We could not save your wish. Please try again');
					   			$('.activity-name').text('');
								$('.place-name').text('');
								$(this).attr('disabled', true);	
					   		}
					   		
					   	});

			request.fail(function( jqXHR, textStatus ) 
										{
								   			alert('Oops! We could not save your wish. Please try again');
								   			$('.activity-name').text('');
											$('.place-name').text('');
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
				var wish_id = (par).find('.wish_id').val();
				
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
				
								par.append('<td class = "undo-button"><input type = "button" class = "wish-undo btn btn-default" value = "undo"></td>');
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
					   			par.append("<td class = 'edit-button'><input type = 'button' value = 'edit' class = 'wish-edit btn btn-default'></td>");
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
			

			ele.html('I want to go <span><input type = "text" class = "pra_autosuggest pra_autosuggest_data_activity" value =""><input type = "hidden" name = "activity_id" class = "activity_id" value = ""><ul class = "pra_autosuggest_results"></ul></span> in <span><input type = "text" class = "pra_autosuggest  pra_autosuggest_data_place" value =""><input type = "hidden" name = "activity_id" class = "place_id" value = ""><ul class = "pra_autosuggest_results"></ul></span>');
			$(this).attr('value','ok');
		}
		else //this is for when clicking ok. make ajax request here
		{
			$(this).attr('disabled', true);
			
			var par = $(this).parent();
			par = par.parent();
			
			var activity_id = par.find('.activity_id').val();
			var place_id = par.find('.place_id').val();

			if(place_id == '')
			{
				place_id = -1;
			}

			if(activity_id == '')
			{
				activity_id = -1;
			}

			var wish = par.text().trim();
			
			
			var currentElement = $(this);
			var wish_id = $(par).find('.wish_id').val();
			
			var request = $.ajax({
								 url: base_url+'app-edit'
								,type: 'POST'
								,data: {"id" : wish_id,
									   "wish" : wish,
									   "place_id" : place_id,
									   "activity_id" : activity_id
									  }
								});
				request.done(function( response )
					   	{
					   
					   		result = JSON.parse(response);
					   		console.log(result.status);
					   		if(result.status == 'success')
					   		{
					   			$(par).find('.wish-check').attr('disabled', false);

								ele.text(wish);
								
								currentElement.attr('value', 'edit');
								currentElement.attr('disabled', false);
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