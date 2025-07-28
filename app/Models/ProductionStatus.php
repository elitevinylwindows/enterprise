<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionStatus extends Model
{
    protected $table = 'elitevw_sr_production_statuses';

    protected $fillable = [
        'seq_no',
        'prod_status_code',
        'description',
        'station',
        'print_flag',
        'next_status_code',
        'color',
    ];
}
