<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    
    public function deliveries()
{
    return $this->hasMany(\App\Models\Delivery::class, 'truck_id');
}

    protected $table = 'elitevw_sr_trucks'; // Specify correct table name

    protected $fillable = [
        'truck_number',
        'model',
        'capacity',
        'license_plate',
    ];
}

