<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponHistory;
use App\Models\PackageTransaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Stripe;

class SubscriptionController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage pricing packages')) {
            $subscriptions = Subscription::get();

            return view('subscription.index', compact('subscriptions'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $intervals = Subscription::$intervals;

        return view('subscription.create', compact('intervals'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create pricing packages')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                    'package_amount' => 'required',
                    'interval' => 'required',
                    'user_limit' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $subscription = new Subscription();
            $subscription->title = $request->title;
            $subscription->interval = $request->interval;
            $subscription->package_amount = $request->package_amount;
            $subscription->user_limit = $request->user_limit;
            $subscription->enabled_pre_register = isset($request->enabled_pre_register) ? 1 : 0;
            $subscription->enabled_logged_history = isset($request->enabled_logged_history) ? 1 : 0;
            $subscription->save();

            return redirect()->route('subscriptions.index')->with('success', __('Subscription successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show($ids)
    {
        if (\Auth::user()->can('buy pricing packages')) {
            $id = Crypt::decrypt($ids);
            $subscription = Subscription::find($id);
            $settings = subscriptionPaymentSettings();

            return view('subscription.show', compact('subscription', 'settings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit(subscription $subscription)
    {
        $intervals = Subscription::$intervals;

        return view('subscription.edit', compact('intervals', 'subscription'));
    }


    public function update(Request $request, subscription $subscription)
    {

        if (\Auth::user()->can('edit pricing packages')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                    'package_amount' => 'required',
                    'interval' => 'required',
                    'user_limit' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $subscription->title = $request->title;
            $subscription->interval = $request->interval;
            $subscription->package_amount = $request->package_amount;
            $subscription->user_limit = $request->user_limit;
            $subscription->enabled_pre_register = isset($request->enabled_pre_register) ? 1 : 0;
            $subscription->enabled_logged_history = isset($request->enabled_logged_history) ? 1 : 0;
            $subscription->save();

            return redirect()->route('subscriptions.index')->with('success', __('Subscription successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(subscription $subscription)
    {
        if (\Auth::user()->can('delete pricing packages')) {
            $subscription->delete();

            return redirect()->route('subscriptions.index')->with('success', __('Subscription successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function transaction()
    {
        if (\Auth::user()->can('manage pricing transation')) {
            if (\Auth::user()->type == 'super admin') {
                $transactions = PackageTransaction::orderBy('created_at', 'DESC')->get();
            } else {
                $transactions = PackageTransaction::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->get();
            }
            $settings = settings();
            return view('subscription.transaction', compact('transactions', 'settings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function stripePayment(Request $request, $ids)
    {
        if (\Auth::user()->can('buy pricing packages')) {
            $settings = subscriptionPaymentSettings();
            $authUser = \Auth::user();
            $id = \Illuminate\Support\Facades\Crypt::decrypt($ids);
            $subscription = Subscription::find($id);
            if ($subscription) {
                try {
                    $amount = Coupon::couponApply($id, $request->coupon);
                    $packageTransId = uniqid('', true);
                    if ($amount > 0) {
                        Stripe\Stripe::setApiKey($settings['STRIPE_SECRET']);
                        $data = Stripe\Charge::create(
                            [
                                "amount" => 100 * $amount,
                                "currency" => $settings['CURRENCY'],
                                "source" => $request->stripeToken,
                                "description" => " Subscription - " . $subscription->name,
                                "metadata" => ["package_transaction_id" => $packageTransId],
                            ]
                        );
                    } else {
                        $data['amount_refunded'] = 0;
                        $data['failure_code'] = '';
                        $data['paid'] = 1;
                        $data['captured'] = 1;
                        $data['status'] = 'succeeded';
                    }

                    if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {

                        if ($data['status'] == 'succeeded') {
                            $data['holder_name'] = $request->name;
                            $data['subscription_id'] = $subscription->id;
                            $data['amount'] = $amount;
                            $data['subscription_transactions_id'] = $packageTransId;
                            $data['payment_type'] = 'Stripe';
                            PackageTransaction::transactionData($data);

                            if ($subscription->couponCheck() > 0 && !empty($request->coupon)) {
                                $couhis['coupon'] = $request->coupon;
                                $couhis['package'] = $subscription->id;
                                CouponHistory::couponData($couhis);
                            }

                            $assignPlan = assignSubscription($subscription->id);
                            if ($assignPlan['is_success']) {
                                return redirect()->route('subscriptions.index')->with('success', __('Subscription activate successfully.'));
                            } else {
                                return redirect()->route('subscriptions.index')->with('error', __($assignPlan['error']));
                            }
                        } else {
                            return redirect()->route('subscriptions.index')->with('error', __('Your payment failed.'));
                        }
                    } else {
                        return redirect()->route('subscriptions.index')->with('error', __('Transaction failed.'));
                    }
                } catch (\Exception $e) {
                    return redirect()->route('subscriptions.index')->with('error', __($e->getMessage()));
                }
            } else {
                return redirect()->route('subscriptions.index')->with('error', __('Subscription is not found.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }


}
