<?php

namespace App\Listeners;

use App\Events\EmailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EmailEvent $event): void
    {
        foreach ($event->emails as $email){
            if (filter_var($email,FILTER_VALIDATE_EMAIL)){
                Mail::to($email)->send($event->content);
            }
        }
    }
}
