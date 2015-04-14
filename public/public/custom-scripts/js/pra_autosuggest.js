$(document).ready(function(){
	
	//obtaining data for autosuggesst

	///////////////////////////// for activities //////////////////////////////////
	var activity = [];
	var activityObject;

	var activityList = $('.activity-list').find('tbody tr');
	$.each(activityList, function(){
		activityObject = {};
		td = ($(this).find('td'));
		activityObject.activity_name = td.text();
		activityObject.activity_id = td.find('.list_activity_id').val();

		activity.push(activityObject);
	});
	/////////////////////////////////////////////////////////////////////////////////

	///////////////////////////// for places ////////////////////////////////////////
	var place = [];
	var placeObject;

	var placeList = $('.place-list').find('tbody tr');
	$.each(placeList, function(){
		placeObject = {};
		td = ($(this).find('td'));
		placeObject.place_name = td.text();
		placeObject.place_id = td.find('.list_place_id').val();

		place.push(placeObject);
	});
	/////////////////////////////////////////////////////////////////////////////////

	$(document).on('keyup', '.pra_autosuggest.pra_autosuggest_data_activity', function()
	{
		$('.pra_autosuggest_results').hide();
	//$('.pra_autosuggest').keyup(function()
	//{
		var currentElement = $(this);
		var par = $(this).parent();
		
		var pos = $(this).position();
		pos = pos.left;

		var searchResult = "";
		par = par.find('.pra_autosuggest_results');

		console.log(par);

		$.each(activity, function(index, value){
			//(s.indexOf("oo") > -1
			par.show();
			if(currentElement.val() == '')
			{
				par.html('');
			}
			else if(activity[index].activity_name.indexOf(currentElement.val()) > -1)
			{
				par.parent().find('.activity_id').val(activity[index].activity_id);

				searchResult = searchResult + "<li class = 'pra_autosuggest_result_list  pra_autosuggest_data_activity'>"+activity[index].activity_name+"<input type = 'hidden' class = 'pra_autosuggest_data_activity_id' value = '"+activity[index].activity_id+"'></li>";
				par.css('left', pos);
			}
			else
			{
				par.html('');
			}
		});
		if(searchResult != "")
		{
			par.html(searchResult);
		}
		
	});

	$(document).on('keyup', '.pra_autosuggest.pra_autosuggest_data_place', function()
	{
		$('.pra_autosuggest_results').hide();
	//$('.pra_autosuggest').keyup(function()
	//{
		var currentElement = $(this);
		var par = $(this).parent(); //this is td

		var pos = $(this).position();
		pos = pos.left;

		
		var searchResult = "";
		par = par.find('.pra_autosuggest_results');

		console.log(par);

		$.each(place, function(index, value){
			//(s.indexOf("oo") > -1
			par.show();
			if(currentElement.val() == '')
			{
				par.html('');
			}
			else if(place[index].place_name.toLowerCase().indexOf(currentElement.val().toLowerCase()) > -1)
			{

				searchResult = searchResult + "<li class = 'pra_autosuggest_result_list pra_autosuggest_data_place'>"+place[index].place_name+"<input type = 'hidden' class = 'pra_autosuggest_data_place_id' value = '"+place[index].place_id+"'></li>";
				
				
				
				console.log(pos);
				par.css('left', pos);
				
			}
			else
			{
				par.html('');
			}
		});
		if(searchResult != "")
		{
			
			par.html(searchResult);
		}
		
	});

	$(document).on('click', '.pra_autosuggest_result_list.pra_autosuggest_data_activity', function()
	{
		//console.log($(this));
		/*var check = $(this).parent().parent().position();
		console.log(check.left);*/
		id = $(this).find('.pra_autosuggest_data_activity_id').val();
		$(this).parent().parent().find('.activity_id').val(id);

		$(this).parent().parent().find('.pra_autosuggest').val($(this).text());
		$('.pra_autosuggest_results').hide();
	});

	$(document).on('click', '.pra_autosuggest_result_list.pra_autosuggest_data_place', function()
	{
		//console.log($(this));
		/*var check = $(this).parent().parent().position();
		console.log(check.left);*/
		id = $(this).find('.pra_autosuggest_data_place_id').val();
		$(this).parent().parent().find('.place_id').val(id);

		$(this).parent().parent().find('.pra_autosuggest').val($(this).text());
		
		$('.pra_autosuggest_results').hide();
	});
});

