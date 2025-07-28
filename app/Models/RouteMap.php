<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteMap extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name',
        'start_location',
        'end_location',
    ];
}
