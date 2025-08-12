<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $pdfPath;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $pdfPath)
    {
        $this->order = $order;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Order #'.$this->order->order_number.' Elite Vinyl Windows',
        );
    }

    
    public function build()
    {
        $email = $this->subject('Order #'.$this->order->order_number.' Elite Vinyl Windows')
            ->view('email.order_email')
            ->with([
                'order' => $this->order,
                'name' => $this->order->customer_name,
            ]);

        if ($this->pdfPath && Storage::disk('public')->exists($this->pdfPath)) {
            $email->attachFromStorageDisk(
                'public',
                $this->pdfPath,
                'Order_'.$this->order->order_number.'.pdf',
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
                ->as('Order_'.$this->order->order_number.'.pdf')
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
