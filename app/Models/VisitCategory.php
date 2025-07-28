<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'fees',
    ];

    public static $types = [
        'Free' => 'Free',
        'Paid' => 'Paid',
    ];
}
