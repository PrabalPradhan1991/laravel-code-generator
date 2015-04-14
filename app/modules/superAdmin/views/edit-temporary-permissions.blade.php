@extends('layouts.main')

@section('content')

@include('superAdmin.views.script')

<div class = "container">
	@if(count($module_functions))
	<form method = "post" action = "{{URL::route('edit-temporary-permissions-post', $data->admin_id)}}">
		<input type = "hidden" id = "admin_id" value = "{{$data->admin_id}}">
		
		<div class = 'form-group'>
			<span>Admin : </span><span>{{ $data->username }}</span>
		</div>

		
			<div class = 'form-group'>
			@foreach($module_functions as $module_function_id => $module_function)
				<div><span><input type = "checkbox" name = "_checkbox{{$module_function_id}}" value = "{{$module_function_id}}" checked></span><span>{{ $module_function }}</span></div>
			@endforeach
			</div>
						

		<div class = 'form-group'>
			<span>Expiry Date : </span><span><input type = "text" name = "expiry_date" value = "{{ Input::old('expiry_date') ? Input::old('expiry_date') : $data->expiry_date }}"></span><span class = "form-error">@if($errors->has('expiry_date')) {{$errors->first('expiry_date')}} @endif</span>
		</div>

		<div class = "form-group">
				<span>is active</span>
				<span><input type = "radio" name = 'is_active' value = "1" @if($data->is_active == 1) checked @endif>Yes<input type = "radio" name = 'is_active' value = "0" @if($data->is_active == 0) checked @endif>No</span>
		</div>

		<div class = 'form-group'>
			<span>{{Form::token()}}<input type = "submit" value = "Create Permission" class = "btn btn-success"></span><span><a href = "{{URL::route('list-admins') }}" class = "btn btn-info">Cancel</a></span>
		</div>
	</form>
		@else
		<div class = "form-group">
			No Temporary Permission set for this Admin
			<div class = "form-group">
				<span><a href = "{{URL::route('list-admins') }}" class = "btn btn-info">Cancel</a></span>
			</div>
		</div>
		@endif
</div>

@stop