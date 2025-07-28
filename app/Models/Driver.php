<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'elitevw_sr_drivers';
    protected $fillable = ['name', 'phone', 'email', 'license_number'];
    
    
    public function user()
{
    return $this->hasOne(User::class);
}

}

