<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'machine',
        'file_type',
    ];
}
