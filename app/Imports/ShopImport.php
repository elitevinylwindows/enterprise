<?php

namespace App\Imports;

use App\Models\Shop;
use Maatwebsite\Excel\Concerns\ToModel;

class ShopImport implements ToModel
{
    public function model(array $row)
    {
        return new Shop([
            'customer' => $row[0],
            'address' => $row[1],
            'city' => $row[2],
            'zip' => $row[3],
        ]);
    }
}
