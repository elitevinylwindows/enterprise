<?php

namespace App\Models\Master\Prices;

use Illuminate\Database\Eloquent\Model;

class TaxCode extends Model
{
    protected $table = 'elitevw_master_prices_tax_codes';

    protected $fillable = [
        'code',
        'city',
        'description',
        'rate',
    ];
}
