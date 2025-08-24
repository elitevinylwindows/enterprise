<?php

namespace App\Models\Sales;

use App\Models\Master\Series\Series;
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
        'series_id',
        'series_type',
        'discount',
        'is_modification',
        'modification_date',
        'tempered_fields',
        'addon'
    ];

    public function getPriceAttribute($value)
    {
        $addons = json_decode($this->addon, true);
        if (!$addons) {
            return number_format($value, 2);
        }

        return number_format(array_sum(array_values($addons)) + $value, 2);
    }

    public function getTotalAttribute($value)
    {
        $addons = json_decode($this->addon, true);
        if (!$addons) {
            return number_format($value, 2);
        }

        return number_format(array_sum(array_values($addons)) + $value, 2);
    }
    
    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }
}
