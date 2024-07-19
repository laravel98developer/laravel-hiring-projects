<?php

namespace App\Jobs;

use App\Services\SmsService\SmsServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private string $recipient, private string $message, private SmsServiceInterface $smsService)
    {
        $this->onQueue('transfer');
    }

    public function handle(): void
    {
        $this->smsService->sendSms($this->recipient, $this->message);
    }
}
