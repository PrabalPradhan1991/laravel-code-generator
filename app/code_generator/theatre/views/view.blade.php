@extends('layouts.main')

@section('content')

<div class = 'container'>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>theatre_name :</th>
			<td>{{$data->theatre_name}}</td>
		</tr>
		<tr>
			<th>location :</th>
			<td>{{$data->location}}</td>
		</tr>
		<tr>
			<th>description :</th>
			<td>{{$data->description}}</td>
		</tr>
		<tr>
			<th>Is Actvie:</th>
			<td>{{$data->is_active}}</td>
		</tr>
		<tr>
			<td colspan = '2'><a href = "{{URL::route('theatre-list')}}" class = "btn btn-default">Go Back To List</a></td>
		</tr>
		</body>
	</table>
</div>

@stop

