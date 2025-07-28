<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GlassType extends Model
{
    use HasFactory;

    protected $table = 'elitevw_sr_glass_type';

    protected $fillable = [
        'option_group_id',
        'name',
        'prices', // stored as JSON
    ];

    protected $casts = [
        'prices' => 'array',
];


    public function group()
    {
        return $this->belongsTo(FormOptionGroup::class, 'option_group_id');
    }
}
