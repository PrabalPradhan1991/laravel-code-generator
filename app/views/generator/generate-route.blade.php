@extends('layouts.main')

		
@section('custom')
	<script src = "{{ asset('generator/js/generator.js') }}" type = "text/javascript"></script>
@stop

@section('content')

<div class = "container">

<table class = "table table-bordered">
	<thead>
		<th>S.n.</th>
		<th>route</th>
		<th>route-name</th>
		<th>method</th>
		<th>function</th>
	</thead>
</table>

</div>

@stop