<?php

namespace App\Models\Master\ProductKeys;

use Illuminate\Database\Eloquent\Model;

class SpecialShapeMacro extends Model
{
    protected $table = 'elitevw_master_productkeys_specialshapemacros';

    protected $fillable = ['type', 'name', 'description'];
}
