@extends('layouts.main')

@section('custom')

<script src = "{{asset('validation-script/jquery.validate.js')}}" type = "text/javascript"></script>
<!-- <script src = "{{asset('validation-script/custom_validation.js')}}" type = "text/javascript"></script> -->

<link href = "{{asset('validation-script/css/style.css')}}" rel = "stylesheet">

@stop

@section('content')

<div class = "container">
	<form method = "post" action = "{{ URL::route('admin-register-post') }}" id = "validate-js">
		<div class = "form-row">
			<label for = "name">Name :</label><br>
			<input type = "text" name = "name" value = "{{ (Input::old('name')) ? (Input::old('name')) : '' }}"><span class = "form-error">@if($errors->has('name')) {{ $errors->first('name') }} @endif</span>
		</div>
		<div class = "form-row">
			<label for = "username">Username :</label><br>
			<input type = "text" name = "username" value = "{{ (Input::old('userename')) ? (Input::old('username')) : '' }}"><span class = "form-error">@if($errors->has('username')) {{ $errors->first('username') }} @endif</span>
		</div>
		<div class = "form-row">
			<label for = "password">Password :</label><br>
			<input type = "password" name = "password"><span class = "form-error">@if($errors->has('password')) {{ $errors->first('password') }} @endif</span>
		</div> 
		<div class = "form-row">
			<label for = "confirm_password">Confirm Password :</label><br>
			<input type = "password" name = "confirm_password"><span class = "form-error">@if($errors->has('confirm_password')) {{ $errors->first('confirm_password') }} @endif</span>
		</div>
		<div class = "form-row">
			<label for = "email">Email :</label><br>
			<input type = "text" name = "email" value = "{{ (Input::old('email')) ? (Input::old('email')) : '' }}"><span class = "form-error">@if($errors->has('email')) {{ $errors->first('email') }} @endif</span>
		</div>
		<div class = "form-row">
			<label for = "contact">Contact :</label><br>
			<input type = "contact" name = "contact" value = "{{ (Input::old('contact')) ? (Input::old('contact')) : '' }}"><span class = "form-error">@if($errors->has('contact')) {{ $errors->first('contact') }} @endif</span>
		</div>
		<div class = "form-row">
			<label for = "address">Address :</label><br>
			<input type = "address" name = "address" value = "{{ (Input::old('address')) ? (Input::old('address')) : '' }}"><span class = "form-error">@if($errors->has('address')) {{ $errors->first('address') }} @endif</span>
		</div>
		
		<div class = "form-row">
			<label for = "group_id">Group</label><br>
			{{HelperController::generateSelectList('Group', 'group_name', 'id', 'group_id', $selected = '') //($modelname, $name, $value, $field_name, $selected = '')}}
		</div>

		<div class = "form-row">
			<input type = "hidden" name = "is_active" value = "1">
		</div>
		<div class = "form-row">
			{{Form::token()}}
			<input type = "submit" value = "submit" id = "submitButton">
		</div>
	</form>
</div>

@stop