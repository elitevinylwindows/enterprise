<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Purchasing\SupplierQuote;

class PurchaseRequestToSupplierMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;
    public $supplierName;
    public $url;


    public function build()
    {
        return $this->subject('Elite Vinyl Windows - PR #' . $this->quote->purchaseRequest->request_number)
                    ->markdown('email.purchase_request_email');
    }

    public function __construct(SupplierQuote $quote, $supplierName)
{
    if (!$quote || !$quote->secure_token) {
        throw new \Exception('SupplierQuote or secure_token is missing');
    }

    $this->quote = $quote;
    $this->supplierName = $supplierName;
    $this->url = route('supplier.pr.view', $quote->secure_token);
}

}
