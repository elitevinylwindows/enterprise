<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponHistory;
use App\Models\Subscription;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage coupon')) {
            $coupons = Coupon::get();
            return view('coupon.index', compact('coupons'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $packages = Subscription::get()->pluck('title', 'id');
        $status = Coupon::$status;
        $type = Coupon::$type;
        return view('coupon.create', compact('packages', 'status', 'type'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create coupon')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'type' => 'required',
                    'rate' => 'required',
                    'applicable_packages' => 'required',
                    'code' => 'required',
                    'valid_for' => 'required',
                    'use_limit' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $coupon = new Coupon();
            $coupon->name = $request->name;
            $coupon->type = $request->type;
            $coupon->rate = $request->rate;
            $coupon->applicable_packages = !empty($request->applicable_packages) ? implode(',', $request->applicable_packages) : '';
            $coupon->code = $request->code;
            $coupon->valid_for = $request->valid_for;
            $coupon->use_limit = $request->use_limit;
            $coupon->status = $request->status;
            $coupon->save();

            return redirect()->back()->with('success', __('Coupon successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function show(Coupon $coupon)
    {
        //
    }


    public function edit(Coupon $coupon)
    {
        $packages = Subscription::get()->pluck('title', 'id');
        $status = Coupon::$status;
        $type = Coupon::$type;
        return view('coupon.edit', compact('coupon', 'packages', 'status', 'type'));
    }


    public function update(Request $request, Coupon $coupon)
    {
        if (\Auth::user()->can('edit coupon')) {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'type' => 'required',
                    'rate' => 'required',
                    'applicable_packages' => 'required',
                    'code' => 'required',
                    'valid_for' => 'required',
                    'use_limit' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $coupon->name = $request->name;
            $coupon->type = $request->type;
            $coupon->rate = $request->rate;
            $coupon->applicable_packages = !empty($request->applicable_packages) ? implode(',', $request->applicable_packages) : '';
            $coupon->code = $request->code;
            $coupon->valid_for = $request->valid_for;
            $coupon->use_limit = $request->use_limit;
            $coupon->status = $request->status;
            $coupon->save();

            return redirect()->back()->with('success', __('Coupon successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function destroy(Coupon $coupon)
    {
        if (\Auth::user()->can('delete coupon')) {
            $coupon->delete();
            return redirect()->back()->with('success', 'Coupon successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function history()
    {
        if (\Auth::user()->can('manage coupon history')) {
            $couponhistory = CouponHistory::get();
            return view('coupon.history', compact('couponhistory'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function historyDestroy($id)
    {
        if (\Auth::user()->can('manage coupon history')) {
            $coupon = CouponHistory::find($id);
            $coupon->delete();
            return redirect()->back()->with('success', 'Coupon history successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function apply(Request $request)
    {
        $settings=subscriptionPaymentSettings();
        $package = Subscription::find(\Illuminate\Support\Facades\Crypt::decrypt($request->package));
        if ($package && $request->coupon != '') {
            $currency = isset($settings['CURRENCY_SYMBOL'])?$settings['CURRENCY_SYMBOL']:'$';
            $originalPrice=$currency.$package->package_amount;
            $couponData = Coupon::where('code', $request->coupon)->where('status', '1')->first();
            if (!empty($couponData)) {
                $applicable_packages = Coupon::whereRaw("find_in_set($package->id,applicable_packages)")->first();

                if (empty($applicable_packages)) {
                    $response=[
                        'status' => false,
                        'price' => $package->package_amount,
                        'final_price' => $originalPrice,
                        'msg' => __('This coupon do not applicable packages for this package.'),
                    ];
                    return response()->json($response);
                }
                $usedCoupun = $couponData->usedCoupon();

                if (($couponData->use_limit == $usedCoupun) || $couponData->valid_for<date('Y-m-d')) {
                    $response=[
                        'status' => false,
                        'discoutedPrice' => $originalPrice,
                        'msg' => __('This coupon expired, please use another one.'),
                    ];
                    return response()->json($response);

                } else {

                    if($couponData->type=='fixed'){
                        $discoutedPrice = $currency.($package->package_amount - $couponData->rate);
                    }else{
                        $discount_value = ($package->package_amount / 100) * $couponData->rate;
                        $discoutedPrice = $currency.($package->package_amount - $discount_value);
                    }
                    $response=[
                        'status' => true,
                        'discoutedPrice' => $discoutedPrice,
                        'msg' => __('Coupon successfully applied.'),
                    ];
                    return response()->json($response);
                }
            } else {
                $response=[
                    'status' => false,
                    'discoutedPrice' => $originalPrice,
                    'msg' => __('This coupon is invalid or expired, please use another one.'),
                ];
                return response()->json($response);

            }
        }

    }
}
