<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    protected $table = 'elitevw_sr_formulas';

    protected $fillable = [
        'key_name',
        'percentage',
    ];
}
