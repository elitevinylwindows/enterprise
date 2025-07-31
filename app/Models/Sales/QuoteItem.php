<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
   protected $table = 'elitevw_sales_quote_items';

protected $fillable = [
    'quote_id',
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

];




}

