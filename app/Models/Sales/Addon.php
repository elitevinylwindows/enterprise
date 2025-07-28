<?php

namespace App\Models\Sales\Quotes;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $table = 'elitevw_master_addons';
    protected $fillable = ['group_name', 'option_label', 'fee'];
}
