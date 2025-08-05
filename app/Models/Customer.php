<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'elitevw_master_customers';

    protected $fillable = [
        'customer_number',
        'name',
        'tier_id',
        'loyalty_credit',
        'total_spent',
        'email',
        'status',
        'street',
        'city',
        'zip',
        'billing_address',
        'billing_city',
        'billing_zip',
        'billing_state',
        'billing_zip',
        'billing_country',
        'billing_phone',
        'billing_fax',
        'delivery_address',
        'delivery_city',
        'delivery_zip',
        'delivery_state',
        'delivery_zip',
        'delivery_country',
        'delivery_phone',
        'delivery_fax',
        'serve_customer_id',
        'customer_name'
    ];

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'tier_id');
    }

}
