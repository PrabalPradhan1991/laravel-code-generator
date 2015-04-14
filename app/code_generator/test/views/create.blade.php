@extends('layouts.main')

@section('custom')
<script src = "{{asset('backend-js/validation.js')}}" type = "javascript/text"></script>
@stop

@section('content')

@include('test.views.script')

<div class = 'container'>
	<form method = "post" action = "{{URL::route('test-create-post')}}"  class = "form-horizontal">
	<input type = "hidden" id = "url" value = "{{URL::route('test-create-post')}}">
		<div class = 'form-group @if($errors->has("check_check")) {{"has-error"}} @endif'>
			<label for = 'check_check'  class = 'control-label col-xs-2'>Check_check :</label><br>
				<div class = 'col-xs-10'>
			<input type = 'text' name = 'check_check' value= '{{ (Input::old('check_check')) ? (Input::old('check_check')) : '' }}' class = 'form-control'><span class = 'help-block'>@if($errors->has('check_check')) {{$errors->first('check_check')}} @endif</span>
				</div>
		</div>
		<input type = 'hidden' name = 'is_active' value = '1'>
		<div class = 'form-row'>
			<div class='col-xs-offset-2 col-xs-10'>
			{{Form::token()}}
				<span><input type = 'submit' value = 'create' class = 'btn btn-default'></span><span><input type = 'submit' class = 'addNew btn btn-default' value = 'Create & Add New'></span><span><a href = '{{URL::route('test-list')}}' class = 'btn btn-default'>Cancel</a></span>
			</div>
		</div>
	</form>
</div>

@stop
