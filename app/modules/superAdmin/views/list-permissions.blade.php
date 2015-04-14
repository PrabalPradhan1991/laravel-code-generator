@extends('layouts.main')

@section('content')
<div class = "container">
	<h1>{{$controller_name}}</h1>
</div>

<div class = "container">
	<a href = "{{URL::route('list-modules')}}" class = "btn btn-info">Go Back To Modules List</a>
</div>

<div class = "container">
	<table class = "table table-striped table-hover table-bordered">
		<thead>
			<tr>
				<th>id</th>
				<th>Function code</th>
				<th colspan = "1">Permissions</th>
			</tr>
		</thead>
		
		
			<tbody>
			<form method = "post" action ="{{URL::route('edit-permissions-post', $controller_id)}}">
				@if($arr['count'])
				<?php $i = 1; ?>
					@foreach($arr['data'] as $data)
					<tr>
						<td>{{$i}}</td>
						<td>{{$data->module_function_code}}</td>
						<td>
								<?php $temps = $groups; ?>
								@if(count($data->permissions))
									
									@foreach($data->permissions as $permission)
										<?php $allowedGroups = HelperController::getAllowedGroups($permission->allowed_groups); ?>
										<input type = "hidden" name = "_route_names{{$permission->module_function_code_id}}" value = "{{$permission->module_function_code_id}}">
										@foreach($allowedGroups as $allowedGroup)
											<span><input type = "checkbox" name = "{{$permission->module_function_code_id.'-'.$allowedGroup}}" value = "{{$allowedGroup}}" checked>{{$temps[$allowedGroup]}}</span>
											<?php unset($temps[$allowedGroup]); ?>
										@endforeach
									@endforeach
								@endif
									
								@foreach($temps as $temp => $val)
									<input type = "hidden" name = "_route_names{{$data->id}}" value = "{{$data->id}}">
									<span><input type = "checkbox" name = "{{$data->id.'-'.$temp}}" value = "{{$temp}}">{{$val}}</span>
								@endforeach
						</td>
					</tr>
					<?php $i++; ?>
					@endforeach
				@else
					<tr>
						<td colspan = "6">{{$arr['message']}}</td>
					</tr>
				@endif
					<tr>
						<td colspan = "3">{{Form::token()}}<input type = "submit" class = "btn btn-info" value = "Set Permission"></td>
					</tr>
			</form>
			</tbody>
	</table>

	<div class = "paginate">
		@if($arr['count'])
			{{--$arr['data']->links()--}}
		@endif
	</div>

	<div class = "container">
		<div class= "errors">
			@if(Session::has('errors'))
				@if(Session::get('errors') != '[]')
					{{Session::get('errors')}}
				@endif
			@endif
		</div>
	</div>
</div>
@stop