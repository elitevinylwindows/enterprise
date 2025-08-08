<?php

namespace App\Models\Master\Customers;

use App\Models\Tier;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'elitevw_master_customers';

    protected $fillable = [
        'customer_number',
        'email',
        'phone',
        'address',
        'name',
        'tier_id',
        'loyalty_credit',
        'total_spent',
        'serve_customer_id'
    ];

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'tier_id');
    }
}
