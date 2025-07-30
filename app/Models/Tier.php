<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    
    protected $table = 'elitevw_sr_tiers'; 

    protected $fillable = [
        'name',
        'benefits',
        'sort_order',
        'percentage',
    ];

    public function getPercentageAttribute($value)
    {
        return number_format($value, 2) ?? 0; // Ensure percentage is always a number
    }
}
