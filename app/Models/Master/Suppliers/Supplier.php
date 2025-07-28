<?php

namespace App\Models\Master\Suppliers;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'elitevw_master_suppliers';
    protected $fillable = [
    'supplier_number',
    'supplier_type', // was "type"
    'name',
    'street',
    'city',
    'zip',
    'country',
    'phone',
    'website',
    'ein_number',
    'license_number',
    'supplier_group', // was "client_group"
    'currency',
    'currency_symbol',
    'labels', // was "label"
    'status',
    'disable_online_payment' // was "disable_payment"
];

protected $casts = [
    'disable_online_payment' => 'boolean',
];

    protected $guarded = [];
}
