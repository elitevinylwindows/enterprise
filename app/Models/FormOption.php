<?php

// app/Models/FormOption.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormOption extends Model
{
    protected $table = 'elitevw_sr_form_options';

    protected $fillable = [
        'group_id',
        'option_name',
        'sub_option',
        'is_default',
        'sort_order',
        'size_json',
        'thickness_json',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'size_json' => 'array',
        'thickness_json' => 'array',
    ];

  public function group()
{
    return $this->belongsTo(\App\Models\FormOptionGroup::class, 'group_id');
}

    
    protected $appends = ['group_name'];

public function getGroupNameAttribute()
{
    return optional($this->group)->name;
}


}
