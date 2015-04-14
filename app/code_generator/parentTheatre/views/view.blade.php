@extends('layouts.main')

@section('content')

<div class = 'container'>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>parent_name :</th>
			<td>{{$data->parent_name}}</td>
		</tr>
		<tr>
			<th>parent_image :</th>
			<td>{{$data->parent_image}}</td>
		</tr>
		<tr>
			<th>Is Actvie:</th>
			<td>{{$data->is_active}}</td>
		</tr>
		<tr>
			<td colspan = '2'><a href = "{{URL::route('parentTheatre-list')}}" class = "btn btn-default">Go Back To List</a></td>
		</tr>
		</body>
	</table>
</div>

@stop

