@extends('layouts.main')

@section('content')

@include('theatre.views.script')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('theatre-create-post')}}">
	<input type = "hidden" id = "url" value = "{{URL::route('theatre-create-post')}}">
		<div class = 'form-row'>
			<label for = 'theatre_name'>Theatre_name :</label><br>
			<input type = 'text' name = 'theatre_name' value = "{{ (Input::old('theatre_name')) ? (Input::old('theatre_name')) : '' }}"><span class = "form-error">@if($errors->has('theatre_name')){{$errors->first('theatre_name')}} }} @endif</span>
		</div>
		<div class = 'form-row'>
			<label for = 'location'>Location :</label><br>
			<input type = 'text' name = 'location' value = "{{ (Input::old('location')) ? (Input::old('location')) : '' }}"><span class = "form-error">@if($errors->has('location')){{$errors->first('location')}} }} @endif</span>
		</div>
		<div class = 'form-row'>
			<label for = 'description'>Description :</label><br>
			<input type = 'text' name = 'description' value = "{{ (Input::old('description')) ? (Input::old('description')) : '' }}"><span class = "form-error">@if($errors->has('description')){{$errors->first('description')}} }} @endif</span>
		</div>
		<input type = 'hidden' name = 'is_active' value = '1'>
		<div class = 'form-row'>
			{{Form::token()}}
			<span><input type = 'submit' value = 'create' class = 'btn btn-default'></span><span><input type = 'submit' class = 'addNew btn btn-default' value = 'Create & Add New'></span><span><a href = '{{URL::route('theatre-list')}}' class = 'btn btn-default'>Cancel</a></span>
		</div>
	</form>
</div>

@stop
