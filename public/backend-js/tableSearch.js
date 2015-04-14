$(document).ready(function(){

	$('.search_column').keyup(function(e){

		var currentElement = $(this);
		
		if(e.which == 13)
		{
			//find column name
			var column_value = currentElement.val();
			var column_name = currentElement.parent().find('.field_name').val();
			var url = $('#url').val();

			window.location.replace(url + '?column_name=' + column_name + '&' + 'column_value=' + column_value);

		}
		else
		{
			var column_num = currentElement.attr('id');
			var i = 0;
			$('.search-table tr').each(function(index, val)
			{
		
				if(index != 0)
				{
					
					var currentRow = $(this);
					currentRow.show();
					var currentColumn = currentRow.find("td:eq("+ (parseInt(column_num) - parseInt(1)) +")");
					var status = true;
					if(currentColumn.text().toLowerCase().indexOf(currentElement.val().toLowerCase()) == -1)
					{
						currentRow.hide();
					}

					/*if(status == false)
					{
						if(currentColumn.find("input").val().toLowerCase().indexOf(currentElement.val().toLowerCase()) == -1)
						{
							currentRow.hide();
						}
					}*/
					
				}
			
			}); 
		}
	});
	
	
});