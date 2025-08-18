<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'elitevw_sales_order_items';

    protected $fillable = [
        'order_id',
        'description',
        'width',
        'height',
        'glass',
        'grid',
        'qty',
        'price',
        'total',
        'retrofit_bottom_only',
        'no_logo_lock',
        'double_lock',
        'custom_lock_position',
        'custom_vent_latch',
        'internal_note',
        'item_comment',
        'checked_count',
        'color_config',
        'color_exterior',
        'color_interior',
        'frame_type',
        'fin_type',
        'glass_type',
        'spacer',
        'tempered',
        'specialty_glass',
        'grid_pattern',
        'grid_profile',
        'knocked_down',
        'series_id',
        'series_type',
        'modification_date',
        'is_modification',
    ];

    // Relationships

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function series()
    {
        return $this->belongsTo(\App\Models\Master\Series\Series::class, 'series_id', 'id');
    }
}
