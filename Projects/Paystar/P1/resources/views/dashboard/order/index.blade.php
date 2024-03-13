@extends('layouts.app')

@section('content')
    <div class="container">

        <form action="{{ route('order.create') }}" method="post">
            <div class="row">

                @if (session()->has('conflict-card-number'))
                    <div class="alert alert-danger" role="alert">
                        شماره کارت وارد شده با شماره موجود در سیستم یکسان نیست
                    </div>
                @endif

                @csrf

                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="col-12 border">
                    <h3>مبلغ : {{ number_format($product->price) }} تومان</h3>
                    <div class="form-group mt-4 mb-4">
                        <label for="">شماره کارت</label>
                        <input name="card_number" type="text" class="form-control" placeholder="شماره کارت">
                        <div id="passwordHelpBlock" class="form-text">
                            <span class="text-danger">*</span>شماره کارت اعلامی باید دقیقا مطابق با شماره کارت هنگام پرداخت
                            باشد در غیر اینصورت تراکنش تایید نخواهد شد
                        </div>
                        <span class="error-handling text-danger">
                            @error('card_number')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <button class="btn btn-primary">پرداخت</button>
                </div>

            </div>
        </form>
    </div>
@endsection
