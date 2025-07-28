<?php

namespace App\Helper;

class CustomerImportHelper
{
    public static function getHeaderMap()
    {
        return [
'Customer #' => 'customer_number',
'Short Name' => 'customer_name',
'Street' => 'street',
'City' => 'city',
'ZIP' => 'zip',



        ];
    }
}
