<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Sms;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $mobiles;
    protected $message;
    /**
     * Create a new job instance.
     */
    public function __construct($mobiles, $message)
    {
        $this->mobiles = $mobiles;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sms = new Sms();
        $sms->send($this->mobiles, $this->message);
    }
}
