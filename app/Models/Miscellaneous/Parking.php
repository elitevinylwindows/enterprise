<?php
// app/Models/Miscellaneous/Parking.php

namespace App\Models\Miscellaneous;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $table = 'elitevw_miscellaneous_parking';

    protected $fillable = [
        'user_id',
        'spot',
        'notes',
        'wheelchair', // <-- use this column name
    ];

    protected $casts = [
        'wheelchair' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
