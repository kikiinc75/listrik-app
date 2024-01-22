@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
    @php
        echo Auth::user()->name;
    @endphp
@stop

@section('content')
    <p>You are logged in!</p>
@stop
