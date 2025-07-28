<?php

namespace App\Helper;

class CimImportHelper
{
    public static function getHeaderMap()
    {
        return [
'Order #' => 'order_number',
'Cart barcode' => 'cart_barcode',
'Production barcode' => 'production_barcode',
'Customer short name' => 'customer_short_name',
'Comment' => 'comment',
'Description' => 'description',
'Customer #' => 'customer',
'Width' => 'width',
'Height' => 'height',
        ];
    }
}
