@extends('layout.app')
@section('content')

<h1>Home :{{ Auth::user()->name}}</h1>

@endsection