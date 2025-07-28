<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'rate',
        'applicable_packages',
        'code',
        'valid_for',
        'use_limit',
        'status',
    ];

    public static $status = [
        'Inactive',
        'Active',
    ];



    public function package($id)
    {
        $packages=explode(',',$id);
        return Subscription::whereIn('id',$packages)->get();
    }

    public function usedCoupon()
    {
        return $this->hasMany('App\Models\CouponHistory', 'coupon', 'id')->count();
    }

    public static $type = [
        'fixed' => 'Fixed',
        'percentage' => 'Percentage'
    ];

    public static function couponApply($subscriptionId,$couponCode)
    {

        $coupons = Coupon::where('code', $couponCode)->where('status', '1')->first();
        $package=Subscription::find($subscriptionId);
        if (!empty($coupons)) {
            $applicable_packages = Coupon::whereRaw("find_in_set($package->id,applicable_packages)")->first();

            if (empty($applicable_packages)) {
                return $package->package_amount;
            }

            $usedCoupun = $coupons->usedCoupon();
            if (($coupons->use_limit == $usedCoupun) || $coupons->valid_for<date('Y-m-d')) {
                return $package->package_amount;
            } else {
                if($coupons->type=='fixed'){
                    $discoutedPrice = $package->package_amount - $coupons->rate;
                }else{
                    $discount_value = ($package->package_amount / 100) * $coupons->rate;
                    $discoutedPrice = $package->package_amount - $discount_value;
                }
                return $discoutedPrice;
            }
        } else {
            return $package->package_amount;
        }
    }


}
