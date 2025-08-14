<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $table = 'elitevw_sales_invoice_payments';

    protected $fillable = [
        'invoice_id',
        'payment_type', // deposit or payments
        'deposit_type', // percent or fixed
        'deposit_method', // card, cash, bank
        'deposit_card_number',
        'deposit_card_cvv',
        'deposit_card_expiry',
        'deposit_card_zip',
        'payment_amount', // JSON array of payment amounts
        'payment_card_number', // JSON array of card numbers
        'payment_card_cvv', // JSON array of CVV codes
        'payment_card_expiry', // JSON array of expiry dates
        'payment_card_zip', // JSON array of ZIP codes
        'status', // pending, completed, failed,
        'fixed_amount',
        'amount_calculated', // calculated amount based on percentage or fixed amount
        'percentage', // percentage value for deposit
        'payment_bank_account',
        'payment_bank_routing',
        'payment_method',
        'gateway_response'
    ];

}
