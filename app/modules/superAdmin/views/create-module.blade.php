@extends('layouts.main')

@section('content')

<div class = "container">
	<form method = "post" action = "{{URL::route('create-module-post')}}">
	<table class = "table">
		<tr>
			<td><label for = "module_name">Enter the Module Name</label></td>
			<td><input type = "text" name = "module_name"></td>
		</tr>
		<tr>
			<td colspan = "2">{{ Form::token() }}<input type = "submit" value = "create"></td>
		</tr>
	</table>
	</form>
</div>

@stop