@extends('layouts.main')

@section('custom')
<script src = "{{ asset('backend-js/validation.js') }}" type = "javascript/text"></script>
@stop

@section('content')

@include('inventory.views.script')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('inventory-create-post')}}"  class = "form-horizontal">
	<input type = "hidden" id = "url" value = "{{URL::route('inventory-create-post')}}">
		<div class = 'form-group @if($errors->has("inventory_name")) {{"has-error"}} @endif'>
			<label for = 'inventory_name'  class = 'control-label col-xs-2'>Inventory Name :</label>
				<div class = 'col-xs-10'>
			<input type = 'text' name = 'inventory_name' value= '{{ (Input::old('inventory_name')) ? (Input::old('inventory_name')) : '' }}' class = 'form-control'><span class = 'help-block'>@if($errors->has('inventory_name')) {{$errors->first('inventory_name')}} @endif</span>
				</div>
		</div>
		<div class = 'form-group @if($errors->has("inventory_price")) {{"has-error"}} @endif'>
			<label for = 'inventory_price'  class = 'control-label col-xs-2'>Inventory Price :</label>
				<div class = 'col-xs-10'>
			<input type = 'text' name = 'inventory_price' value= '{{ (Input::old('inventory_price')) ? (Input::old('inventory_price')) : '' }}' class = 'form-control'><span class = 'help-block'>@if($errors->has('inventory_price')) {{$errors->first('inventory_price')}} @endif</span>
				</div>
		</div>
		<div class = 'form-group @if($errors->has("inventory_stock")) {{"has-error"}} @endif'>
			<label for = 'inventory_stock'  class = 'control-label col-xs-2'>Inventory Stock :</label>
				<div class = 'col-xs-10'>
			<input type = 'text' name = 'inventory_stock' value= '{{ (Input::old('inventory_stock')) ? (Input::old('inventory_stock')) : '' }}' class = 'form-control'><span class = 'help-block'>@if($errors->has('inventory_stock')) {{$errors->first('inventory_stock')}} @endif</span>
				</div>
		</div>
		<input type = 'hidden' name = 'is_active' value = '1'>
		<div class = 'form-row'>
			<div class='col-xs-offset-2 col-xs-10'>
			{{Form::token()}}
				<span><input type = 'submit' value = 'create' class = 'btn btn-default'></span><span><input type = 'submit' class = 'addNew btn btn-default' value = 'Create & Add New'></span><span><a href = '{{URL::route('inventory-list')}}' class = 'btn btn-default'>Cancel</a></span>
			</div>
		</div>
	</form>
</div>

@stop
