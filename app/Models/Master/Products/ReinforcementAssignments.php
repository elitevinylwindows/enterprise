<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class ReinforcementAssignments extends Model
{
    protected $table = 'elitevw_master_products_reinforcement_assignments';

    protected $fillable = ['name', 'description'];
}
