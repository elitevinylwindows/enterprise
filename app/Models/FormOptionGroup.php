<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormOptionGroup extends Model
{
protected $table = 'elitevw_sr_form_option_groups';

   protected $fillable = [
        'name',
        'condition',
        'created_at',
        'updated_at'
    ];

   public function options()
{
    return $this->hasMany(FormOption::class, 'group_id');
}
public function reinforcements()
{
    return $this->hasMany(ReinforcementOption::class, 'option_group_id');
}


}
