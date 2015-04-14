<!DOCTYPE  HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>@yield('title')</title>
		<meta name = "viewport" content="width=device-width, initial-scale=1.0">
		<link href = "{{ asset('public/css/bootstrap3.2.0/css/bootstrap.css') }}" rel = "stylesheet">
		<link href = "{{ asset('public/css/styles.css') }}" rel = "stylesheet">

		@yield('custom-css')
		<style>
	
		 body{
			/*background: url("{{asset('public/img/background2.jpg')}}");*/
		} 
		</style>
		 <script src="{{ asset('admin/assets/js/jquery.metisMenu.js') }}"></script>
		<script src = "{{ asset('public/js/jquery.js') }}" type = "text/javascript"></script>
		<script src = "{{ asset('public/css/bootstrap3.2.0/js/bootstrap.js') }}" type = "text/javascript"></script>
		<script src = "{{ asset('backend-js/remove-global.js') }}" type = "text/javascript"></script>
		
		<script src = "@yield('custom-js')" type = "text/javascript"></script>
		
		@yield('custom')

		
	</head>

	<body>
	@include('include.navbar')
	@yield('navbar')
	
	<div class = "global">
		@if(Session::has('global'))
		<div class = "alert alert-danger alert-dissmissable">
			<button type = "button" class = "close" data-dismiss = "alert">X</button>
			<input type = "hidden" class = "global-remove-url" value = "{{URL::route('remove-global')}}">
			{{ Session::get('global') }}
		</div>
		@endif
	</div>
	<div id = "box"><!-- this for dialogue box -->

	</div>

	@yield('content')
	

	@include('include.footer')
		
	@yield('footer-js')
	
	</body>

</html>