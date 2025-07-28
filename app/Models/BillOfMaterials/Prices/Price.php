<?php

namespace App\Models\BillOfMaterials\Prices;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'elitevw_bom_prices'; 

    protected $fillable = [
    'material_name',
'description',
'unit',
'vendor',
'price',
'sold_by',
'lin_pcs',
    ];

public static function calculateLinPcs($price, $description, $unit, $sold_by)
{
    $length = 0;
    preg_match_all("/(\d+)\s*[\'’]/", $description, $matches);
    if (!empty($matches[1])) {
        $length = end($matches[1]) * 12;
    }

    preg_match("/(\d+)\s*pcs?/i", $unit, $countMatch);
    $count = $countMatch[1] ?? 0;

    if (!$count) {
        $map = ['by pcs', 'by tube', 'by box', 'by roll', 'by bnd', 'by spool'];
        if (in_array(strtolower($sold_by), $map)) {
            $count = 1;
        }
    }

    if ($length > 0 && $count > 0 && $price > 0) {
        return round($price / ($length * $count), 5);
    }

    return null;
}



}
