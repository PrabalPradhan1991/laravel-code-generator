@extends('layouts.main')

@section('content')

<div class = 'container'>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>reservation_name :</th>
			<td>{{$data->reservation_name}}</td>
		</tr>
		<tr>
			<th>reservation_type :</th>
			<td>{{$data->reservation_type}}</td>
		</tr>
		<tr>
			<th>reservation_location :</th>
			<td>{{$data->reservation_location}}</td>
		</tr>
		<tr>
			<th>Is Actvie:</th>
			<td>{{$data->is_active}}</td>
		</tr>
		<tr>
			<td colspan = '2'><a href = "{{URL::route('reservation-list')}}" class = "btn btn-default">Go Back To List</a></td>
		</tr>
		</body>
	</table>
</div>

@stop

