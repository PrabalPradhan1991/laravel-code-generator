$(document).ready(function(){
	var token = $('input[name=_token]').val();

	$('.delete').click(function(e)
	{
		e.preventDefault();

		var currentElement = $(this);
		var url = currentElement.attr('href');
		var status = getLastLetter(url);

		$("#dialog-box").modal({'show' : true,
								'backdrop' : 'static'});
    	
    	$('.modal-body').html('<p>Are you sure you want to delete</p>');
    	ajaxRequestDeleteOrPurge(url, currentElement, status);
	});

	$('.purge').click(function(e)
	{
		e.preventDefault();

		var currentElement = $(this);
		var url = currentElement.attr('href');
		var status = getLastLetter(url);
		
		$("#dialog-box").modal({'show' : true,
								'backdrop' : 'static'});
    	
    	$('.modal-body').html('<p>Are you sure you want to purge</p>');
    	ajaxRequestDeleteOrPurge(url, currentElement, status);
	});

	$('#delete_selected').click(function(e)
	{
		e.preventDefault();
		
		var currentElement = $(this);
		var selectedIdsAndRows = getCheckedIds();

		var url = currentElement.attr('href');

		if(selectedIdsAndRows[0] == '')
		{
			alert('No data selected');
			return false;
		}
		else
		{
			$("#dialog-box-selected").modal({'show' : true,
								'backdrop' : 'static'});
    	
	    	$('.modal-body').html('<p>Are you sure you want to delete</p>');
			
			delete_selected(selectedIdsAndRows, url);	
		}	
	});

	$('#purge_selected').click(function(e){

		e.preventDefault();
		
		var currentElement = $(this);
		var selectedIdsAndRows = getCheckedIds();

		var url = currentElement.attr('href');

		if(selectedIdsAndRows[0] == '')
		{
			alert('No data selected');
			return false;
		}
		else
		{
			$("#dialog-box-selected").modal({'show' : true,
								'backdrop' : 'static'});
    	
	    	$('.modal-body').html('<p>Are you sure you want to permanently delete</p>');
			
			delete_selected(selectedIdsAndRows, url);	
		}	

	});

/**************************************************************************************************************************/	
	function ajaxRequestDeleteOrPurge(url, currentElement, status)
	{
		$('#OK').click(function(){
    		$('.modal-body').html('<p>Please Wait....</p>');
    		var req = $.ajax
					({
						type: 'POST',
						url: url,
						data: {"_token" : token}
					});

					req.done(function(response)
					{
						console.log(response);
						response = JSON.parse(response);
						
						$('.modal-body').html('<p>'+ response.message +'</p>');

						setTimeout(function() {$('#dialog-box').modal('hide');}, 1000);
						if(response.status == 'success')
						{
							parentTr = currentElement.parent().parent();
							
							if(url.indexOf('delete') != -1)
							{
								if(parseInt(status) == 1)
								{
									parentTr.find( "td:eq(4)" ).text(0);
									parentTr.hide();
								}
								else
								{
									 parentTr.find( "td:eq(4)" ).text(0);
								}
							}
							else if(url.indexOf('purge') != -1)
							{
								parentTr.hide();
							}
							
							
						}
					});

					req.fail(function(jqXHR, textStatus)
					{
						$('.modal-body').html('<p>Oops! something went wrong. Please try again</p>');
						console.log(jqXHR);
						console.log(textStatus);
						setTimeout(function() {$('#dialog-box').modal('hide');}, 1000);
					});
    	});	
	}

	function getLastLetter(words)
	{
		var n = words[words.length - 1];
		return n;

	}

	function getCheckedIds()
	{
		var arrs = new Array();
		var selected_ids = '';
		var ids;
		$('.search-table tr').each(function(index, val)
			{
				if(index > 0)
				{
					var currentRow = $(this);
					var currentCheckBox = currentRow.find('.checkbox_id');

					if(currentCheckBox.is(":checked"))
					{
						if(selected_ids == '')
						{
							selected_ids = currentCheckBox.val();
							ids = currentCheckBox.parent().text();
						}
						else
						{
							selected_ids += ',' + currentCheckBox.val();
							ids += ',' + currentCheckBox.parent().text();
						}
						
					}
				}
				
			});

			arrs[0] = selected_ids;
			arrs[1] = ids;

		return arrs;
	}

	function delete_selected(selectedIdsAndRows, url)
	{
		$('#OK-selected').click(function(){
    		$('.modal-body').html('<p>Please Wait....</p>');
    		var req = $.ajax
					({
						type: 'POST',
						url: url,
						data: {"_token" : token, "data" : selectedIdsAndRows}
					});

					req.done(function(response)
					{
						console.log(response);
						
						location.replace($('.url').val());
						//refresh code here
					});

					req.fail(function(jqXHR, textStatus)
					{
						$('.modal-body').html('<p>Oops! something went wrong. Please try again</p>');
						console.log(jqXHR);
						console.log(textStatus);
						setTimeout(function() {$('#dialog-box').modal('hide');}, 1000);
					});
    	});	
	}
/************************************************************************************************************/	
});	