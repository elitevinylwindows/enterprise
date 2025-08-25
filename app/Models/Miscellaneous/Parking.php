<?php

namespace App\Models\Miscellaneous;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $table = 'elitevw_miscellaneous_parking';

    protected $fillable = [
        'user_id',
        'spot',
        'notes',
        'wheelchair',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
