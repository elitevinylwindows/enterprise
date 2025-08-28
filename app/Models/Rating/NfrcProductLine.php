<?php
namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NfrcProductLine extends Model
{
    protected $table = 'elitevw_rating_product_lines';
    protected $fillable = [
        'window_type_id','manufacturer','series_model',
        'product_line','product_line_url','is_energy_star'
    ];
    protected $casts = ['is_energy_star' => 'boolean'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(NfrcWindowType::class,'window_type_id');
    }
}
