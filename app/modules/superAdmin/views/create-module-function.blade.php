@extends('layouts.main')

		
@section('custom')
	<script src = "{{ asset('admin-js/route-generate.js') }}" type = "text/javascript"></script>
@stop

@section('content')

<div class = "container">
	<h3>{{$module_name}}</h3>
	<h3>{{$controller_name}}</h3>
</div>

<div class = "containter">
	
	<form method = 'post' action = "{{URL::route('create-module-function-post', $controller_id)}}">
		
		<input type = "hidden" name = "module_name" value = "{{$module_name}}">
		<input type = "hidden" name = "controller_name" value = "{{$controller_name}}">
		
		<div class = "container">
		

			<div class = "form-row">
				<table class = "table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>Url</th>
							<th>Function Name</th>
							<th>Route Name</th>
							<th>Blank</th>
						</tr>
					</thead>
					<tbody id = "addfunctiontable">
						
					</tbody>
				</table>

				<table class = "table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>Url</th>
							<th>Function Name</th>
							<th>Route Name</th>
							<th>Route Type</th>
							<th>Button</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type = "text" name = "url_name" class = "url_name"></td>
							<td><input type = "text" name = "function_name" class = "function_name"></td>
							<td><input type = "text" name = "route_name" class = "route_name"></td>
							<td><input type = "text" name = "route_type_name" class = "route_type_name" value = "get"></td>
							<td><input type = "button" class = "add_button btn btn-default" value = "Add Function" id = "addFunction"></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class = "form-row">
				<input type = "hidden" name = "controller_id" value = '{{$controller_id}}'>
				{{Form::token()}}<input type = "submit" value = "generate" class = "btn btn-default" id = "generate">
			</div>
		</div>
	</form>

</div>

@stop