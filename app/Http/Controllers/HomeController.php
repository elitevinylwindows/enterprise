<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Custom;
use App\Models\FAQ;
use App\Models\HomePage;
use App\Models\NoticeBoard;
use App\Models\PackageTransaction;
use App\Models\Page;
use App\Models\Subscription;
use App\Models\Support;
use App\Models\User;
use App\Models\VisitCategory;
use App\Models\Visitor;
use App\Models\Delivery;
use Carbon\Carbon;
use Spatie\Permission\PermissionRegistrar;


class HomeController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            if (\Auth::user()->type == 'super admin') {
                $result['totalOrganization'] = User::where('type', 'owner')->count();
                $result['totalSubscription'] = Subscription::count();
                $result['totalTransaction'] = PackageTransaction::count();
                $result['totalIncome'] = PackageTransaction::sum('amount');
                $result['totalNote'] = NoticeBoard::where('parent_id', parentId())->count();
                $result['totalContact'] = Contact::where('parent_id', parentId())->count();

                $result['organizationByMonth'] = $this->organizationByMonth();
                $result['paymentByMonth'] = $this->paymentByMonth();

                return view('dashboard.super_admin', compact('result'));
            } else {
                $result['totalVisitor'] = Visitor::where('parent_id', parentId())->count();
                
                $result['todayVisitor'] =  Visitor::where('parent_id', parentId())->where('date', date('Y-m-d'))->count();
                $result['totalPreRegisterVisitor'] =  Visitor::where('is_preregister', 1)->where('parent_id', parentId())->count();
                $result['totalCategory'] =  VisitCategory::where('parent_id', parentId())->count();
                $result['visitor'] = $this->getVisitor();
                $result['settings'] = settings();
                
                
                // Your new metrics
    $result['totalDeliveries'] = Delivery::where('is_delivery', 1)->count();
    $result['totalPickups'] = Delivery::where('is_delivery', 0)->count();
    $result['totalCompleted'] = Delivery::where('status', 'delivered')->count();
    $result['totalCancelled'] = Delivery::where('status', 'cancelled')->count();
    $result['totalPending'] = Delivery::whereNull('status')->orWhere('status', 'pending')->count();


                //                $result['incomeExpenseByMonth'] = $this->incomeByMonth();
                $result['settings'] = settings();





    app()[PermissionRegistrar::class]->forgetCachedPermissions();

 




                return view('dashboard.index', compact('result'));
            }
        } else {
            if (!file_exists(setup())) {
                header('location:install');
                die;
            } else {

                $landingPage = getSettingsValByName('landing_page');
                if ($landingPage == 'on') {
                    $subscriptions = Subscription::get();
                    $menus = Page::where('enabled', 1)->get();
                    $FAQs = FAQ::where('enabled', 1)->get();
                    return view('layouts.landing', compact('subscriptions', 'menus', 'FAQs'));
                } else {
                    return redirect()->route('login');
                }
            }
        }
    }

    public function organizationByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $organization = [];
        while ($currentdate <= $end) {
            $organization['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $organization['data'][] = User::where('type', 'owner')->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            $currentdate = strtotime('+1 month', $currentdate);
        }


        return $organization;
    }

    public function paymentByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['data'][] = PackageTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('amount');
            $currentdate = strtotime('+1 month', $currentdate);
        }

        return $payment;
    }

    public function incomeByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['income'][] = InvoicePayment::where('parent_id', parentId())->whereMonth('payment_date', $month)->whereYear('payment_date', $year)->sum('amount');
            $payment['expense'][] = Expense::where('parent_id', parentId())->whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
            $currentdate = strtotime('+1 month', $currentdate);
        }

        return $payment;
    }

    public function getVisitor()
    {
        $duration = [];
        $previousWeek = strtotime("-2 week +1 day");
        for ($i = 0; $i < 14; $i++) {
            $duration[date('Y-m-d', $previousWeek)] = date('d-M', $previousWeek);
            $previousWeek = strtotime(date('Y-m-d', $previousWeek) . " +1 day");
        }

        $arrResult = [];
        $arrResult['label'] = [];
        $arrResult['data'] = [];
        foreach ($duration as $date => $label) {
            $result = Visitor::where('parent_id', parentId())->where('date', $date)->count();
            $arrResult['label'][] = $label;
            $arrResult['data'][] = $result;
        }

        return $arrResult;
    }
}
