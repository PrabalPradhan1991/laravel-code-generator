@extends('layouts.main')

@section('custom')

<script src = "{{ asset('backend-js/deleteOrPurge.js') }}" type = "text/javascript"></script>

<script src = "{{ asset('backend-js/tableSearch.js') }}" type = "text/javascript"></script>

<style type="text/css" rel="stylesheet">

</style>
@stop

@section('content')

<div class = 'container'>
	<span><a class = 'btn btn-default' href = '{{URL::route('admin-register')}}'>Create New</a></span><span><a class = 'btn btn-default' href = '{{URL::route("delete-admins-post")}}' id = 'delete_selected'>Delete</a></span>
</div>

<input type = 'hidden' id = 'url' value = '{{URL::current()}}'>

<div class = 'container'>
<span>Show :<a class = 'paginate_limit' href = '{{URL::current()}}?paginate=10'>10</a> / <a class = 'paginate_limit' href = '{{URL::current()}}?paginate=20'>20</a> / <a class = 'paginate_limit' href = '{{URL::current()}}?paginate=30'>30</a>
</div>

@include('include.modal')

@include('include.modal-selected')

<div class = 'container'>

<input type = 'hidden' value = '{{URL::current()}}' class = 'url'>

	<table class = 'table table-striped table-hover table-bordered'>
		<thead>
			<tr>
				<th>id</th>
				<th>Name</th>
				<th class="hideble"><span>Username</span></th>
				<th>Group</th>
				<th>Email</th>
				<th>Contact</th>
				<th>Location</th>
				<th>Is Active</th>
				<th colspan = 4>Actions</th>
			</tr>
		</thead>

		<tbody class = 'search-table'>
		@if($arr['count'])
			<?php $i = 1; ?>
				<tr>
					{{-- think of the issue when joins are used --}}
					<td class="col-xs-2"><input type = 'text' class = 'search_column col-xs-2'  id = '1'><input type = 'hidden' class = 'field_name' value = 'id'></td>
					<td><input type = 'text' class = 'search_column'  id = '2'><input type = 'hidden' class = 'field_name' value = 'name'></td>
					<td><input type = 'text' class = 'search_column'  id = '3'><input type = 'hidden' class = 'field_name' value = 'username'></td>
					<td><input type = 'text' class = 'search_column'  id = '4'><input type = 'hidden' class = 'field_name' value = 'group_name'></td>
					<td><input type = 'text' class = 'search_column'  id = '5'><input type = 'hidden' class = 'field_name' value = 'email'></td>
					<td><input type = 'text' class = 'search_column'  id = '6'><input type = 'hidden' class = 'field_name' value = 'contact'></td>
					<td><input type = 'text' class = 'search_column'  id = '7'><input type = 'hidden' class = 'field_name' value = 'location'></td>
					<td><input type = 'text' class = 'search_column'  id = '8'><input type = 'hidden' class = 'field_name' value = 'is_active'></td>
				</tr>
				@foreach($arr['data'] as $data)
					<tr>
						<td><input type = 'checkbox' class = 'checkbox_id' value = '{{$data->id}}'>{{$i}}</td>
						<td>{{$data->name}}</td>
						<td>{{$data->username}}</td>
						<td>{{$data->group_name}}</td>
						<td>{{$data->email}}</td>
						<td>{{$data->contact}}</td>
						<td>{{$data->address}}</td>
						<td>{{$data->is_active}}</td>
						@if(!$data->temp_permission)
						<td><a href = "{{URL::route('set-temporary-permissions').'?admin_id='.$data->id}}">Set Permission</a></td>
						@else
						<td><a href = "{{URL::route('edit-temporary-permissions', $data->id)}}">Edit Permission</a></td>
						@endif
						<td><a href = "{{URL::route('set-temporary-permissions').'?admin_id='.$data->id}}">Set Permission</a></td>
					</tr>
					<?php $i++; ?>
				@endforeach
		@else
					<tr>
						<td>{{$arr['message']}}</td>
					</tr>
		@endif
		</tbody>
	</table>

	{{Form::token()}}

	<div class = 'paginate'>
		@if($arr['count'])
			{{$arr['data']->appends($queryString)->links()}}
		@endif
	</div>

</div>

@stop
