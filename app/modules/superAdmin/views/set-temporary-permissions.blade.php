@extends('layouts.main')

@section('content')

@include('superAdmin.views.script')

<div class = "container">
	<form method = "post" action = "{{URL::route('set-temporary-permissions-post')}}">
		<input type = "hidden" id = "admin_id" value = "{{$default_admin_id}}">
		<div class = 'form-group'>
			<span>Select Controller : </span><span>{{ HelperController::generateSelectList('Module', 'module_name', 'id', 'controller_name', $selected = $default_controller_id) }}</span>
		</div>

		<div class = 'form-group'>
			<span>Select Admin : </span><span>{{ HelperController::generateSelectList('Admin', 'username', 'id', 'admin_id', $default_admin_id) }}</span>
		</div>

		@if(count($module_functions))
			<div class = 'form-group'>
			@foreach($module_functions as $module_function)
				<div><span><input type = "checkbox" name = "_checkbox{{$module_function->id}}" value = "{{$module_function->id}}">{{$module_function->module_function_code}}</span></div>
			@endforeach
			</div>
		@endif				

		<div class = 'form-group'>
			<span>Expiry Date : </span><span><input type = "text" name = "expiry_date" value = "{{ Input::old('expiry_date') ? Input::old('expiry_date') : '' }}"></span><span class = "form-error">@if($errors->has('expiry_date')) {{$errors->first('expiry_date')}} @endif</span>
		</div>

		<div class = 'form-group'>
			<span>{{Form::token()}}<input type = "submit" value = "Create Permission" class = "btn btn-success"></span>
		</div>
		
	</form>
</div>

@stop