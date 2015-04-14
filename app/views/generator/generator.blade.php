@extends('layouts.main')

		
@section('custom')
	<script src = "{{ asset('generator/js/generator.js') }}" type = "text/javascript"></script>
@stop

@section('content')

<div class = "containter">

	<form method = 'post' action = "{{URL::to('/generate-post')}}">
		<div class = "container">
			<div class = "form-row">
				Module Name : <input type = "text" name = "module_name" id = "module_name"><span>Requires Authentication ? <input type = "radio" name = "authentication" value = "0" checked>No<input type = "radio" name = "authentication" value = "1">Yes</span> 
			</div>

			<div class = "form-row">
				Table Name : <input type = "text" name = "table_name" id = "table_name">
			</div>

			<div class = "form-row">
				Fields : <div class = "fields"></div><br>
				<div><input type = "text" name = "field_name" id = "field_name"><input type = "button" class = "btn btn-info" id = "addField" value = "Add Field" disabled></div>
			</div>
			
			<div class = "form-row">
				Fillable: <div class = "fillables"></div>
			</div>
			
			<div class = "form-row">
				Show In List: <div class = "showInLists"></div>
			</div>

			<div class = "form-row">
				Show In Input Form: <div class = "showInInputForms"></div>
			</div>

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
				<input type = "submit" value = "generate" class = "btn btn-default" id = "generate">
			</div>
		</div>
	</form>

</div>

@stop