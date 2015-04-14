@extends('layouts.main')

@section('content')

@include('parentTheatre.views.script')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('parentTheatre-create-post')}}">
	<input type = "hidden" id = "url" value = "{{URL::route('parentTheatre-create-post')}}">
		<div class = 'form-row'>
			<label for = 'parent_name'>Parent_name :</label><br>
			<input type = 'text' name = 'parent_name' value = "{{ (Input::old('parent_name')) ? (Input::old('parent_name')) : '' }}"><span class = "form-error">@if($errors->has('parent_name')){{$errors->first('parent_name')}} }} @endif</span>
		</div>
		<div class = 'form-row'>
			<label for = 'parent_image'>Parent_image :</label><br>
			<input type = 'text' name = 'parent_image' value = "{{ (Input::old('parent_image')) ? (Input::old('parent_image')) : '' }}"><span class = "form-error">@if($errors->has('parent_image')){{$errors->first('parent_image')}} }} @endif</span>
		</div>
		<input type = 'hidden' name = 'is_active' value = '1'>
		<div class = 'form-row'>
			{{Form::token()}}
			<span><input type = 'submit' value = 'create' class = 'btn btn-default'></span><span><input type = 'submit' class = 'addNew btn btn-default' value = 'Create & Add New'></span><span><a href = '{{URL::route('parentTheatre-list')}}' class = 'btn btn-default'>Cancel</a></span>
		</div>
	</form>
</div>

@stop
