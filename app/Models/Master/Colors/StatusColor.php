<?php

namespace App\Models\Master\Colors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusColor extends Model
{
    use HasFactory, SoftDeletes;

    // Adjust if your table name differs
    protected $table = 'elitevw_master_colors_status_colors';

    protected $fillable = [
        'color_code',   // HEX like #FF0000
        'department',   // e.g., Glass, Frame, Shipping
        'status',       // free text e.g., Queued, On Hold
        'status_abbr',  // e.g., Q, OH
    ];

    /**
     * Normalize HEX (# + uppercase) whenever set.
     */
    public function setColorCodeAttribute($value): void
    {
        $v = strtoupper(ltrim((string) $value, '#'));
        $this->attributes['color_code'] = '#'.$v;
    }
}
