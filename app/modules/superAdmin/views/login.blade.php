@extends('layouts.main')

@section('content')

<div class = "container">
	<form method = "post" action = "{{URL::route('login-superadmin-post')}}">
		<div class = "form-row">
			<label for = "username">Username :</label>
			<input type = "text" name = "username" value = "{{Input::old('username') ? Input::old('username') : '' }}">
		</div>
		<div class = "form-row">
			<label for = "password">Password :</label>
			<input type = "password" name = "password">
		</div>
		<div class = "form-row">
			<input type = "checkbox" name = "remember"><span>Remember me</span>
		</div>
		<div class = "form-row">
			{{Form::token()}}
			<input type = "submit" value = "submit" class = "btn btn-default"><span><a href = "{{URL::route('register-superadmin')}}" class = "btn btn-info">Register</a></span>
		</div>
	</form>
</div>

<div class = "container">
	@if(Session::has('error'))
		{{Session::get('error')}}
	@endif
</div>

@stop