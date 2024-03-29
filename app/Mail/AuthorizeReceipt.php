<?php

namespace App\Mail;

use App\Document;
use App\Traits\GetPDFTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthorizeReceipt extends Mailable
{
    use Queueable, SerializesModels;
    use GetPDFTrait;

    public $subject = "Su recibo de gas esta listo";
    public $document;

    /**
     * Create a new message instance.
     *
     * @param $document
     */
    public function __construct(Document $document)
    {
        return $this->document = $document;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.AuthorizeReceipt',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return \Illuminate\Mail\Mailables\Attachment[]
     */
    public function attachments()
    {
        $pdf = $this->generarPDF($this->document);
        Storage::put('/pdf/' . $this->document->reference . '.pdf', $pdf->output());

        return [
            Attachment::fromStorage('/pdf/'. $this->document->reference . '.pdf')
            ->withMime('application/pdf'),
        ];
    }
}
