@extends('layouts.main')

@section('content')

<div class = 'container'>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>check_check :</th>
			<td>{{$data->check_check}}</td>
		</tr>
		<tr>
			<th>Is Actvie:</th>
			<td>{{$data->is_active}}</td>
		</tr>
		<tr>
			<td colspan = '2'><a href = "{{URL::route('test-list')}}" class = "btn btn-default">Go Back To List</a></td>
		</tr>
		</body>
	</table>
</div>

@stop

