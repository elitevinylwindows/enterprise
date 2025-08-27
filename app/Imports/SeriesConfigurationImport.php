<?php

// app/Imports/SeriesConfigurationImport.php
namespace App\Imports;

use App\Models\Master\Series\SeriesConfiguration;
use App\Models\Master\ProductKeys\ProductType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SeriesConfigurationImport implements ToCollection
{
    protected int $rows = 0;
    protected int $seriesCreated = 0;
    protected int $linksAttached = 0;
    protected array $missingProductCodes = [];

    /**
     * Expected columns per row:
     * [0] series_type (string, e.g., "XO")
     * [1] product_type code (e.g., "2101")
     * [2] product_type code
     * [3] product_type code
     * [4] product_type code
     *
     * First row can be a header; we skip it if it contains "series".
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $idx => $row) {
            $this->rows++;

            $data = array_map(static fn($v) => is_null($v) ? '' : trim((string)$v), $row->toArray());
            if (($data[0] ?? '') === '') {
                continue; // skip empty lines
            }

            // Skip header
            if ($idx === 0 && preg_match('/series/i', $data[0])) {
                continue;
            }

            $seriesTypeName = $data[0];

            // Find or create the SeriesConfiguration by series_type
            $series = SeriesConfiguration::firstOrCreate(
                ['series_type' => $seriesTypeName],
                // If you have other defaults, add here:
                []
            );

            if ($series->wasRecentlyCreated) {
                $this->seriesCreated++;
            }

            // Collect up to 4 product codes from columns 1..4
            $codes = [];
            for ($i = 1; $i <= 4; $i++) {
                if (!empty($data[$i])) {
                    $codes[] = $data[$i];
                }
            }

            // Attach product types found by product_type (code)
            foreach (array_unique($codes) as $code) {
                $product = ProductType::where('product_type', $code)->first();
                // ^^^^^ change to your actual lookup column; you displayed $pt->product_type in index

                if (!$product) {
                    $this->missingProductCodes[$seriesTypeName][] = $code;
                    continue;
                }

                $attachedBefore = $series->productTypes()
                    ->where('product_types.id', $product->id)
                    ->exists();

                $series->productTypes()->syncWithoutDetaching([$product->id]);

                if (!$attachedBefore) {
                    $this->linksAttached++;
                }
            }
        }
    }

    public function report(): array
    {
        return [
            'rows'            => $this->rows,
            'series_created'  => $this->seriesCreated,
            'links_attached'  => $this->linksAttached,
            'missing'         => $this->missingProductCodes, // [series_type => [codes...]]
        ];
    }
}
