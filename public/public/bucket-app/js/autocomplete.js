$(document).ready(function(){

	var places_table = $('.place-list');

	$.each(places_table, function(index, value)
	{
		alert($(this).val());
	});
});