<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\VisitCategory;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage visitor')) {
            $visitors = Visitor::where('parent_id', '=', parentId())->get();

            return view('visitor.index', compact('visitors'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        $category = VisitCategory::where('parent_id', '=', parentId())->get()->pluck('title', 'id');
        $status = Visitor::$status;
        $gender = Visitor::$gender;
        return view('visitor.create', compact('category', 'status', 'gender'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create visitor')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'phone_number' => 'required',
                    'gender' => 'required',
                    'date' => 'required',
                    'entry_time' => 'required',
                    'exit_time' => 'required',
                    'category' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $visitor = new Visitor();
            $visitor->visitor_id = $this->visitorNumber();
            $visitor->first_name = $request->first_name;
            $visitor->last_name = $request->last_name;
            $visitor->email = $request->email;
            $visitor->phone_number = $request->phone_number;
            $visitor->gender = $request->gender;
            $visitor->address = $request->address;
            $visitor->date = $request->date;
            $visitor->entry_time = $request->entry_time;
            $visitor->exit_time = $request->exit_time;
            $visitor->category = $request->category;
            $visitor->notes = $request->notes;
            $visitor->status = $request->status;
            $visitor->parent_id = parentId();
            $visitor->save();

            $module = 'visitor_create';
            $notification = Notification::where('parent_id', parentId())->where('module', $module)->first();
            $setting = settings();
            $errorMessage = '';
            if (!empty($notification) && $notification->enabled_email == 1) {
                $notification_responce = MessageReplace($notification, $visitor->id);
                $data['subject'] = $notification_responce['subject'];
                $data['message'] = $notification_responce['message'];
                $data['module'] = $module;
                $data['password'] = $request->password;
                $data['logo'] = $setting['company_logo'];
                $to = $visitor->email;
                $response = commonEmailSend($to, $data);
                if ($response['status'] == 'error') {
                    $errorMessage = $response['message'];
                }
            }

            return redirect()->back()->with('success', __('Visitor successfully created.') . '</br>' . $errorMessage);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(Visitor $visitor)
    {
        return view('visitor.show', compact('visitor'));
    }


    public function edit(Visitor $visitor)
    {
        $category = VisitCategory::where('parent_id', '=', parentId())->get()->pluck('title', 'id');
        $status = Visitor::$status;
        $gender = Visitor::$gender;

        return view('visitor.edit', compact('category', 'visitor', 'status', 'gender'));
    }


    public function update(Request $request, Visitor $visitor)
    {
        if (\Auth::user()->can('edit visitor')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'phone_number' => 'required',
                    'gender' => 'required',
                    'date' => 'required',
                    'entry_time' => 'required',
                    'exit_time' => 'required',
                    'category' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $visitor->first_name = $request->first_name;
            $visitor->last_name = $request->last_name;
            $visitor->email = $request->email;
            $visitor->phone_number = $request->phone_number;
            $visitor->gender = $request->gender;
            $visitor->address = $request->address;
            $visitor->date = $request->date;
            $visitor->entry_time = $request->entry_time;
            $visitor->exit_time = $request->exit_time;
            $visitor->category = $request->category;
            $visitor->notes = $request->notes;
            $visitor->status = $request->status;
            $visitor->save();

            return redirect()->back()->with('success', __('Visitor successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Visitor $visitor)
    {
        if (\Auth::user()->can('delete visitor')) {
            $visitor->delete();
            return redirect()->back()->with('success', 'Visitor successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function visitorNumber()
    {
        $latest = Visitor::where('parent_id', parentId())->latest()->first();
        if ($latest == null) {
            return 1;
        } else {
            return $latest->visitor_id + 1;
        }
    }

    public function todayVisitor()
    {
        if (\Auth::user()->can('manage today visitor')) {
            $visitors = Visitor::where('parent_id', '=', parentId())->where('date', date('Y-m-d'))->get();
            return view('visitor.today', compact('visitors'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function visitorPreRegister()
    {
        $ids = parentId();
        $authUser = \App\Models\User::find($ids);
        $subscription = \App\Models\Subscription::find($authUser->subscription);
        if (\Auth::user()->can('manage pre register visitor') && $subscription->enabled_pre_register == 1) {
            $visitors = Visitor::where('parent_id', '=', parentId())->where('is_preregister', 1)->get();
            return view('pre_register.index', compact('visitors'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function visitorPreRegisterDestroy($id)
    {
        if (\Auth::user()->can('delete pre register visitor')) {
            $visitor = Visitor::find($id);
            $visitor->delete();
            return redirect()->back()->with('success', 'Pre register visitor successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function preRegister($code)
    {
        $user = User::where('code', $code)->first();
        $id = !empty($user) ? $user->id : 0;
        \App::setLocale(!empty($user) ? $user->lang : 'en');
        $category = VisitCategory::where('parent_id', $id)->get()->pluck('title', 'id');
        $gender = Visitor::$gender;

        $settings = settingsById($id);
        \App::setLocale($user->lang);
        return view('pre_register.pre_register', compact('settings', 'code', 'category', 'gender', 'id'));
    }

    public function preRegisterStore(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_number' => 'required',
                'gender' => 'required',
                'date' => 'required',
                'entry_time' => 'required',
                'exit_time' => 'required',
                'category' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $latest = Visitor::where('parent_id', $id)->latest()->first();
        if ($latest == null) {
            $visitorNumber = 1;
        } else {
            $visitorNumber = $latest->visitor_id + 1;
        }

        $visitor = new Visitor();
        $visitor->visitor_id = $visitorNumber;
        $visitor->first_name = $request->first_name;
        $visitor->last_name = $request->last_name;
        $visitor->email = $request->email;
        $visitor->phone_number = $request->phone_number;
        $visitor->gender = $request->gender;
        $visitor->address = $request->address;
        $visitor->date = $request->date;
        $visitor->entry_time = $request->entry_time;
        $visitor->exit_time = $request->exit_time;
        $visitor->category = $request->category;
        $visitor->notes = $request->notes;
        $visitor->status = 'pending';
        $visitor->parent_id = $id;
        $visitor->is_preregister = 1;
        $visitor->save();

        $module = 'visitor_create';
        $notification = Notification::where('parent_id', $id)->where('module', $module)->first();
        $setting = settings();
        $errorMessage = '';
        if (!empty($notification) && $notification->enabled_email == 1) {
            $notification_responce = MessageReplace($notification, $visitor->id);
            $data['subject'] = $notification_responce['subject'];
            $data['message'] = $notification_responce['message'];
            $data['module'] = $module;
            $data['password'] = $request->password;
            $data['logo'] = $setting['company_logo'];
            $data['parent_id'] = $id;
            $to = $visitor->email;
            $response = commonEmailSend($to, $data);

            $settings = settings();
            $company_to = $settings['company_email'];
            $response = commonEmailSend($company_to, $data);
            if ($response['status'] == 'error') {
                $errorMessage = $response['message'];
            }
        }

        return redirect()->back()->with('success', __('Your registration has been successfully submitted.').'</br>'.$errorMessage);
    }

    public function visitorPassPrint($id)
    {
        $visitor = Visitor::find($id);
        $settings = settings();
        return view('visitor.print', compact('visitor', 'settings'));
    }
}
