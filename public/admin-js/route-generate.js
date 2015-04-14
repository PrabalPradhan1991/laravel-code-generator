$(document).ready(function(){
	var function_counter = 0;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
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

});

