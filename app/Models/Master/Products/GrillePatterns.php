<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class GrillePatterns extends Model
{
    protected $table = 'elitevw_master_products_grille_patterns';

    protected $fillable = ['product_code', 'description', 'product_types', 'profile'];
}
