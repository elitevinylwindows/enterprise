<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;

class Capacity extends Model
{
    protected $fillable = [
        'description',
        'limit',
        'actual',
    ];
}
