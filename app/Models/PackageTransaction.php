<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'subscription_transactions_id',
        'amount',
        'transaction_id',
        'payment_status',
        'payment_type',
        'receipt',
        'holder_name',
        'card_number',
        'card_expiry_month',
        'card_expiry_year',
    ];

    public static function transactionData($paymentData)
    {
        return PackageTransaction::create(
            [
                'user_id' =>  isset($paymentData['user_id'])?$paymentData['user_id']:parentId(),
                'holder_name' =>  isset($paymentData['holder_name'])?$paymentData['holder_name']:null,
                'subscription_transactions_id' =>  isset($paymentData['subscription_transactions_id'])?$paymentData['subscription_transactions_id']:null,
                'subscription_id' => isset($paymentData['subscription_id'])?$paymentData['subscription_id']:null,
                'amount' => isset($paymentData['amount'])?$paymentData['amount']:0,
                'transaction_id' => isset($paymentData['transaction_id']) ? $paymentData['transaction_id'] : null,
                'payment_status' => isset($paymentData['status']) ? $paymentData['status'] : 'Success',
                'payment_type' => isset( $paymentData['payment_type'])? $paymentData['payment_type']:null,
                'receipt' => isset($paymentData['receipt_url']) ? $paymentData['receipt_url'] : null,
                'card_number' => isset($paymentData['payment_method_details']['card']['last4']) ? $paymentData['payment_method_details']['card']['last4'] : '',
                'card_expiry_month' => isset($paymentData['payment_method_details']['card']['exp_month']) ? $paymentData['payment_method_details']['card']['exp_month'] : '',
                'card_expiry_year' => isset($paymentData['payment_method_details']['card']['exp_year']) ? $paymentData['payment_method_details']['card']['exp_year'] : '',
            ]
        );

    }

    public function users()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function subscriptions()
    {
        return $this->hasOne('App\Models\Subscription','id','subscription_id');
    }
}
