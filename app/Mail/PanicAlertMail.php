<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PanicAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alertData;

    /**
     * Create a new message instance.
     *
     * @param array $alertData
     */
    public function __construct($alertData)
    {
        $this->alertData = $alertData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('🚨 EMERGENCY PANIC ALERT - Immediate Attention Required')
                    ->view('emails.panic-alert')
                    ->with('alertData', $this->alertData);
    }
}