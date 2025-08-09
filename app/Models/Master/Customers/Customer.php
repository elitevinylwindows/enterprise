<?php

namespace App\Models\Master\Customers;

use App\Models\Tier;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'elitevw_master_customers';

    protected $fillable = [
        'customer_number',
        'customer_name',
        'loyalty_credit',
        'total_spent',
        'created_at',
        'updated_at',
        'status',
        'street',
        'zip',
        'city',
        'tier_id',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'billing_phone',
        'billing_fax',
        'delivery_address',
        'delivery_city',
        'delivery_state',
        'delivery_zip',
        'delivery_country',
        'delivery_fax',
        'delivery_phone',
        'email',
        'serve_customer_id'
    ];

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'tier_id');
    }
}
