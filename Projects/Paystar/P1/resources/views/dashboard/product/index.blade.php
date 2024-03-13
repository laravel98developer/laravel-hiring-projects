@extends('layouts.app')

@section('content')
    <div class="row">

        @foreach ($products as $product)
            <div class="col-sm-6 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <h4>{{ number_format($product->price) }} تومان</h4>
                        <a href="{{ route('order.index',$product->id) }}" class="btn btn-primary">خرید</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
