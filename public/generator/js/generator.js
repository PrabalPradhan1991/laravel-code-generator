$(document).ready(function(){
	var field_counter = 0;
	var function_counter = 0;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	$('#field_name').keyup(function()
	{
		$('#addField').attr('disabled', false);
	});

	$(document).on('click', '#addField', function()
	{
		field_counter++;

		var currentElement = $(this);
		var field_name = $('#field_name');

		var fieldToAppend = '<input type = "text" class = "field" name = "_field'+field_counter+'" value = "'+ field_name.val() +'">';
		$('.fields').append(fieldToAppend);
		
		/////////////////////////////
		addInFillables(field_name.val());
		showInLists(field_name.val());
		showInInputForms(field_name.val());
		////////////////////////////

		field_name.val('');

		currentElement.attr('disabled', true);

	});

	$(document).on('keyup', '.field', function()
	{
		var index = $(this).attr('name');

		var field = $(this).val();

			index = index[index.length -1];
			index = "."+index;
		
		field_name = $(index).find('span');
		field_name.text(field);
		$(index).find('.box').val(field);
		
	});

	function addInFillables(fieldname)
	{

		var fieldToAppend = '<span class = '+ field_counter +'><span>'+ fieldname +'</span><input type = "checkbox" name = "_fillable'+ field_counter +'" value = "'+fieldname+'" checked class = "box"></span>';
		$('.fillables').append(fieldToAppend);
	}

	function showInLists(fieldname)
	{

		var fieldToAppend = '<span class = '+ field_counter +'><span>'+ fieldname +'</span><input type = "checkbox" name = "_showInList'+ field_counter +'" value = "'+fieldname+'" checked class = "box"></span>';
		$('.showInLists').append(fieldToAppend);
	}

	function showInInputForms(fieldname)
	{

		var fieldToAppend = '<span class = '+ field_counter +'><span>'+ fieldname +'</span><input type = "checkbox" name = "_showInInputForm'+ field_counter +'" value = "'+fieldname+'" checked class = "box"></span>';
		$('.showInInputForms').append(fieldToAppend);	
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$('#addFunction').click(function()
	{
		//check if all fields are filled
		var url_name = $('.url_name').val();
		var function_name = $('.function_name').val();
		var route_name = $('.route_name').val();
		var route_type_name = $('.route_type_name').val();

		if(url_name.trim() == '')
		{
			alert('url is empty');
			return false;
		}
		else if(function_name.trim() == '')
		{
			alert('function name is empty');
			return false;
		}
		else if(route_name.trim() == '')
		{
			alert('route-name is empty');
			return false;
		}
		else if(route_type_name.trim() == '')
		{
			alert('route-type-name is empty');
			return false;
		}
		else
		{
			function_counter++;

			
			toAppend = '<tr class = "'+ function_counter +'">';
			toAppend += '<td class = "url"><input type = "text" name = "_url'+ function_counter +'" value = "'+ url_name +'"></td>';
			toAppend += '<td class = "function"><input type = "text" name = "_function'+ function_counter +'" value = "'+ function_name +'"></td>';
			toAppend += '<td class = "route"><input type = "text" name = "_route'+ function_counter +'" value = "'+ route_name +'"></td>';
			toAppend += '<td class = "route_type"><input type = "text" name = "_route_type'+ function_counter +'" value = "'+ route_type_name +'"></td>';
			toAppend += '</tr>';

			$('#addfunctiontable').append(toAppend);
			$('.url_name').val('');
			$('.function_name').val('');
			$('.route_name').val('');
		}
	});

	$('#generate').click(function(){
		if($('#module_name').val().trim() == '')
		{
			alert('module name not given');
			return false;
		}
		else if($('#table_name').val().trim() == '')
		{
			alert('table name not given');
			return false;
		}
	});

});

