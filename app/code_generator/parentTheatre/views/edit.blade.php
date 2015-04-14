@extends('layouts.main')

@section('content')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('parentTheatre-edit-post', $data->id)}}"></td>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>parent_name</th>
			<td><input type = 'text' name = 'parent_name' value = '{{$data->parent_name}}'><span class = 'form-error'>@if($errors->has('parent_name')) {{ $errors->first('parent_name') }} @endif</span></td>
		</tr>
		<tr>
			<th>parent_image</th>
			<td><input type = 'text' name = 'parent_image' value = '{{$data->parent_image}}'><span class = 'form-error'>@if($errors->has('parent_image')) {{ $errors->first('parent_image') }} @endif</span></td>
		</tr>
		<tr>
			<th>Is Active</th>
			<td><span><input type = 'radio' name = 'is_active' value = '1' @if($data->is_active == 1) {{'checked'}} @endif>Yes</span><span><input type = 'radio' name = 'is_active' value = '0' @if($data->is_active == 0) {{'checked'}} @endif>No</span>
		</tr>
		<tr>
			<td>{{Form::token()}}<input type = "submit" class = "btn btn-info" value = "edit"></td><td><a href = "{{URL::route('parentTheatre-list')}}" class = "btn btn-default">Cancel</a></td>
		</tr>
		</body>
	</table>
	</form>
</div>

@stop

