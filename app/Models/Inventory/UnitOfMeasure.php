<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends Model
{
    protected $table = 'unit_of_measures';
    protected $fillable = ['name', 'short_code', 'status'];
}
