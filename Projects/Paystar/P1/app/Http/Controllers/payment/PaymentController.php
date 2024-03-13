<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payment\PayStar;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if (Payment::where(['ref_num' => $request->ref_num, 'order_id' => $request->order_id])->doesntExist()) {
            abort(404);
        }

        $payment = Payment::where(['ref_num' => $request->ref_num, 'order_id' => $request->order_id])->first();

        if ($payment->done == 1) {
            $data = [
                'status' => 'success',
                'message' => 'این تراکنش قبلا با موفقیت انجام شده است',
            ];
            return view('payment.index', compact('data'));
        }

        $payment->update([
            'tracking_code' => $request->tracking_code,
            'card_number' => $request->card_number,
            'transaction_id' => $request->transaction_id,
            'status' => $request->status,
            'bank_second_data' => json_encode($request->all()),
            'done' => ($payment->status == 1 ? 1 : 0),
        ]);

        if ($request->status == 1) {
            $data = [
                'status' => 'success',
                'message' => 'تراکنش با موفقیت انجام شد',
            ];
        } else {
            $payStar = new PayStar;
            $status_code = $payStar->statusCodes($request->status);
            $data = [
                'status' => 'error',
                'message' => $status_code['description_fa'],
            ];
        }

        return view('payment.index', compact('data'));
    }
}
