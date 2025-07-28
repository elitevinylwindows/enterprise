<?php

namespace App\Models\Master\Prices;

use Illuminate\Database\Eloquent\Model;

class Matrice extends Model
{
    protected $table = 'elitevw_master_price_price_matrices';

    protected $fillable = [
        'series_id',
        'series_type_id',
        'width',
        'height',
        'price',
    ];
}
