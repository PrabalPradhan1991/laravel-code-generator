@extends('layouts.main')

@section('content')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('test-edit-post', $data->id)}}"></td>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>check_check</th>
			<td><input type = 'text' name = 'check_check' value = '{{$data->check_check}}'><span class = 'form-error'>@if($errors->has('check_check')) {{ $errors->first('check_check') }} @endif</span></td>
		</tr>
		<tr>
			<th>Is Active</th>
			<td><span><input type = 'radio' name = 'is_active' value = '1' @if($data->is_active == 1) {{'checked'}} @endif>Yes</span><span><input type = 'radio' name = 'is_active' value = '0' @if($data->is_active == 0) {{'checked'}} @endif>No</span>
		</tr>
		<tr>
			<td>{{Form::token()}}<input type = "submit" class = "btn btn-info" value = "edit"></td><td><a href = "{{URL::route('test-list')}}" class = "btn btn-default">Cancel</a></td>
		</tr>
		</body>
	</table>
	</form>
</div>

@stop

