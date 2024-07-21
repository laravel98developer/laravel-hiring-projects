@extends('layout')

@section('title')
<title>Home</title>
@endsection

@section('content')
<div class="grid grid-cols-4 gap-4 py-10">
    <div class="col-span-3 grid grid-cols-1">
        @include('vendor.list', ['articles' => $articles])

    </div>
    @include('vendor.sidebar')
</div>
@endsection
