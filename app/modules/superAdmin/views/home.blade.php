@extends('layouts.main')

@section('content')
<p>Welcome {{ Auth::superAdmin()->user()->name }},</p>
<p>Controller</p>
<p>Group</p>
<p>Admins Display</p>
@stop