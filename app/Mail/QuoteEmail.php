<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class QuoteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $quote, $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quote, $pdf = null)
    {
        $this->quote = $quote;
        $this->pdf = $pdf;
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function build()
    {
        $email = $this->subject('Quote #'.$this->quote->quote_number.' Elite Vinyl Windows')
            ->view('email.quotes.quote_email')
            ->with([
                'quote' => $this->quote,
                'name' => $this->quote->customer->customer_name,
                'url' => route('quote.request.show', ['token' => Crypt::encryptString($this->quote->id)]),
            ]);

        // if ($this->pdf) {
        //     $email->attachData(
        //         $this->pdf->output(),
        //         "Quote_{$this->quote->id}.pdf",
        //         [
        //             'mime' => 'application/pdf',
        //             'as' => "Quote_{$this->quote->id}.pdf",
        //             'disposition' => 'attachment'
        //         ]
        //     );
        // }

        return $email;
    }

    // public function attachments(): array
    // {
    //     $attachments = [];
   
    //     $extension = strtolower($this->pdf->getClientOriginalExtension());
    //     $mimeType = $this->getMimeTypeForExtension($extension, $this->pdf);

    //     $attachments[] = Attachment::fromPath($this->pdf->getRealPath())
    //         ->as($this->pdf->getClientOriginalName())
    //         ->withMime($mimeType);
    

    //     return $attachments;
    // }

    // private function getMimeTypeForExtension(string $extension, $file): string
    // {
    //     return match ($extension) {
    //         'dst' => 'application/x-dst',
    //         'emb' => 'application/x-emb',
    //         'pdf' => 'application/pdf',
    //         default => $file->getMimeType(), // Fallback to Laravel's MIME type detection
    //     };
    // }
}
