@extends('layout')

@section('title')
<title>Category - {{ $category->name }}</title>
@endsection

@section('content')
<div class="grid grid-cols-4 gap-4 py-10">
    <div class="col-span-3 grid grid-cols-1">
        @include('vendor.list')
    </div>
    @include('vendor.sidebar')
</div>
@endsection