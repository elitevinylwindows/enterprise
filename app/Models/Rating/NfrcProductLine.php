<?php
// app/Models/NfrcProductLine.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NfrcProductLine extends Model
{
    protected $connection = 'elitevw_ratings_nfrc';
    protected $table = 'nfrc_product_lines';
    protected $fillable = [
        'window_type_id','manufacturer','series_model','product_line',
        'product_line_url','is_energy_star'
    ];

    protected $casts = ['is_energy_star' => 'boolean'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(NfrcWindowType::class, 'window_type_id');
    }
}
