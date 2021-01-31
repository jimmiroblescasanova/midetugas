<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthorizeReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Su recibo de gas esta listo";
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @param $pdf
     */
    public function __construct($pdf)
    {
        return $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.AuthorizeReceipt')
            ->attachFromStorage('/pdf/'.$this->pdf.'.pdf');
    }
}
