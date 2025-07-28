<?php

namespace App\Helper;

class LeadImportHelper
{
    public static function getHeaderMap()
    {
        return [
'License' => 'license_number',
'BusinessName' => 'name',
'Address' => 'address',
'City' => 'city',
'ZipCode' => 'zip',
'PhoneNumber' => 'phone',

        ];
    }
}
