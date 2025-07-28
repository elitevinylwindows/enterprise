<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'elitevw_sr_leads'; 

    protected $fillable = [
        'license_number',
        'name',
        'address',
        'city',
        'zip',
        'phone',
        'email',
        'notes',
        'status',
        'call_back_date',
        'call_back_time',
    ];
    
    public function assignedUser()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

}
