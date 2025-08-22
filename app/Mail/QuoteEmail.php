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
use Illuminate\Support\Facades\Storage;

class QuoteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $quote, $pdfPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quote, $pdfPath = null)
    {
        $this->quote = $quote;
        $this->pdfPath = $pdfPath;
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

        if ($this->pdfPath && Storage::disk('public')->exists($this->pdfPath)) {
            $email->attachFromStorageDisk(
                'public',
                $this->pdfPath,
                'Quote_'.$this->quote->quote_number.'.pdf',
                [
                    'mime' => 'application/pdf'
                ]
            );
        }

        return $email;
    }

    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->pdfPath && Storage::disk('public')->exists($this->pdfPath)) {
            $fullPath = Storage::disk('public')->path($this->pdfPath);
            
            $attachments[] = Attachment::fromPath($fullPath)
                ->as('Quote_'.$this->quote->quote_number.'.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }

    private function getMimeTypeForExtension(string $extension, $file): string
    {
        return match ($extension) {
            'dst' => 'application/x-dst',
            'emb' => 'application/x-emb',
            'pdf' => 'application/pdf',
            default => $file->getMimeType(), // Fallback to Laravel's MIME type detection
        };
    }
}
