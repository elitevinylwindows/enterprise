<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class SalesSetting extends Model
{
    protected $table = 'elitevw_sales_settings';

    protected $fillable = [
        'key',
        'value',
    ];

    public $timestamps = true;
}
