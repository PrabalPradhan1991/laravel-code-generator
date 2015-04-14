@extends('layouts.main')

@section('custom')
<script src = "{{ asset('backend-js/validation.js') }}" type = "javascript/text"></script>
@stop

@section('content')

@include('reservation.views.script')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('reservation-create-post')}}"  class = "form-horizontal">
	<input type = "hidden" id = "url" value = "{{URL::route('reservation-create-post')}}">
		<div class = 'form-group @if($errors->has("reservation_name")) {{"has-error"}} @endif'>
			<label for = 'reservation_name'  class = 'control-label col-xs-2'>Reservation Name :</label>
				<div class = 'col-xs-10'>
			<input type = 'text' name = 'reservation_name' value= '{{ (Input::old('reservation_name')) ? (Input::old('reservation_name')) : '' }}' class = 'form-control'><span class = 'help-block'>@if($errors->has('reservation_name')) {{$errors->first('reservation_name')}} @endif</span>
				</div>
		</div>
		<div class = 'form-group @if($errors->has("reservation_type")) {{"has-error"}} @endif'>
			<label for = 'reservation_type'  class = 'control-label col-xs-2'>Reservation Type :</label>
				<div class = 'col-xs-10'>
			<input type = 'text' name = 'reservation_type' value= '{{ (Input::old('reservation_type')) ? (Input::old('reservation_type')) : '' }}' class = 'form-control'><span class = 'help-block'>@if($errors->has('reservation_type')) {{$errors->first('reservation_type')}} @endif</span>
				</div>
		</div>
		<div class = 'form-group @if($errors->has("reservation_location")) {{"has-error"}} @endif'>
			<label for = 'reservation_location'  class = 'control-label col-xs-2'>Reservation Location :</label>
				<div class = 'col-xs-10'>
			<input type = 'text' name = 'reservation_location' value= '{{ (Input::old('reservation_location')) ? (Input::old('reservation_location')) : '' }}' class = 'form-control'><span class = 'help-block'>@if($errors->has('reservation_location')) {{$errors->first('reservation_location')}} @endif</span>
				</div>
		</div>
		<input type = 'hidden' name = 'is_active' value = '1'>
		<div class = 'form-row'>
			<div class='col-xs-offset-2 col-xs-10'>
			{{Form::token()}}
				<span><input type = 'submit' value = 'create' class = 'btn btn-default'></span><span><input type = 'submit' class = 'addNew btn btn-default' value = 'Create & Add New'></span><span><a href = '{{URL::route('reservation-list')}}' class = 'btn btn-default'>Cancel</a></span>
			</div>
		</div>
	</form>
</div>

@stop
