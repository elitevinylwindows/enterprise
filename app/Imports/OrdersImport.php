<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Order([
            'order_number' => $row['order_number'] ?? null,
            'area' => $row['area'] ?? null,
            'required_date' => $row['required_date'] ?? null,
            'delivery_date' => $row['delivery_date'] ?? null,
            'customer_name' => $row['customer_name'] ?? null,
            'short_name' => $row['short_name'] ?? null,
            'internal_order_number' => $row['internal_order_number'] ?? null,
            'comment' => $row['comment'] ?? null,
            'entered_by' => $row['entered_by'] ?? null,
            'entry_date' => $row['entry_date'] ?? null,
            'units' => $row['units'] ?? null,
            'number_of_fields' => $row['number_of_fields'] ?? null,
            'total_including' => $row['total_including'] ?? null,
            'currency' => $row['currency'] ?? null,
            'total_in_row' => $row['total_in_row'] ?? null,
            'status_code' => $row['status_code'] ?? null,
            'production' => $row['production'] ?? null,
            'edit_status' => $row['edit_status'] ?? null,
            'arrival_date' => $row['arrival_date'] ?? null,
            'project_number' => $row['project_number'] ?? null,
            'classification' => $row['classification'] ?? null,
            'production_status_color' => $row['production_status_color'] ?? null,
        ]);
    }
}
