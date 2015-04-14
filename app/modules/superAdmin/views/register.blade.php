@extends('layouts.main')

@section('content')

<div class = "container">
	<form method = "post" action = "{{ URL::route('register-superadmin-post') }}">
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
			<label for = "is_active">Is Active :</label><br>
			<input type = "radio" name = "is_active" value = "1" checked >Yes<input type = "radio" name = "is_active" value = "0">No
		</div>
		<div class = "form-row">
			{{Form::token()}}
			<input type = "submit" value = "submit">
		</div>
	</form>
</div>

@stop