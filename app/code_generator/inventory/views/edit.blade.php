@extends('layouts.main')

@section('content')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('inventory-edit-post', $data->id)}}"></td>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>inventory_name</th>
			<td><input type = 'text' name = 'inventory_name' value = '{{$data->inventory_name}}'><span class = 'form-error'>@if($errors->has('inventory_name')) {{ $errors->first('inventory_name') }} @endif</span></td>
		</tr>
		<tr>
			<th>inventory_price</th>
			<td><input type = 'text' name = 'inventory_price' value = '{{$data->inventory_price}}'><span class = 'form-error'>@if($errors->has('inventory_price')) {{ $errors->first('inventory_price') }} @endif</span></td>
		</tr>
		<tr>
			<th>inventory_stock</th>
			<td><input type = 'text' name = 'inventory_stock' value = '{{$data->inventory_stock}}'><span class = 'form-error'>@if($errors->has('inventory_stock')) {{ $errors->first('inventory_stock') }} @endif</span></td>
		</tr>
		<tr>
			<th>Is Active</th>
			<td><span><input type = 'radio' name = 'is_active' value = '1' @if($data->is_active == 1) {{'checked'}} @endif>Yes</span><span><input type = 'radio' name = 'is_active' value = '0' @if($data->is_active == 0) {{'checked'}} @endif>No</span>
		</tr>
		<tr>
			<td>{{Form::token()}}<input type = "submit" class = "btn btn-info" value = "edit"></td><td><a href = "{{URL::route('inventory-list')}}" class = "btn btn-default">Cancel</a></td>
		</tr>
		</body>
	</table>
	</form>
</div>

@stop

