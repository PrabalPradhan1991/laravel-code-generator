@extends('layouts.main')

@section('custom')

<script src = "{{ asset('backend-js/deleteOrPurge.js') }}" type = "text/javascript"></script>

<script src = "{{ asset('backend-js/tableSearch.js') }}" type = "text/javascript"></script>

@stop

@section('content')

<div class = 'container'>
	<span><a class = 'btn btn-default' href = '{{URL::route('reservation-create')}}'>Create New</a></span><span><a class = 'btn btn-default' href = '{{URL::route('reservation-delete-post')}}' id = 'delete_selected'>Delete</a></span><span><a href = '{{URL::route('reservation-purge-post')}}' class = 'btn btn-default'  id = 'purge_selected'>Purge</a></span>
</div>

{{-- this block is for hidden values --}}
<input type = 'hidden' id = 'url' value = '{{URL::current()}}'>

<input type = 'hidden' value = '{{URL::current()}}' class = 'url'>

<div class = 'container'>
<span>Show :<a class = 'paginate_limit' href = '{{URL::current()}}?paginate=10'>10</a> / <a class = 'paginate_limit' href = '{{URL::current()}}?paginate=20'>20</a> / <a class = 'paginate_limit' href = '{{URL::current()}}?paginate=30'>30</a>
</div>

@include('include.modal')

@include('include.modal-selected')

<div class = 'container'>

<div style = 'overflow-x : auto'>
	<table class = 'table table-striped table-hover table-bordered'>
		<thead>
			<tr>
				<th>id</th>
				<th>reservation_name</th>
				<th>reservation_type</th>
				<th>reservation_location</th>
				<th>Is Active</th>
				<th colspan = 4>Actions</th>
			</tr>
		</thead>

		<tbody class = 'search-table'>
		@if($arr['count'])
			<?php $i = 1; ?>
				<tr>
					<td><input type = 'text' class = 'search_column'  id = '1'><input type = 'hidden' class = 'field_name' value = 'id'></td>
					<td><input type = 'text' class = 'search_column'  id = '2'><input type = 'hidden' class = 'field_name' value = 'reservation_name'></td>
					<td><input type = 'text' class = 'search_column'  id = '3'><input type = 'hidden' class = 'field_name' value = 'reservation_type'></td>
					<td><input type = 'text' class = 'search_column'  id = '4'><input type = 'hidden' class = 'field_name' value = 'reservation_location'></td>
					<td><input type = 'text' class = 'search_column'  id = '5'><input type = 'hidden' class = 'field_name' value = 'is_active'></td>
					<td colspan = 4></td>
				</tr>
				@foreach($arr['data'] as $data)
					<tr>
						<td><input type = 'checkbox' class = 'checkbox_id' value = '{{$data->id}}'>{{$i}}</td>
						<td>{{$data->reservation_name}}</td>
						<td>{{$data->reservation_type}}</td>
						<td>{{$data->reservation_location}}</td>
						<td>{{$data->is_active}}</td>
						<td><a href = "{{URL::route('reservation-view', $data->id)}}">view</a></td>
						<td><a href = "{{URL::route('reservation-edit', $data->id)}}">edit</a></td>
						<td><a class = 'delete' href = "{{URL::route('reservation-delete-post', array($data->id, $status))}}">delete</a></td>
						<td><a class = 'purge' href = "{{URL::route('reservation-purge-post', $data->id)}}">purge</a></td>
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

</div>
	{{Form::token()}}

	<div class = 'paginate'>
		@if($arr['count'])
			{{$arr['data']->appends($queryString)->links()}}
		@endif
	</div>

</div>

@stop
