<?php

namespace App\Jobs;

use App\Models\Card;
use Illuminate\Bus\Queueable;
use App\Notifications\SmsToClient;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Card $card;
    protected $amount;
    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct(Card $card, $amount, $message)
    {
        
        $this->card = $card;
        $this->amount = $amount;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        Notification::send($this->card->user, new SmsToClient($this->card, $this->amount, $message));
    }
}
