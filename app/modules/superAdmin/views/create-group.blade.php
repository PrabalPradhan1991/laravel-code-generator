@extends('layouts.main')

@section('custom')

<!-- <script src = "{{ asset('packages/test.js') }}"></script> -->

@stop

@include('superAdmin.views.script')

@section('content')

<div class = "container">
	<form method = "post" action = "{{ URL::route('create-group-post') }}">
	<table class = "table">
		<tr>
			<td><label for = "group_name">Enter the Group Name</label></td>
			<td><input type = "text" name = "group_name"  class = "input-xxlarge"><input type = "hidden" name = "is_active" value = "1"></td>
		</tr>
		<tr>
			<td colspan = "2">{{ Form::token() }}<span><input type = 'submit' value = 'create' class = 'btn btn-default'></span><span><input type = 'submit' class = 'addNew btn btn-default' value = 'Create & Add New'></span><span><a href = '{{URL::route("list-groups")}}' class = 'btn btn-default'>Cancel</a></span></td>
		</tr>
		<!--
		<tr>
			<td><textarea id = "1" class = "ckeditor"></textarea></td>
		</tr>
		-->
	</table>
	</form>
</div>

@stop