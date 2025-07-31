<?php

namespace App\Models\Master\Customers;

use App\Models\Tier;
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
    ];

    public function tier()
    {
        return $this->belongsTo(Tier::class, 'tier_id');
    }
}
