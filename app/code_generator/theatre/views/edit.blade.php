@extends('layouts.main')

@section('content')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('theatre-edit-post', $data->id)}}"></td>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>theatre_name</th>
			<td><input type = 'text' name = 'theatre_name' value = '{{$data->theatre_name}}'><span class = 'form-error'>@if($errors->has('theatre_name')) {{ $errors->first('theatre_name') }} @endif</span></td>
		</tr>
		<tr>
			<th>location</th>
			<td><input type = 'text' name = 'location' value = '{{$data->location}}'><span class = 'form-error'>@if($errors->has('location')) {{ $errors->first('location') }} @endif</span></td>
		</tr>
		<tr>
			<th>description</th>
			<td><input type = 'text' name = 'description' value = '{{$data->description}}'><span class = 'form-error'>@if($errors->has('description')) {{ $errors->first('description') }} @endif</span></td>
		</tr>
		<tr>
			<th>Is Active</th>
			<td><span><input type = 'radio' name = 'is_active' value = '1' @if($data->is_active == 1) {{'checked'}} @endif>Yes</span><span><input type = 'radio' name = 'is_active' value = '0' @if($data->is_active == 0) {{'checked'}} @endif>No</span>
		</tr>
		<tr>
			<td>{{Form::token()}}<input type = "submit" class = "btn btn-info" value = "edit"></td><td><a href = "{{URL::route('theatre-list')}}" class = "btn btn-default">Cancel</a></td>
		</tr>
		</body>
	</table>
	</form>
</div>

@stop

