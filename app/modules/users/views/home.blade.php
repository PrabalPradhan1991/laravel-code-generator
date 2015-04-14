@extends('layouts.main')

@section('content')
<p>Welcome {{ Auth::user()->user()->fname }},</p>
@stop