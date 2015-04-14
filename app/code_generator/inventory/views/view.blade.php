@extends('layouts.main')

@section('content')

<div class = 'container'>
	<table class = "table table-striped table-hover table-bordered">
		<tbody>
		<tr>
			<th>Inventory Name :</th>
			<td>{{$data->inventory_name}}</td>
		</tr>
		<tr>
			<th>Inventory Price :</th>
			<td>{{$data->inventory_price}}</td>
		</tr>
		<tr>
			<th>Inventory Stock :</th>
			<td>{{$data->inventory_stock}}</td>
		</tr>
		<tr>
			<th>Is Actvie:</th>
			<td>{{$data->is_active}}</td>
		</tr>
		<tr>
			<td colspan = '2'><a href = "{{URL::route('inventory-list')}}" class = "btn btn-default">Go Back To List</a></td>
		</tr>
		</body>
	</table>
</div>

@stop

