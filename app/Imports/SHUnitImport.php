<?php

namespace App\Imports;

use App\Models\Schemas\SHUnit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class SHUnitImport implements ToModel
{

    public function headingRow(): int
    {
        return 1;
    }

    public function model(array $row)
    {
        dd($row);
        return new SHUnit([
            'product_id' => $row[0],
            'product_code' => $row[1],
            'product_class' => $row[2],
            'description' => $row[3],
            'retrofit' => $row[4],
            'nailon' => $row[5],
            'block' => $row[6],
            'le3_clr' => $row[7],
            'clr_clr' => $row[8],
            'le3_lam' => $row[9],
            'le3_clr_le3' => $row[10],
            'clr_temp' => $row[11],
            'le3_temp' => $row[12],
            'le3_1clr_temp' => $row[13],
            'lam_temp' => $row[14],
            'feat1' => $row[15],
            'feat2' => $row[16],
            'feat3' => $row[17],
            'sta_grd' => $row[18],
            'tpi' => $row[19],
            'tpo' => $row[20],
            'acid_edge' => $row[21],
            'solar_cool' => $row[22],
        ]);
    }
}
