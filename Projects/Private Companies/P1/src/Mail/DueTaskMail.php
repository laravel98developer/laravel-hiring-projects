<?php

namespace AliSalehi\Task\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DueTaskMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Due Task Mail',
        );
    }
    
    public function build()
    {
        return $this->markdown("NDP::mail.email");
    }
}
