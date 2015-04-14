@extends('layouts.main')

@section('custom')

<script src = "{{ asset('backend-js/deleteOrPurge.js') }}" type = "text/javascript"></script>

<script src = "{{ asset('backend-js/tableSearch.js') }}" type = "text/javascript"></script>

@stop

@section('content')

<div class = 'container'>
	<span><a class = 'btn btn-default' href = '{{URL::route('theatre-create')}}'>Create New</a></span><span><a class = 'btn btn-default' href = '{{URL::route('theatre-delete-post')}}' id = 'delete_selected'>Delete</a></span><span><a href = '{{URL::route('theatre-purge-post')}}' class = 'btn btn-default'  id = 'purge_selected'>Purge</a></span>
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
				<th>theatre_name</th>
				<th>location</th>
				<th>description</th>
				<th>Is Active</th>
				<th colspan = 4>Actions</th>
			</tr>
		</thead>

		<tbody class = 'search-table'>
		@if($arr['count'])
			<?php $i = 1; ?>
				<tr>
					<td><input type = 'text' class = 'search_column'  id = '1'><input type = 'hidden' class = 'field_name' value = 'id'></td>
					<td><input type = 'text' class = 'search_column'  id = '2'><input type = 'hidden' class = 'field_name' value = 'theatre_name'></td>
					<td><input type = 'text' class = 'search_column'  id = '3'><input type = 'hidden' class = 'field_name' value = 'location'></td>
					<td><input type = 'text' class = 'search_column'  id = '4'><input type = 'hidden' class = 'field_name' value = 'description'></td>
					<td><input type = 'text' class = 'search_column'  id = '5'><input type = 'hidden' class = 'field_name' value = 'is_active'></td>
					<td colspan = 4></td>
				</tr>
				@foreach($arr['data'] as $data)
					<tr>
						<td><input type = 'checkbox' class = 'checkbox_id' value = '{{$data->id}}'>{{$i}}</td>
						<td>{{$data->theatre_name}}</td>
						<td>{{$data->location}}</td>
						<td>{{$data->description}}</td>
						<td>{{$data->is_active}}</td>
						<td><a href = "{{URL::route('theatre-view', $data->id)}}">view</a></td>
						<td><a href = "{{URL::route('theatre-edit', $data->id)}}">edit</a></td>
						<td><a class = 'delete' href = "{{URL::route('theatre-delete-post', array($data->id, $status))}}">delete</a></td>
						<td><a class = 'purge' href = "{{URL::route('theatre-purge-post', $data->id)}}">purge</a></td>
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
