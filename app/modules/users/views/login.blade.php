@extends('layouts.main')

@section('content')

<div class = "container">
	<form method = "post" action = "{{ URL::route('users-login-post') }}">
		<div class = "form-row">
			<label for = "email">Email :</label>
			<input type = "text" name = "email" value = "{{ (Input::old('email')) ? (Input::old('email')) : '' }}">
		</div>
		<div class = "form-row">
			<label for = "password">Password : </label>
			<input type = "password" name = "password">
		</div>
		<div class = "form-row">
			<input type = "checkbox" name = "remember"><span>Remember me</span>
		</div>
		<div class = "form-row">
			{{Form::token()}}<input type = "submit" value = "log in">
		</div>
	</form>
</div>
<div class = "container">
@if(Session::has('error'))
{{Session::get('error')}}
@endif
</div>

@stop