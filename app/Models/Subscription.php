<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'title',
        'package_amount',
        'interval',
        'user_limit',
        'enabled_pre_register',
        'enabled_logged_history',
    ];

    public static $intervals = [
        'Monthly' => 'Monthly',
        'Quarterly' => 'Quarterly',
        'Yearly' => 'Yearly',
        'Unlimited' => 'Unlimited',
    ];

    public function couponCheck()
    {
       $packages= Coupon::whereRaw("find_in_set($this->id,applicable_packages)")->count();
      return $packages;
    }

}
