@extends('layouts.main')

@section('content')

<div class = 'container'>
	<span><a class = 'btn btn-default' href = '{{URL::route("create-group")}}'>Create New</a></span>
</div>

<div class = "container">
	<table class = "table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th>id</th>
				<th>Group Name</th>
				<th colspan = "1">Actions</th>
			</tr>
		</thead>
		
			<tbody>
			@if($arr['count'])
			<?php $i = 1; ?>
				@foreach($arr['data'] as $data)
				<tr>
					<td>{{$i}}</td>
					<td>{{$data->group_name}}</td>
					<td><a href = "{{URL::route('edit-group', $data->id)}}">edit</a></td>
				</tr>
				<?php $i++; ?>
				@endforeach
			@else
				<tr>
					<td colspan = "6">$arr['message']</td>
				</tr>
			@endif
			</tbody>
	</table>
<!--
	<div class = "paginate">
		@if($arr['count'])
			{{-- $arr['data']->links() --}}
		@endif
	</div> -->
</div>

@stop