<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReinforcementOption extends Model
{
    protected $table = 'elitevw_sr_reinforcement_options';

    protected $fillable = [
        'option_group_id',
        'name',
        'size',
    ];


    public function group()
    {
        return $this->belongsTo(FormOptionGroup::class, 'option_group_id');
    }
}


