<?php

namespace App\Helper;

class PriceImportHelper
{
    public static function getHeaderMap()
    {
        return [
'Material Name' => 'material_name',
'Description' => 'description',
'Unit' => 'unit',
'Vendor' => 'vendor',
'Price' => 'price',
'Sold By' => 'sold_by',
'L in / Each Pcs' => 'lin_pcs',


        ];
    }
}
