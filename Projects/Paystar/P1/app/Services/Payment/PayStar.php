<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Http;

class PayStar
{

    private $gateway_token;
    private $encryption_key;
    private $callback;

    public function __construct()
    {
        $this->gateway_token = config('payment.gateway_token');
        $this->encryption_key = config('payment.encryption_key');
        $this->callback = route('payment-callback');
    }

    public function create($amount, $order_id)
    {
        $header = array(
            'Authorization' => 'Bearer ' . $this->gateway_token,
            'Content-Type' => 'application/json',
        );

        $data = [
            "amount" => (int)$amount * 10,
            "order_id" => $order_id,
            "callback" => $this->callback,
            "sign" => $this->createSign($amount, $order_id),
        ];

        $response = Http::withoutVerifying()->withHeaders($header)->post('https://core.paystar.ir/api/pardakht/create', $data);

        return $response->json();
    }


    public function verify($amount, $order_id)
    {
        $header = array(
            'Authorization' => 'Bearer ' . $this->gateway_token,
            'Content-Type' => 'application/json',
        );

        $data = [
            "amount" => (int)$amount * 10,
            "order_id" => $order_id,
            "callback" => $this->callback,
            "sign" => $this->createSign($amount, $order_id)
        ];

        $response = Http::withoutVerifying()->withHeaders($header)->post('https://core.paystar.ir/api/pardakht/create', $data);

        return $response;
    }


    public function createSign($amount, $order_id)
    {
        $data = (int)$amount * 10 . "#$order_id#" . $this->callback;
        return hash_hmac('sha512', $data, $this->encryption_key);
    }

    
    public function statusCodes($status_code)
    {
        switch ($status_code) {
            case 1:
                $description    = 'Ok';
                $description_fa = 'موفق';
                break;

            case -1:
                $description    = 'invalidRequest';
                $description_fa = 'درخواست نامعتبر (خطا در پارامترهای ورودی)';
                break;

            case -2:
                $description    = 'inactiveGateway';
                $description_fa = 'درگاه فعال نیست';
                break;

            case -3:
                $description    = 'retryToken';
                $description_fa = 'توکن تکراری است';
                break;

            case -4:
                $description    = 'amountLimitExceed';
                $description_fa = 'مبلغ بیشتر از سقف مجاز درگاه است';
                break;

            case -5:
                $description    = 'invalidRefNum';
                $description_fa = 'شناسه ref_num معتبر نیست';
                break;

            case -6:
                $description    = 'retryVerification';
                $description_fa = 'تراکنش قبلا وریفای شده است';
                break;

            case -7:
                $description    = 'badData';
                $description_fa = 'پارامترهای ارسال شده نامعتبر است';
                break;

            case -8:
                $description    = 'trNotVerifiable';
                $description_fa = 'تراکنش را نمیتوان وریفای کرد';
                break;

            case -9:
                $description    = 'trNotVerified';
                $description_fa = 'تراکنش وریفای نشد';
                break;

            case -98:
                $description    = 'paymentFailed';
                $description_fa = 'تراکنش ناموفق';
                break;

            case -99:
                $description    = 'error';
                $description_fa = 'خطای سامانه';
                break;
        }

        return compact('description', 'description_fa');
    }
}
