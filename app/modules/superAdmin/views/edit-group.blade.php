@extends('layouts.main')

@section('content')
	
	<div class = "container">

		<form method = "post" action = "{{URL::route('edit-group-post', $group->id)}}">
		<table class = 'table table-striped table-hover table-bordered'>
			<tbody>
			<tr>
				<th>id</th>
				<td>{{$group->id}}<input type = "hidden" name = "id" value = "{{$group->id}}"></td>
			</tr>
			<tr>
				<th>Group Name</th>
				<td><input type = "text" name = "group_name" value = "{{$group->group_name}}"></td>
			</tr>
			<tr>
				<th>is active</th>
				<td><input type = "radio" name = 'is_active' value = "1" @if($group->is_active == 1) checked @endif>Yes<input type = "radio" name = 'is_active' value = "0" @if($group->is_active == 0) checked @endif>No</td>
			</tr>
			<tr>
				<td>{{Form::token()}}<input type = "submit" class = "btn btn-info" value = "edit"></td>
				<td><span><a href = '{{URL::route("list-groups")}}' class = 'btn btn-default'>Cancel</a></span></td>
			</tr>
			</tbody>
		</table> 
		</form>
	</div>

@stop