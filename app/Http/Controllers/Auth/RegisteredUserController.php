<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user=\App\Models\User::find(1);
        \App::setLocale($user->lang);
        $registerPage=getSettingsValByName('register_page');

        if($registerPage =='on'){
            $menu = Page::where('slug', 'terms_conditions')->first();
            return view('auth.register',compact('menu'));
        }else{
            return view('auth.login');
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $google_recaptcha = getSettingsValByName('google_recaptcha');
        if($google_recaptcha == 'on')
        {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }else{
            $validation = [];
        }
        $this->validate($request, $validation);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $userData=[
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'owner',
            'lang' => 'english',
            'subscription' => 1,
            'parent_id' => 1,
            'code' => uniqid(),
        ];
        $owner_email_verification = getSettingsValByName('owner_email_verification');
        $owner = User::create($userData);
        $userRole = Role::findByName('owner');
        $owner->assignRole($userRole);
        Auth::login($owner);
        defaultTemplate($owner->id);
        if ($owner_email_verification == 'on') {
            $token = sha1($owner->email);
            $url = route('email-verification', $token);

            $owner->email_verification_token = $token;
            $owner->save();

            $data = [
                'module' => 'email_verification',
                'subject' => 'Email Verification',
                'email' => $owner->email,
                'name' => $owner->name,
                'url' => $url,
            ];
            $to = $owner->email;
            $response = sendEmailVerification($to, $data);
            if ($response['status'] == 'success') {
                auth()->logout();
                return redirect()->route('login')->with('error', __('We have sent an account verification email to your registered email inbox. Please check your email and follow the instructions to verify your account.'));
            } else {
                $owner->delete();
                return redirect()->back()->with('error',  $response['message']);
            }
        } else {
            $module = 'owner_create';
            $setting = settings();
            if (!empty($owner)) {
                $data['subject'] = 'New User Created';
                $data['module'] = $module;
                $data['password'] = $request->password;
                $data['name'] = $request->name;
                $data['email'] = $request->email;
                $data['url'] = env('APP_URL');
                $data['logo'] = $setting['company_logo'];
                $to = $owner->email;
                commonEmailSend($to, $data);
            }
            $owner->email_verified_at = now();
            $owner->email_verification_token = null;
            $owner->save();
            return redirect(RouteServiceProvider::HOME);
        }

        // return redirect(RouteServiceProvider::HOME);
    }
}
