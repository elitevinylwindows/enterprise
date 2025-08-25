<?php

namespace App\Imports;

use App\Models\Master\Series\Series;
use App\Models\Schemas\SHUnit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SHUnitImport implements ToModel, WithHeadings, WithStartRow
{

    public function startRow(): int
    {
        return 3; // data starts from row 3
    }

    public function headings(): array
    {
        return [
           'ProductID',
           'Product Code',
           'Product Class',
           'Description',
           'RETROFIT',
           'NAILON',
           'BLOCK',
           'LE3/CLR',
           'CLR/CLR',
           'LE3/LAM',
           'LE3/CLR/LE3',
           'CLR TEMP',
           'LE3 TEMP',
           '2LE3+1CLR TEMP',
           'LAM TEMP',
           'FEAT1',
           'FEAT2',
           'FEAT3',
           'STA GRD',
           'TPI',
           'TPO',
           'ACID EDGE',
           'SOLAR COOL',
        ];
    }

    public function model(array $row)
    {
        $oldNamesToNewNames = config('constants.old_names_to_new_names');
        $description = $row[3];
        $schemaId = null;

        foreach ($oldNamesToNewNames as $oldName => $newName) {
            if (stripos($description, $oldName) !== false) {
                $series = Series::where('series', strtoupper($newName))->first();
                if ($series) {
                    $schemaId = $series->id;
                    break;
                }
            }
        }
         return SHUnit::create([
            'product_id' => $row[0],
            'schema_id' => $schemaId,
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
            'le3_combo' => $row[13 ],
            'lam_temp' => $row[14],
            'feat1' => $row[15],
            'feat2' => $row[16],
            'feat3' => $row[17],
            'sta_grid' => $row[18],
            'tpi' => $row[19],
            'tpo' => $row[20],
            'acid_edge' => $row[21],
            'solar_cool' => $row[22],
        ]);
    }
}
