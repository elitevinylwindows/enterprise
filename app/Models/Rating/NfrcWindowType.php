<?php

namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NfrcWindowType extends Model
{
    protected $table = 'elitevw_rating_window_types';   // ✅ prefixed table
    protected $fillable = ['name','slug'];

    public function productLines(): HasMany
    {
        return $this->hasMany(NfrcProductLine::class, 'window_type_id');
    }
}
