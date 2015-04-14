@extends('layouts.main')

@section('content')

	<div class = "container">
	<form method = "post" action = "{{ URL::route('users-register-post') }}">
		<div class = "form-row">
			<label for = "fname">First Name :</label><br>
			<input type = "text" name = "fname" value = "{{ (Input::old('fname')) ? (Input::old('fname')) : '' }}"><span class = "form-error">@if($errors->has('fname')) {{ $errors->first('fname') }} @endif</span>
		</div>
		<div class = "form-row">
			<label for = "mname">Middle Name :</label><br>
			<input type = "text" name = "mname" value = "{{ (Input::old('mname')) ? (Input::old('mname')) : '' }}"><span class = "form-error">@if($errors->has('mname')) {{ $errors->first('mname') }} @endif</span>
		</div>
		<div class = "form-row">
			<label for = "lname">Last Name :</label><br>
			<input type = "text" name = "lname" value = "{{ (Input::old('lname')) ? (Input::old('lname')) : '' }}"><span class = "form-error">@if($errors->has('lname')) {{ $errors->first('lname') }} @endif</span>
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
			<label for = "email">Email:</label><br>
			<input type = "text" name = "email" value = "{{ (Input::old('email')) ? (Input::old('email')) : '' }}"><span class = "form-error">@if($errors->has('email')) {{ $errors->first('email') }} @endif</span>
		</div>
		<div class = "form-row">
			<label for = "contact">Contact:</label><br>
			<input type = "text" name = "contact" value = "{{ (Input::old('contact')) ? (Input::old('contact')) : '' }}"><span class = "form-error">@if($errors->has('contact')) {{ $errors->first('contact') }} @endif</span>
		</div>
		<div class = "form-row">
			<label for = "address">Address:</label><br>
			<input type = "text" name = "address" value = "{{ (Input::old('address')) ? (Input::old('address')) : '' }}"><span class = "form-error">@if($errors->has('address')) {{ $errors->first('address') }} @endif</span>
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