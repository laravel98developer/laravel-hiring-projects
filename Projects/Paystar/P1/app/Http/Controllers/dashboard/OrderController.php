<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Services\Payment\PayStar;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($product_id)
    {
        $product = Product::find($product_id);
        return view('dashboard.order.index',compact('product'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'product_id'    => ['required','numeric'],
            'card_number' => ['required','numeric'],
        ]);

        if ( auth()->user()->BankInfo->card_number != $request->card_number ) {
            return back()->with('conflict-card-number','conflict-card-number');
        }

        $order = new Order;
        $order->user_id    = auth()->user()->id;
        $order->product_id = $request->product_id;
        $order->save();

        $product = Product::find($request->product_id);

        $payStar = new PayStar;
        $payStar_create = $payStar->create($product->price,$order->id);

        if ( $payStar_create['status'] != 1 ) {
            return back();
        }

        $token = $payStar_create['data']['token'];

        $payment = new Payment;
        $payment->user_id          = auth()->user()->id;
        $payment->order_id         = $order->id;
        $payment->amount           = $product->price;
        $payment->token            = $token;
        $payment->ref_num          = $payStar_create['data']['ref_num'];
        $payment->tracking_code    = null;
        $payment->card_number      = null;
        $payment->transaction_id   = null;
        $payment->status           = 0;
        $payment->bank_first_data  = json_encode($payStar_create);
        $payment->bank_second_data = null;
        $payment->done             = 0;
        $payment->save();

        return redirect()->to("https://core.paystar.ir/api/pardakht/payment?token=$token");
    }
}
