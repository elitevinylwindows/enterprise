<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon',
        'package',
        'user_id',
        'date',
    ];

    public function coupons()
    {
        return $this->hasOne('App\Models\Coupon', 'id', 'coupon');
    }

    public function pakages()
    {
        return $this->hasOne('App\Models\Subscription', 'id', 'package');
    }

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public static function couponData($data)
    {
        $coupons = Coupon::where('code', $data['coupon'])->first();
        $couponHistory = new CouponHistory();
        $couponHistory->coupon = $coupons->id;
        $couponHistory->package = $data['package'];
        $couponHistory->user_id = \Auth::user()->id;
        $couponHistory->date = date('Y-m-d');
        $couponHistory->save();
        $usedCoupun = $coupons->usedCoupon();
        if ($coupons->limit <= $usedCoupun) {
            $coupons->status = 0;
            $coupons->save();
        }
    }
}
