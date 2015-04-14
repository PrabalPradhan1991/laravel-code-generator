@extends('layouts.main')

@section('content')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('reservation-edit-post', $data->id)}}"></td>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>reservation_name</th>
			<td><input type = 'text' name = 'reservation_name' value = '{{$data->reservation_name}}'><span class = 'form-error'>@if($errors->has('reservation_name')) {{ $errors->first('reservation_name') }} @endif</span></td>
		</tr>
		<tr>
			<th>reservation_type</th>
			<td><input type = 'text' name = 'reservation_type' value = '{{$data->reservation_type}}'><span class = 'form-error'>@if($errors->has('reservation_type')) {{ $errors->first('reservation_type') }} @endif</span></td>
		</tr>
		<tr>
			<th>reservation_location</th>
			<td><input type = 'text' name = 'reservation_location' value = '{{$data->reservation_location}}'><span class = 'form-error'>@if($errors->has('reservation_location')) {{ $errors->first('reservation_location') }} @endif</span></td>
		</tr>
		<tr>
			<th>Is Active</th>
			<td><span><input type = 'radio' name = 'is_active' value = '1' @if($data->is_active == 1) {{'checked'}} @endif>Yes</span><span><input type = 'radio' name = 'is_active' value = '0' @if($data->is_active == 0) {{'checked'}} @endif>No</span>
		</tr>
		<tr>
			<td>{{Form::token()}}<input type = "submit" class = "btn btn-info" value = "edit"></td><td><a href = "{{URL::route('reservation-list')}}" class = "btn btn-default">Cancel</a></td>
		</tr>
		</body>
	</table>
	</form>
</div>

@stop

