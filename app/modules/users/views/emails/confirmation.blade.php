@extends('layouts.main')

@section('content')

				<div class = 'container'>
					<div class = "panel panel-default">
						<div class = "panel-body">
							<div class = "page-header">
								<h3>This is confirmaition Email</h3>
							</div>

							<p>Hello {{$name}},
							<p>Please click on the link below to complete your registration</p>
							<p>
								{{$link}}
							</p>


						</div>
					</div>
				</div>

@stop