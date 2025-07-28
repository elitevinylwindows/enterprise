<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'elitevw_inventory_products';

   protected $fillable = [
    'name',
    'sku',
    'category_id',
    'uom_id',
    'description',
    'price',
    'unit',
    'unit_price',
    'supplier_id',
    'status',
];

    public function supplier()
    {
        return $this->belongsTo(\App\Models\Master\Suppliers\Supplier::class, 'supplier_id');
    }
    public function uom()
{
    return $this->belongsTo(\App\Models\Inventory\Uom::class, 'uom_id');
}

public function category()
{
    return $this->belongsTo(\App\Models\Inventory\Category::class, 'category_id');
}

}

