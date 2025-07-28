<?php

namespace App\Models\Master\ProductKeys;

use Illuminate\Database\Eloquent\Model;

class DrawingObject extends Model
{
    protected $table = 'elitevw_master_productkeys_drawingobjects';

    protected $fillable = ['object_id', 'description'];
}
