@extends('acl::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('acl.name') !!}</p>
@endsection
