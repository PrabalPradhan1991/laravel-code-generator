$(document).ready(function(){

	$('.required').keyup(function(e){

		var currentElement = $(this);
		
		if(currentElement.val() == '')
		{
			validateAction("error",currentElement, "this field is required");
		}
		else
		{
			validateAction("success", currentElement, "this field is required");
		}
	});

	$('.email').keyup(function(e)
	{
		
		var currentElement = $(this);
		
		reg = '^[A-Z0-9._%a-z+-]+@[A-Z0-9a-z.-]+.[A-Za-z]{2,4}$';
		if(currentElement.val().length > 0)
		{
			if(currentElement.val().match(reg)!= null)
			{
				validateAction("success", currentElement, "this is not valid email format");
			}
			else
			{
				validateAction("error", currentElement, "this is not valid email format");
			}	
		} 
		else if(currentElement.attr('class').indexOf('required'))
		{
			if(currentElement.val() == '')
			{
				validateAction("error",currentElement, "this field is required");
			}
			else
			{
				validateAction("success", currentElement, "this field is required");
			}
		}
		else
		{
			parentDiv = currentElement.parent().parent();
			parentDiv.removeClass('has-success');
			parentDiv.removeClass('has-error');
			parentDiv.find('.help-block').html('');
		}

		
		
	});

	$('.one-required').keyup(function(e)
	{
		var status = false;
		$('.one-required').each(function(index, val)
		{
			if($(this).val() != '')
			{
				status = true;
				return false;
			}
		});

			if(status)
			{
				$('.one-required').each(function(index, val)
				{
					var currentElement = $(this);

					validateAction("success", currentElement, "");
				});
			}
			else
			{
				$('.one-required').each(function(index, val)
				{
					var currentElement = $(this);
					
					validateAction("error", currentElement, "At least one field is required");
				});
			}
	});

	$('.number').keyup(function(e){
		var currentElement = $(this);
		var reg = '^[0-9]+$';

		if(currentElement.val().match(reg)!= null)
		{
			validateAction("success", currentElement, "Only numbers are allowed");
		}
		else
		{
			validateAction("error", currentElement, "Only numbers are allowed");
		}
	});

	$(document).on('keyup', '.alphaSpace', function(e)
	{
		var currentElement = $(this);
		var reg = '^[a-zA-Z ]+$';

		if(currentElement.val().length > 0)
		{
			if(currentElement.val().match(reg)!= null)
			{
				validateAction("success", currentElement, "can only contain alphabets and spaces");
			}
			else
			{
				validateAction("error", currentElement, "can only contain alphabets and spaces");
			}
		}
		else if(currentElement.attr('class').indexOf('required'))
		{
			if(currentElement.val() == '')
			{
				validateAction("error",currentElement, "this field is required");
			}
			else
			{
				validateAction("success", currentElement, "this field is required");
			}
		} 
		else
		{
			parentDiv = currentElement.parent().parent();
			parentDiv.removeClass('has-success');
			parentDiv.removeClass('has-error');
			parentDiv.find('.help-block').html('');
		}
	});

function validateAction(errorOrSuccess, currentElement, error_message)
{
	var parentDiv = currentElement.parent().parent();
	var helpBlock = parentDiv.find('.help-block');
	
	if(errorOrSuccess == 'success')
	{
		parentDiv.addClass('has-success');
		parentDiv.removeClass('has-error');
		helpBlock.html('');
	}
	else
	{
		parentDiv.addClass('has-error');
		parentDiv.removeClass('has-success');
		helpBlock.html(error_message);
	}
}
});