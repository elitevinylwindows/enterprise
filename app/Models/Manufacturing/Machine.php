<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'elitevw_manufacturing_machines';

    protected $fillable = [
        'machine',
        'file_type',
    ];
}
