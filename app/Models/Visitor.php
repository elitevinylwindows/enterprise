<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable=[
        'visitor_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'gender',
        'address',
        'date',
        'entry_time',
        'exit_time',
        'category',
        'parent_id',
        'is_preregister',
        'notes',
        'status',
    ];

    public static $status=[
        'pending'=>'Pending',
        'cancelled'=>'Cancelled',
        'rejected'=>'Rejected',
        'completed'=>'Completed',
    ];

    public static $gender=[
        'Male'=>'Male',
        'Female'=>'Female',
    ];

    public function categories()
    {
        return $this->hasOne('App\Models\VisitCategory','id','category');
    }
}
