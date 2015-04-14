@extends('layouts.main')

@section('content')
<p>Welcome {{ Auth::admin()->user()->name }},</p>
@stop