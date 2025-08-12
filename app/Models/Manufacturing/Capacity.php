<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capacity extends Model
{
    protected $fillable = [
        'description',
        'limit',
        'actual',
    ];
}
