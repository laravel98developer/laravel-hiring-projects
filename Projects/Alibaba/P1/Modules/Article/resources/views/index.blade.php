@extends('article::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('article.name') !!}</p>
@endsection
