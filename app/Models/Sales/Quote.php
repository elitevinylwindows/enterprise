<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'elitevw_sales_quotes'; // use your actual table name
    protected $guarded = ['id']; // protect the id field from mass assignment
   
    public function configurations()
    {
        return $this->hasMany(\App\Models\Master\Series\SeriesType::class, 'series_id');
    }

    public function items()
    {
        return $this->hasMany(\App\Models\Sales\QuoteItem::class);
    }

}
