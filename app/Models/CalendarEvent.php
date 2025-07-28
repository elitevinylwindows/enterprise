<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable = [
        'title',
        'event_date',
        'customer',
        'order_number',
        'address',
        'city',
        'contact_phone',
        'email',
        'notes',
    ];
}
