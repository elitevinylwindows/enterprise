<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoggedHistory extends Model
{
    use HasFactory;
    public $fillable=[
        'user_id',
        'ip',
        'date',
        'details',
        'type',
        'parent_id',
    ];

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
