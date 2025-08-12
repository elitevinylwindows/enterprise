<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;

class Capacity extends Model
{
    protected $table = 'elitevw_manufacturing_capacity';

    protected $fillable = [
        'description',
        'limit',
        'actual',
    ];
}
