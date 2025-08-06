<?php

use App\Helper\FirstServe;
use App\Mail\Common;
use App\Mail\EmailVerification;
use App\Mail\InvoiceMail;
use App\Mail\TestMail;
use App\Models\AuthPage;
use App\Models\Custom;
use App\Models\FAQ;
use App\Models\HomePage;
use App\Models\LoggedHistory;
use App\Models\Notification;
use App\Models\Page;
use App\Models\Sales\Invoice;
use App\Models\Sales\Order;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Visitor;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Google2FAQRCode\Google2FA;
use Spatie\Permission\Models\Role;
use App\Models\Sales\SalesSetting;


if (!function_exists('settingsKeys')) {
    function settingsKeys()
    {
        return $settingsKeys = [
            "app_name" => "",
            "theme_mode" => "light",
            "layout_font" => "Roboto",
            "accent_color" => "preset-6",
            "color_type" => "preset",
            "custom_color" => "--primary-rgb: 0,0,0",
            "custom_color_code" => "#000000",
            "sidebar_caption" => "true",
            "theme_layout" => "ltr",
            "layout_width" => "false",
            "owner_email_verification" => "off",
            "landing_page" => "on",
            "register_page" => "on",
            "company_logo" => "logo.png",
            "company_favicon" => "favicon.png",
            "landing_logo" => "landing_logo.png",
            "light_logo" => "light_logo.png",
            "meta_seo_title" => "",
            "meta_seo_keyword" => "",
            "meta_seo_description" => "",
            "meta_seo_image" => "",
            "company_date_format" => "M j, Y",
            "company_time_format" => "g:i A",
            "company_name" => "",
            "company_phone" => "",
            "company_address" => "",
            "company_email" => "",
            "company_email_from_name" => "",
            "google_recaptcha" => "off",
            "recaptcha_key" => "",
            "recaptcha_secret" => "",
            'SERVER_DRIVER' => "",
            'SERVER_HOST' => "",
            'SERVER_PORT' => "",
            'SERVER_USERNAME' => "",
            'SERVER_PASSWORD' => "",
            'SERVER_ENCRYPTION' => "",
            'FROM_EMAIL' => "",
            'FROM_NAME' => "",
            'CURRENCY' => "USD",
            'CURRENCY_SYMBOL' => "$",
            'STRIPE_PAYMENT' => "off",
            'STRIPE_KEY' => "",
            'STRIPE_SECRET' => "",
            "paypal_payment" => "off",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "bank_transfer_payment" => "off",
            "bank_name" => "",
            "bank_holder_name" => "",
            "bank_account_number" => "",
            "bank_ifsc_code" => "",
            "bank_other_details" => "",
            "flutterwave_payment" => "off",
            "flutterwave_public_key" => "",
            "flutterwave_secret_key" => "",
            "timezone" => "",
            "footer_column_1" => "Quick Links",
            "footer_column_1_enabled" => "active",
            "footer_column_2" => "Help",
            "footer_column_2_enabled" => "active",
            "footer_column_3" => "OverView",
            "footer_column_3_enabled" => "active",
            "footer_column_4" => "Core System",
            "footer_column_4_enabled" => "active",
            "pricing_feature" => "on",
            'visitor_number_prefix' => "#VST-000",
        ];
    }
}

if (!function_exists('settings')) {
    function settings()
    {
        $settingData = DB::table('settings');
        if (\Auth::check()) {
            $userId = parentId();
            $settingData = $settingData->where('parent_id', $userId);
        } else {
            $settingData = $settingData->where('parent_id', 1);
        }
        $settingData = $settingData->get();
        $details = settingsKeys();

        foreach ($settingData as $row) {
            $details[$row->name] = $row->value;
        }

        config(
            [
                'captcha.secret' => $details['recaptcha_secret'],
                'captcha.sitekey' => $details['recaptcha_key'],
                'options' => [
                    'timeout' => 30,
                ]
            ]
        );

        return $details;
    }
}


if (!function_exists('sales_setting')) {
    function sales_setting($key, $default = null)
    {
        static $salesSettings;

        if (!$salesSettings) {
            $salesSettings = SalesSetting::pluck('value', 'key')->toArray();
        }

        return $salesSettings[$key] ?? $default;
    }
}


if (!function_exists('subscriptionPaymentSettings')) {
    function subscriptionPaymentSettings()
    {
        $settingData = DB::table('settings')->where('type', 'payment')->where('parent_id', '=', 1)->get();
        $result = [
            'CURRENCY' => "USD",
            'CURRENCY_SYMBOL' => "$",
            'STRIPE_PAYMENT' => "off",
            'STRIPE_KEY' => "",
            'STRIPE_SECRET' => "",
            "paypal_payment" => "off",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "bank_transfer_payment" => "off",
            "bank_name" => "",
            "bank_holder_name" => "",
            "bank_account_number" => "",
            "bank_ifsc_code" => "",
            "bank_other_details" => "",
            "flutterwave_payment" => "off",
            "flutterwave_public_key" => "",
            "flutterwave_secret_key" => "",

        ];

        foreach ($settingData as $setting) {
            $result[$setting->name] = $setting->value;
        }

        return $result;
    }
}

if (!function_exists('invoicePaymentSettings')) {
    function invoicePaymentSettings($id)
    {
        $settingData = DB::table('settings')->where('type', 'payment')->where('parent_id', $id)->get();
        $result = [
            'CURRENCY' => "USD",
            'CURRENCY_SYMBOL' => "$",
            'STRIPE_PAYMENT' => "off",
            'STRIPE_KEY' => "",
            'STRIPE_SECRET' => "",
            "paypal_payment" => "off",
            "paypal_mode" => "",
            "paypal_client_id" => "",
            "paypal_secret_key" => "",
            "bank_transfer_payment" => "off",
            "bank_name" => "",
            "bank_holder_name" => "",
            "bank_account_number" => "",
            "bank_ifsc_code" => "",
            "bank_other_details" => "",
            "flutterwave_payment" => "off",
            "flutterwave_public_key" => "",
            "flutterwave_secret_key" => "",
        ];

        foreach ($settingData as $row) {
            $result[$row->name] = $row->value;
        }
        return $result;
    }
}

if (!function_exists('getSettingsValByName')) {
    function getSettingsValByName($key)
    {
        $setting = settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }
}

if (!function_exists('getSettingsValByIdName')) {
    function getSettingsValByIdName($id, $key)
    {
        $setting = settingsById($id);
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }
}

if (!function_exists('settingDateFormat')) {
    function settingDateFormat($settings, $date)
    {
        return date($settings['company_date_format'], strtotime($date));
    }
}
if (!function_exists('settingPriceFormat')) {
    function settingPriceFormat($settings, $price)
    {
        return $settings['CURRENCY_SYMBOL'] . $price;
    }
}
if (!function_exists('settingTimeFormat')) {
    function settingTimeFormat($settings, $time)
    {
        return date($settings['company_time_format'], strtotime($time));
    }
}
if (!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        $settings = settings();

        return date($settings['company_date_format'], strtotime($date));
    }
}
if (!function_exists('timeFormat')) {
    function timeFormat($time)
    {
        $settings = settings();

        return date($settings['company_time_format'], strtotime($time));
    }
}
if (!function_exists('priceFormat')) {
    function priceFormat($price)
    {
        $settings = settings();

        return $settings['CURRENCY_SYMBOL'] . $price;
    }
}
if (!function_exists('parentId')) {
    function parentId()
    {
        if (\Auth::user()->type == 'owner' || \Auth::user()->type == 'super admin') {
            return \Auth::user()->id;
        } else {
            return \Auth::user()->parent_id;
        }
    }
}
if (!function_exists('assignSubscription')) {
    function assignSubscription($id)
    {
        $subscription = Subscription::find($id);
        if ($subscription) {
            \Auth::user()->subscription = $subscription->id;
            if ($subscription->interval == 'Monthly') {
                \Auth::user()->subscription_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            } elseif ($subscription->interval == 'Quarterly') {
                \Auth::user()->subscription_expire_date = Carbon::now()->addMonths(3)->isoFormat('YYYY-MM-DD');
            } elseif ($subscription->interval == 'Yearly') {
                \Auth::user()->subscription_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            } else {
                \Auth::user()->subscription_expire_date = null;
            }
            \Auth::user()->save();

            $users = User::where('parent_id', '=', parentId())->whereNotIn('type', ['super admin', 'owner'])->get();

            if ($subscription->user_limit == 0) {
                foreach ($users as $user) {
                    $user->is_active = 1;
                    $user->save();
                }
            } else {
                $userCount = 0;
                foreach ($users as $user) {
                    $userCount++;
                    if ($userCount <= $subscription->user_limit) {
                        $user->is_active = 1;
                        $user->save();
                    } else {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }
            return [
                'is_success' => true,
            ];
        } else {
            return [
                'is_success' => false,
                'error' => 'Subscription is deleted.',
            ];
        }
    }
}
if (!function_exists('assignManuallySubscription')) {
    function assignManuallySubscription($id, $userId)
    {
        $owner = User::find($userId);
        $subscription = Subscription::find($id);
        if ($subscription) {
            $owner->subscription = $subscription->id;
            if ($subscription->interval == 'Monthly') {
                $owner->subscription_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            } elseif ($subscription->interval == 'Quarterly') {
                $owner->subscription_expire_date = Carbon::now()->addMonths(3)->isoFormat('YYYY-MM-DD');
            } elseif ($subscription->interval == 'Yearly') {
                $owner->subscription_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            } else {
                $owner->subscription_expire_date = null;
            }
            $owner->save();

            $users = User::where('parent_id', '=', parentId())->whereNotIn('type', ['super admin', 'owner'])->get();

            if ($subscription->user_limit == 0) {
                foreach ($users as $user) {
                    $user->is_active = 1;
                    $user->save();
                }
            } else {
                $userCount = 0;
                foreach ($users as $user) {
                    $userCount++;
                    if ($userCount <= $subscription->user_limit) {
                        $user->is_active = 1;
                        $user->save();
                    } else {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }
            return [
                'is_success' => true,
            ];
        } else {
            return [
                'is_success' => false,
                'error' => 'Subscription is deleted.',
            ];
        }
    }
}
if (!function_exists('smtpDetail')) {
    function smtpDetail($id)
    {
        $settings = emailSettings($id);

        $smtpDetail = config(
            [
                'mail.mailers.smtp.transport' => $settings['SERVER_DRIVER'],
                'mail.mailers.smtp.host' => $settings['SERVER_HOST'],
                'mail.mailers.smtp.port' => $settings['SERVER_PORT'],
                'mail.mailers.smtp.encryption' => $settings['SERVER_ENCRYPTION'],
                'mail.mailers.smtp.username' => $settings['SERVER_USERNAME'],
                'mail.mailers.smtp.password' => $settings['SERVER_PASSWORD'],
                'mail.from.address' => $settings['FROM_EMAIL'],
                'mail.from.name' => $settings['FROM_NAME'],
            ]
        );

        return $smtpDetail;
    }
}

if (!function_exists('visitorPrefix')) {
    function visitorPrefix()
    {
        $settings = settings();
        return $settings["visitor_number_prefix"];
    }
}



if (!function_exists('timeCalculation')) {
    function timeCalculation($startDate, $startTime, $endDate, $endTime)
    {
        $startdate = $startDate . ' ' . $startTime;
        $enddate = $endDate . ' ' . $endTime;

        $startDateTime = new DateTime($startdate);
        $endDateTime = new DateTime($enddate);

        $interval = $startDateTime->diff($endDateTime);
        $totalHours = $interval->h + $interval->i / 60;

        return number_format($totalHours, 2);
    }
}

if (!function_exists('setup')) {
    function setup()
    {
        $setupPath = storage_path() . "/installed";
        return $setupPath;
    }
}

if (!function_exists('userLoggedHistory')) {
    function userLoggedHistory()
    {
        $serverip = $_SERVER['REMOTE_ADDR'];
        $data = @unserialize(file_get_contents('http://ip-api.com/php/' . $serverip));
        if (isset($data['status']) && $data['status'] == 'success') {
            $browser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
            if ($browser->device->type == 'bot') {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
            $referrerData = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : null;
            $data['browser'] = $browser->browser->name ?? null;
            $data['os'] = $browser->os->name ?? null;
            $data['language'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
            $data['device'] = User::getDevice($_SERVER['HTTP_USER_AGENT']);
            $data['referrer_host'] = !empty($referrerData['host']);
            $data['referrer_path'] = !empty($referrerData['path']);
            $result = json_encode($data);
            $details = new LoggedHistory();
            $details->type = Auth::user()->type;
            $details->user_id = Auth::user()->id;
            $details->date = date('Y-m-d H:i:s');
            $details->Details = $result;
            $details->ip = $serverip;
            $details->parent_id = parentId();
            $details->save();
        }
    }
}
if (!function_exists('settingsById')) {

    function settingsById($userId)
    {
        $data = DB::table('settings');
        $data = $data->where('parent_id',  $userId);
        $data = $data->get();
        $settings = settingsKeys();

        foreach ($data as $row) {
            $settings[$row->name] = $row->value;
        }

        config(
            [
                'captcha.secret' => $settings['recaptcha_key'],
                'captcha.sitekey' => $settings['recaptcha_secret'],
                'options' => [
                    'timeout' => 30,
                ],
            ]
        );

        return $settings;
    }
}

if (!function_exists('defaultClientCreate')) {
    function defaultClientCreate($id)
    {
        // Default Client role
        $clientRoleData = [
            'name' => 'client',
            'parent_id' => $id,
        ];
        $systemClientRole = Role::create($clientRoleData);
        // Default Client permissions
        $systemClientPermissions = [
            ['name' => 'manage contact'],
            ['name' => 'create contact'],
            ['name' => 'edit contact'],
            ['name' => 'delete contact'],
            ['name' => 'manage note'],
            ['name' => 'create note'],
            ['name' => 'edit note'],
            ['name' => 'delete note'],
            ['name' => 'manage ticket'],
            ['name' => 'create ticket'],
            ['name' => 'edit ticket'],
            ['name' => 'delete ticket'],
            ['name' => 'reply ticket'],
        ];
        $systemClientRole->givePermissionTo($systemClientPermissions);
        return $systemClientRole;
    }
}

if (!function_exists('defaultTemplate')) {
    function defaultTemplate($id)
    {
        $templateData = [
            'user_create' =>
            [
                'module' => 'user_create',
                'name' => 'New User',
                'short_code' => ['{company_name}', '{company_email}', '{company_phone_number}', '{company_address}', '{company_currency}', '{new_user_name}', '{app_link}', '{username}', '{password}'],
                'subject' => 'Welcome to {company_name}!',
                'templete' => '
                        <p><strong>Dear {new_user_name}</strong>,</p><p>&nbsp;</p><blockquote><p>Welcome to {company_name}! We are excited to have you on board and look forward to providing you with an exceptional experience.</p><p>We hope you enjoy your experience with us. If you have any feedback, feel free to share it with us.</p><p>&nbsp;</p><p>Your account details are as follows:</p><p><strong>App Link:</strong> <a href="{app_link}">{app_link}</a></p><p><strong>Username:</strong> {username}</p><p><strong>Password:</strong> {password}</p><p>&nbsp;</p><p>Thank you for choosing {company_name}!</p></blockquote><p>Best regards,</p><p>{company_name}</p><p>{company_email}</p>
                    ',
            ],
            'visitor_create' =>
            [
                'module' => 'visitor_create',
                'name' => 'New Visitor',
                'short_code' => ['{visitor_name}', '{visitor_email}', '{visitor_phone_number}', '{visitor_id}', '{visitor_date}', '{visitor_entry_time}', '{visitor_exit_time}', '{visitor_category}', '{visitor_address}', '{visitor_notes}'],
                'subject' => 'Welcome to {visitor_name}!',
                'templete' => '
                <p><strong>Dear {visitor_name},</strong></p>
                <p>Thank you for registering with us. Here are the details of your visit:</p>
                <p>&nbsp;</p>
                <blockquote>
                    <p><strong>Name:</strong> {visitor_name} </p>
                    <p><strong>Email:</strong> {visitor_email} </p>
                    <p><strong>Phone Number:</strong> {visitor_phone_number} </p>
                    <p><strong>Visitor ID:</strong> {visitor_id} </p>
                    <p><strong>Visit Date:</strong> {visitor_date} </p>
                    <p><strong>Entry Time:</strong> {visitor_entry_time} </p>
                    <p><strong>Exit Time:</strong> {visitor_exit_time} </p>
                    <p><strong>Category:</strong> {visitor_category} </p>
                    <p><strong>Address:</strong> {visitor_address} </p>
                    <p><strong>Notes:</strong> {visitor_notes} </p>
                </blockquote>',
            ]
        ];

        // Store all created templates if needed
        $createdTemplates = [];

        foreach ($templateData as $key => $value) {
            $template = new Notification();
            $template->module = $value['module'];
            $template->name = $value['name'];
            $template->subject = $value['subject'];
            $template->message = $value['templete'];
            $template->short_code = json_encode($value['short_code']);
            $template->enabled_email = 0;
            $template->parent_id = $id; // Associate with the provided ID
            $template->save();

            $createdTemplates[] = $template; // Collect all created templates
        }

        // Return all created templates if needed
        return $createdTemplates;
    }
}

if (!function_exists('MessageReplace')) {
    function MessageReplace($notification, $id = 0)
    {
        $return['subject'] = $notification->subject;
        $return['message'] = $notification->message;
        if (!empty($notification->password)) {
            $notification['password'] = $notification->password;
        }
        $settings = settings();
        if (!empty($notification)) {
            $search = [];
            $replace = [];
            if ($notification->module == 'user_create') {
                $user = User::find($id);
                $search = ['{company_name}', '{company_email}', '{company_phone_number}', '{company_address}', '{company_currency}', '{new_user_name}', '{app_link}', '{username}', '{password}'];
                $replace = [$settings['company_name'], $settings['company_email'], $settings['company_phone'], $settings['company_address'], $settings['CURRENCY_SYMBOL'], $user->name, env('APP_URL'), $user->email, $notification['password']];
            }
            if ($notification->module == 'visitor_create') {
                $visitor = Visitor::find($id);
                $visitor_name = $visitor->first_name . ' ' . $visitor->last_name;
                $visitor_category = !empty($visitor->categories) ? $visitor->categories->title : '-';
                $search = ['{visitor_name}', '{visitor_email}', '{visitor_phone_number}', '{visitor_id}', '{visitor_date}', '{visitor_entry_time}', '{visitor_exit_time}', '{visitor_category}', '{visitor_address}', '{visitor_notes}'];
                $replace = [$visitor_name, $visitor->email, $visitor->phone_number, visitorPrefix() . $visitor->visitor_id, dateFormat($visitor->date), timeFormat($visitor->entry_time), timeFormat($visitor->exit_time), $visitor_category, $visitor->address, $visitor->notes];
            }

            $return['subject'] = str_replace($search, $replace, $notification->subject);
            $return['message'] = str_replace($search, $replace, $notification->message);
        }

        return $return;
    }
}


if (!function_exists('sendEmail')) {
    function sendEmail($to, $datas)
    {
        $datas['settings'] = settings();
        try {
            emailSettings(parentId());
            Mail::to($to)->send(new TestMail($datas));
            return [
                'status' => 'success',
                'message' => __('Email successfully sent'),
            ];
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return [
                'status' => 'error',
                'message' => __('We noticed that the email settings have not been configured for this system. As a result, email-related functionalities may not work as expected. please add valide email smtp details first.')
            ];
        }
    }
}


if (!function_exists('commonEmailSend')) {
    function commonEmailSend($to, $datas)
    {
        $datas['settings'] = settings();
        try {
            if (Auth::check()) {
                if ($datas['module'] == 'owner_create') {
                    emailSettings(1);
                } else {
                    emailSettings(parentId());
                }
            } else {
                emailSettings($datas['parent_id']);
            }
            Mail::to($to)->send(new Common($datas));
            return [
                'status' => 'success',
                'message' => __('Email successfully sent'),
            ];
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return [
                'status' => 'error',
                'message' => __('We noticed that the email settings have not been configured for this system. As a result, email-related functionalities may not work as expected. please add valide email smtp details first.')
            ];
        }
    }
}


if (!function_exists('emailSettings')) {
    function emailSettings($id)
    {
        $settingData = DB::table('settings')
            ->where('type', 'smtp')
            ->where('parent_id', $id)
            ->get();

        $result = [
            'FROM_EMAIL' => "",
            'FROM_NAME' => "",
            'SERVER_DRIVER' => "",
            'SERVER_HOST' => "",
            'SERVER_PORT' => "",
            'SERVER_USERNAME' => "",
            'SERVER_PASSWORD' => "",
            'SERVER_ENCRYPTION' => "",
        ];

        foreach ($settingData as $setting) {
            $result[$setting->name] = $setting->value;
        }

        // Apply settings dynamically
        config([
            'mail.default' => $result['SERVER_DRIVER'] ?? '',
            'mail.mailers.smtp.host' => $result['SERVER_HOST'] ?? '',
            'mail.mailers.smtp.port' => $result['SERVER_PORT'] ?? '',
            'mail.mailers.smtp.encryption' => $result['SERVER_ENCRYPTION'] ?? '',
            'mail.mailers.smtp.username' => $result['SERVER_USERNAME'] ?? '',
            'mail.mailers.smtp.password' => $result['SERVER_PASSWORD'] ?? '',
            'mail.from.name' => $result['FROM_NAME'] ?? '',
            'mail.from.address' => $result['FROM_EMAIL'] ?? '',
        ]);
        return $result;
    }
}


if (!function_exists('sendEmailVerification')) {
    function sendEmailVerification($to, $data)
    {
        $data['settings'] = emailSettings(1);
        try {
            Mail::to($to)->send(new EmailVerification($data));

            return [
                'status' => 'success',
                'message' => __('Email successfully sent'),
            ];
        } catch (\Exception $e) {
            Log::error('Email Sending Failed: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => __('We noticed that the email settings have not been configured for this system. As a result, email-related functionalities may not work as expected. please contact the administrator to resolve this issue.')
            ];
            return redirect()->back()->with('error', __(''));
        }
    }
}


if (!function_exists('RoleName')) {
    function RoleName($permission_id = '0')
    {
        $retuen = '';
        $role_id_array = DB::table('role_has_permissions')->where('permission_id', $permission_id)->pluck('role_id');
        if (!empty($role_id_array)) {
            $role_id_array = DB::table('roles')->whereIn('id', $role_id_array)->pluck('name')->toArray();
            $retuen = implode(', ', $role_id_array);
        }

        return $retuen;
    }
}

if (!function_exists('HomePageSection')) {
    function HomePageSection()
    {
        $retuen = [
            [
                'title' => 'Header Menu',
                'section' => 'Section 0',
                'content' => '',
                'content_value' => '{"name":"Header Menu","menu_pages":["1","2"]}',
            ],
            [
                'title' => 'Banner',
                'section' => 'Section 1',
                'content_value' => '{"name":"Banner","section_enabled":"active","title":"Smart Visitor - Visitor Management Tool","sub_title":"A Visitor Management System (VMS) is a comprehensive solution designed to enhance the efficiency, security, and overall experience associated with visitor interactions within a facility.","btn_name":"Get Started","btn_link":"#","section_footer_text":"Manage your business efficiently with our all-in-one solution designed for performance, security, and scalability.","section_footer_image":{},"section_main_image":{},"section_footer_image_path":"upload\/homepage\/banner_2.png","section_main_image_path":"upload\/homepage\/banner_1.png","box_image_1_path":"","box_image_2_path":"","box_image_3_path":"","Box1_image_path":"","Box2_image_path":"","Sec4_box1_image_path":"","Sec4_box2_image_path":"","Sec4_box3_image_path":"","Sec4_box4_image_path":"","Sec4_box5_image_path":"","Sec4_box6_image_path":"","Sec7_box1_image_path":"","Sec7_box2_image_path":"","Sec7_box3_image_path":"","Sec7_box4_image_path":"","Sec7_box5_image_path":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}',
                'content' => '
                <header id="home">
                    <div class="container">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-5 col-xl-4">
                                <h1 class="mt-sm-3 mb-sm-4 f-w-600 wow fadeInUp" data-wow-delay="0.2s">

                                    <span class="text-primary">Smart Visitor</span>
                                </h1>
                                <h4 class="mb-sm-4 text-muted wow fadeInUp" data-wow-delay="0.4s">
                                    Smart Visitor is React based admin template which helps you to build faster and beautiful web
                                    applications.
                                </h4>
                                <div class="my-3 my-xl-5 wow fadeInUp" data-wow-delay="0.6s">
                                    <a href="dashboard/index.html" class="btn btn-secondary me-2">' . __('Get Started') . '</a>

                                </div>
                                <div class="mb-4 mb-lg-0 d-inline-flex align-items-center wow fadeInUp" data-wow-delay="0.8s">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-l bg-light-secondary text-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32"
                                                class="d-block" viewBox="0 0 118 94" role="img">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-0 text-start">
                                            <b>Built with Bootstrap</b>
                                            © - The most popular React Component Library.
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="hero-image">
                                    <img src="assets/images/landing/img-header-main.svg" alt="image"
                                        class="img-fluid img-bg wow fadeInUp" data-wow-delay="0.5s" />
                                    <div class="img-widget-1">
                                        <img src="assets/images/landing/img-widget-1.svg" alt="image"
                                            class="img-fluid wow fadeInDown" data-wow-delay="0.6s" />
                                    </div>
                                    <div class="img-widget-2">
                                        <img src="assets/images/landing/img-widget-2.svg" alt="image"
                                            class="img-fluid wow fadeInDown" data-wow-delay="0.7s" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>',
            ],
            [
                'title' => 'OverView',
                'section' => 'Section 2',
                'content_value' => '{"name":"OverView","section_enabled":"active","Box1_title":"Customers","Box1_number":"500+","Box2_title":"Subscription Plan","Box2_number":"4+","Box3_title":"Language","Box3_number":"11+","box1_number_image":{},"box2_number_image":{},"box3_number_image":{},"section_footer_image_path":"","section_main_image_path":"","box_image_1_path":"upload\/homepage\/OverView_1.svg","box_image_2_path":"upload\/homepage\/OverView_2.svg","box_image_3_path":"upload\/homepage\/OverView_3.svg","Box1_image_path":"","Box2_image_path":"","Sec4_box1_image_path":"","Sec4_box2_image_path":"","Sec4_box3_image_path":"","Sec4_box4_image_path":"","Sec4_box5_image_path":"","Sec4_box6_image_path":"","Sec7_box1_image_path":"","Sec7_box2_image_path":"","Sec7_box3_image_path":"","Sec7_box4_image_path":"","Sec7_box5_image_path":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}',
                'content' =>
                '<section>
                    <div class="container">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-4">
                                <div class="card feature-card mb-0 bg-yellow-200">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avtar avtar-l">
                                                    <img src="assets/images/landing/img-feature-1.svg" alt="img"
                                                        class="img-fluid" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3 text-end">
                                                <span class="h1 mb-0 d-block fw-semibold">150+</span>
                                                <span class="h5 mb-0 d-block">Components</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="card feature-card mb-0 bg-blue-200">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avtar avtar-l">
                                                    <img src="assets/images/landing/img-feature-2.svg" alt="img"
                                                        class="img-fluid" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3 text-end">
                                                <span class="h1 mb-0 d-block fw-semibold">8+</span>
                                                <span class="h5 mb-0 d-block">Application</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <div class="card feature-card mb-0 bg-purple-200">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avtar avtar-l">
                                                    <img src="assets/images/landing/img-feature-3.svg" alt="img"
                                                        class="img-fluid" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3 text-end">
                                                <span class="h1 mb-0 d-block fw-semibold">100+</span>
                                                <span class="h5 mb-0 d-block">Pages</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>'
            ],
            [
                'title' => 'AboutUs',
                'section' => 'Section 3',
                'content_value' => '{"name":"AboutUs","section_enabled":"active","Box1_title":"Empower Your Business to Thrive with Us","Box1_info":"Unlock growth, streamline operations, and achieve success with our innovative solutions.","Box1_list":["Simplify and automate your business processes for maximum efficiency.","Receive tailored strategies to meet business needs and unlock potential.","Grow confidently with flexible solutions that adapt to your business needs.","Make smarter decisions with real-time analytics and performance tracking.","Rely on 24\/7 expert assistance to keep your business running smoothly."],"Box2_title":"Eliminate Paperwork, Elevate Productivity","Box2_info":"Simplify your operations with seamless digital solutions and focus on what truly matters.","Box2_list":["Replace manual paperwork with automated workflows.","Secure cloud storage lets you manage documents on the go.","Streamlined processes save time and reduce errors.","Keep your information safe with encrypted storage.","Reduce printing, storage, and administrative expenses.","Go green by minimizing paper use and waste."],"section_footer_image_path":"","section_main_image_path":"","box_image_1_path":"","box_image_2_path":"","box_image_3_path":"","Box1_image_path":"upload\/homepage\/img-customize-1_Section 33_image_120250113052054am.png","Box2_image_path":"upload\/homepage\/img-customize-2_Section 33_image_220250113052054am.png","Sec4_box1_image_path":"","Sec4_box2_image_path":"","Sec4_box3_image_path":"","Sec4_box4_image_path":"","Sec4_box5_image_path":"","Sec4_box6_image_path":"","Sec7_box1_image_path":"","Sec7_box2_image_path":"","Sec7_box3_image_path":"","Sec7_box4_image_path":"","Sec7_box5_image_path":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}',
                'content' =>
                '<section class="bg-body">
                        <div class="container">
                            <div class="row align-items-center g-4">
                                <div class="col-md-6 text-center mb-md-5">
                                    <img src="assets/images/landing/img-customize-1.svg" alt="img" class="img-fluid w-75" />
                                </div>
                                <div class="col-md-6">
                                    <h2 class="h1">Easy Developer Experience</h2>
                                    <p class="text-lg w-75 my-3 my-md-4">Smart Visitor has made it easy for developers of any skill level to
                                        use their product.</p>
                                    <ul class="list-unstyled customize-list">
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            A straightforward and simple folder structure.
                                        </li>
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            Code that is organized in a clear and logical manner.
                                        </li>
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            Setting up Typography and Color schemes is easy and effortless.
                                        </li>
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            Multiple layout options that can be easily adjusted.
                                        </li>
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            A theme that can be easily configured on a single page.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row align-items-center g-4">
                                <div class="col-md-6">
                                    <h2 class="h1">Figma Design System</h2>
                                    <p class="text-lg w-75 my-3 my-md-4">
                                        Streamlining the development process and saving you time and effort in the initial design phase.
                                    </p>
                                    <ul class="list-unstyled customize-list">
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            Professional Kit for Designer
                                        </li>
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            Properly Organised Pages
                                        </li>
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            Dark/Light Design
                                        </li>
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            *Figma file included only in Plus & Extended Licenses.
                                        </li>
                                        <li>
                                            <i class="ti ti-circle-check f-20 text-secondary"></i>
                                            A theme that can be easily configured on a single page.
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6 text-center mb-md-5">
                                    <img src="assets/images/landing/img-customize-2.svg" alt="img" class="img-fluid w-75" />
                                </div>
                            </div>
                        </div>
                    </section>'
            ],
            [
                'title' => 'Offer',
                'section' => 'Section 4',
                'content_value' => '{"name":"Offer","section_enabled":"active","Sec4_title":"What Our Software Offers","Sec4_info":"Our software provides powerful, scalable solutions designed to streamline your business operations.","Sec4_box1_title":"User-Friendly Interface","Sec4_box1_enabled":"active","Sec4_box1_info":"Simplify operations with an intuitive and easy-to-use platform.","Sec4_box2_title":"End-to-End Automation","Sec4_box2_enabled":"active","Sec4_box2_info":"Automate repetitive tasks to save time and increase efficiency.","Sec4_box3_title":"Customizable Solutions","Sec4_box3_enabled":"active","Sec4_box3_info":"Tailor features to fit your unique business needs and workflows.","Sec4_box4_title":"Scalable Features","Sec4_box4_enabled":"active","Sec4_box4_info":"Grow your business with flexible solutions that scale with you.","Sec4_box5_title":"Enhanced Security","Sec4_box5_enabled":"active","Sec4_box5_info":"Protect your data with advanced encryption and security protocols.","Sec4_box6_title":"Real-Time Analytics","Sec4_box6_enabled":"active","Sec4_box6_info":"Gain actionable insights with live data tracking and reporting.","Sec4_box1_image":{},"Sec4_box2_image":{},"Sec4_box3_image":{},"Sec4_box4_image":{},"Sec4_box5_image":{},"Sec4_box6_image":{},"section_footer_image_path":"","section_main_image_path":"","box_image_1_path":"","box_image_2_path":"","box_image_3_path":"","Box1_image_path":"","Box2_image_path":"","Sec4_box1_image_path":"upload\/homepage\/offers_1.svg","Sec4_box2_image_path":"upload\/homepage\/offers_2.svg","Sec4_box3_image_path":"upload\/homepage\/offers_3.svg","Sec4_box4_image_path":"upload\/homepage\/offers_4.svg","Sec4_box5_image_path":"upload\/homepage\/offers_5.svg","Sec4_box6_image_path":"upload\/homepage\/offers_6.svg","Sec7_box1_image_path":"","Sec7_box2_image_path":"","Sec7_box3_image_path":"","Sec7_box4_image_path":"","Sec7_box5_image_path":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}',
                'content' => '
                <section>
                    <div class="container">
                        <div class="row justify-content-center title">
                            <div class="col-md-9 col-lg-6 text-center">
                                <h2 class="h1">What does Smart Visitor offer?</h2>
                                <p class="text-lg">
                                    Smart Visitor is a reliable choice for your admin panel needs, offering a wide range of features to
                                    easily manage your backend panel
                                </p>
                            </div>
                        </div>
                        <div class="row g-4 text-center">
                            <div class="col-md-6 col-xl-4">
                                <img src="assets/images/landing/img-design-1.svg" alt="img" class="img-fluid" />
                                <h3 class="my-4 fw-semibold">Beautiful User Interface</h3>
                                <p>
                                    Smart Visitor can improve the user experience of your web application by providing a clear and intuitive
                                    layout, and consistent look
                                    and feel.
                                </p>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <img src="assets/images/landing/img-design-2.svg" alt="img" class="img-fluid" />
                                <h3 class="my-4 fw-semibold">Time and Cost Savings</h3>
                                <p>
                                    Smart Visitor can save developers time and effort by providing a pre-built user interface, allowing them
                                    to focus on other aspects of
                                    the project.
                                </p>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <img src="assets/images/landing/img-design-3.svg" alt="img" class="img-fluid" />
                                <h3 class="my-4 fw-semibold">Reduce Development Complexity</h3>
                                <p>Smart Visitor simplifies admin panel development with easy theme setup and clear code with flexible
                                    layouts options.</p>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <img src="assets/images/landing/img-design-4.svg" alt="img" class="img-fluid" />
                                <h3 class="my-4 fw-semibold">Improved Scalability</h3>
                                <p>
                                    Smart Visitor uses scalable technologies and resources to ensure that your admin panel remains efficient
                                    and effective as your needs
                                    evolve.
                                </p>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <img src="assets/images/landing/img-design-5.svg" alt="img" class="img-fluid" />
                                <h3 class="my-4 fw-semibold">Well-Documented and Supported</h3>
                                <p>
                                    With a range of resources including user guides, tutorials, and FAQs to help users understand
                                    and effectively use the Smart Visitor.
                                </p>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <img src="assets/images/landing/img-design-6.svg" alt="img" class="img-fluid" />
                                <h3 class="my-4 fw-semibold">Performance Centric</h3>
                                <p>Smart Visitor is a performance-centric dashboard template that is designed to deliver optimal performance
                                    for your admin panel.</p>
                            </div>
                        </div>
                    </div>
                </section>
                '
            ],
            [
                'title' => 'Pricing',
                'section' => 'Section 5',
                'content_value' => '{"name":"Pricing","section_enabled":"active","Sec5_title":"Flexible Pricing","Sec5_info":"Get started for free, upgrade later in our application.","section_footer_image_path":"","section_main_image_path":"","box_image_1_path":"","box_image_2_path":"","box_image_3_path":"","Box1_image_path":"","Box2_image_path":"","Sec4_box1_image_path":"","Sec4_box2_image_path":"","Sec4_box3_image_path":"","Sec4_box4_image_path":"","Sec4_box5_image_path":"","Sec4_box6_image_path":"","Sec7_box1_image_path":"","Sec7_box2_image_path":"","Sec7_box3_image_path":"","Sec7_box4_image_path":"","Sec7_box5_image_path":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}',
                'content' => '
                <section class="bg-body" id="pricing">
                    <div class="container">
                        <div class="row justify-content-center title">
                            <div class="col-md-9 col-lg-6 text-center">
                                <h2 class="h1">Affordable Pricing Based On Your Needs</h2>
                                <p class="text-lg">Smart Visitor has conceptul working apps like Chat, Inbox, E-commerce, Invoice,
                                    Kanban,and Calendar</p>
                            </div>
                        </div>
                        <div class="row text-center justify-content-center">
                            <!-- [ sample-page ] start -->
                            <div class="col-md-6 col-lg-4">
                                <div class="card price-card">
                                    <div class="card-body">
                                        <div class="price-icon">
                                            <i class="ti ti-motorbike bg-light-primary text-primary"></i>
                                        </div>
                                        <h2 class="mt-4">Standard</h2>
                                        <p class="mt-5">
                                            Create one end product for a client, transfer that end product to your client, charge
                                            them for your
                                            services. The license
                                            is then transferred to the client.
                                        </p>
                                        <div class="price-price">
                                            <sup>$</sup>
                                            69
                                            <span>/Lifetime</span>
                                        </div>
                                        <ul class="list-group list-group-flush product-list">
                                            <li class="list-group-item enable">One End Product</li>
                                            <li class="list-group-item enable">No attribution required</li>
                                            <li class="list-group-item">TypeScript</li>
                                            <li class="list-group-item">Figma Design Resources</li>
                                            <li class="list-group-item">Create Multiple Products</li>
                                            <li class="list-group-item">Create a SaaS Project</li>
                                            <li class="list-group-item">Resale Product</li>
                                            <li class="list-group-item">Separate sale of our UI Elements?</li>
                                        </ul>
                                        <a class="btn btn-outline-primary bg-light text-primary mt-4" href="#"
                                            role="button">Order Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="card price-card ">
                                    <div class="card-body">
                                        <div class="price-icon">
                                            <i class="ti ti-bus bg-light-primary text-primary"></i>
                                        </div>
                                        <h2 class="mt-4">Standard Plus</h2>
                                        <p class="mt-5">
                                            Create one end product for a client, transfer that end product to your client, charge
                                            them for your
                                            services. The license
                                            is then transferred to the client.
                                        </p>
                                        <div class="price-price">
                                            <sup>$</sup>
                                            129
                                            <span>/Lifetime</span>
                                        </div>
                                        <ul class="list-group list-group-flush product-list">
                                            <li class="list-group-item enable">One End Product</li>
                                            <li class="list-group-item enable">No attribution required</li>
                                            <li class="list-group-item enable">TypeScript</li>
                                            <li class="list-group-item enable">Figma Design Resources</li>
                                            <li class="list-group-item">Create Multiple Products</li>
                                            <li class="list-group-item">Create a SaaS Project</li>
                                            <li class="list-group-item">Resale Product</li>
                                            <li class="list-group-item">Separate sale of our UI Elements?</li>
                                        </ul>
                                        <a class="btn btn-outline-primary bg-light text-primary mt-4" href="#"
                                            role="button">Order Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="card price-card">
                                    <div class="card-body">
                                        <div class="price-icon">
                                            <i class="ti ti-sailboat bg-light-primary text-primary"></i>
                                        </div>
                                        <h2 class="mt-4">Extended</h2>
                                        <p class="mt-5">
                                            You are licensed to use the CONTENT to create one end product for yourself or for one
                                            client (a “single
                                            application”), and
                                            the end product may be sold or distributed for free.
                                        </p>
                                        <div class="price-price">
                                            <sup>$</sup>
                                            599
                                            <span>/Lifetime</span>
                                        </div>
                                        <ul class="list-group list-group-flush product-list">
                                            <li class="list-group-item enable">One End Product</li>
                                            <li class="list-group-item enable">No attribution required</li>
                                            <li class="list-group-item enable">TypeScript</li>
                                            <li class="list-group-item enable">Figma Design Resources</li>
                                            <li class="list-group-item">Create Multiple Products</li>
                                            <li class="list-group-item enable">Create a SaaS Project</li>
                                            <li class="list-group-item">Resale Product</li>
                                            <li class="list-group-item">Separate sale of our UI Elements?</li>
                                        </ul>
                                        <a class="btn btn-outline-primary bg-light text-primary mt-4" href="#"
                                            role="button">Order Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
                '
            ],
            [
                'title' => 'Core Features',
                'section' => 'Section 6',
                'content_value' => '{"name":"Core Features","section_enabled":"active","Sec6_title":"Core Features","Sec6_info":"Core Modules For Your Business","Sec6_Box_title":["Dashboard","Subscription Packages","Pre Visitor Register","Visitor Pass","Visitor Category"],"Sec6_Box_subtitle":["VMS is a comprehensive solution designed to enhance the efficiency, security, and overall experience associated with visitor interactions within a facility.","VMS is a comprehensive solution designed to enhance the efficiency, security, and overall experience associated with visitor interactions within a facility.","VMS is a comprehensive solution designed to enhance the efficiency, security, and overall experience associated with visitor interactions within a facility.","VMS is a comprehensive solution designed to enhance the efficiency, security, and overall experience associated with visitor interactions within a facility.","VMS is a comprehensive solution designed to enhance the efficiency, security, and overall experience associated with visitor interactions within a facility."],"Sec6_box_image":[{},{},{},{},{},{}],"section_footer_image_path":"","section_main_image_path":"","box_image_1_path":"","box_image_2_path":"","box_image_3_path":"","Box1_image_path":"","Box2_image_path":"","Sec4_box1_image_path":"","Sec4_box2_image_path":"","Sec4_box3_image_path":"","Sec4_box4_image_path":"","Sec4_box5_image_path":"","Sec4_box6_image_path":"","Sec6_box0_image_path":"upload\/homepage\/1.png","Sec6_box1_image_path":"upload\/homepage\/2.png","Sec6_box2_image_path":"upload\/homepage\/3.png","Sec6_box3_image_path":"upload\/homepage\/4.png","Sec6_box4_image_path":"upload\/homepage\/5.png","Sec6_box5_image_path":"upload\/homepage\/6.png","Sec6_box6_image_path":"","Sec7_box1_image_path":"","Sec7_box2_image_path":"","Sec7_box3_image_path":"","Sec7_box4_image_path":"","Sec7_box5_image_path":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}',
                'content' => '
                <section class="bg-primary application-slider" id="features">
                    <div class="container">
                        <div class="row justify-content-center title">
                            <div class="col-md-9 col-lg-6 text-center">
                                <h2 class="h1">Explore Concenputal Apps</h2>
                                <p class="text-lg">Smart Visitor has conceptul working apps like Chat, Inbox, E-commerce, Invoice, Kanban,
                                    and Calendar</p>
                            </div>
                        </div>
                        <div class="row text-center justify-content-center">
                            <div class="col-11 col-md-9 col-lg-7 position-relative">
                                <div class="swiper app-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="assets/images/landing/slider-light-1.png" alt="images"
                                                class="img-fluid" />
                                            <h3>
                                                Social Profile
                                                <i class="ti ti-link"></i>
                                            </h3>
                                            <p>Complete Social profile with all possible option</p>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="assets/images/landing/slider-light-2.png" alt="images"
                                                class="img-fluid" />
                                            <h3>
                                                Mail/Message App
                                                <i class="ti ti-link"></i>
                                            </h3>
                                            <p>Complete Mail/Message App with all possible option</p>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="assets/images/landing/slider-light-3.png" alt="images"
                                                class="img-fluid" />
                                            <h3>
                                                Mail/Message App
                                                <i class="ti ti-link"></i>
                                            </h3>
                                            <p>Complete Chat App with all possible option</p>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="assets/images/landing/slider-light-4.png" alt="images"
                                                class="img-fluid" />
                                            <h3>
                                                Kanban App
                                                <i class="ti ti-link"></i>
                                            </h3>
                                            <p>Complete Kanban App with all possible option</p>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="assets/images/landing/slider-light-5.png" alt="images"
                                                class="img-fluid" />
                                            <h3>
                                                Calendar App
                                                <i class="ti ti-link"></i>
                                            </h3>
                                            <p>Complete Calendar App with all possible option</p>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="assets/images/landing/slider-light-6.png" alt="images"
                                                class="img-fluid" />
                                            <h3>
                                                Ecommerce App
                                                <i class="ti ti-link"></i>
                                            </h3>
                                            <p>Complete Ecommerce App with all possible option</p>
                                        </div>
                                    </div>
                                    <div class="swiper-button-next avtar">
                                        <i class="ti ti-chevron-right"></i>
                                    </div>
                                    <div class="swiper-button-prev avtar">
                                        <i class="ti ti-chevron-left"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                '
            ],
            [
                'title' => 'Testimonials',
                'section' => 'Section 7',
                'content_value' => '{"name":"Testimonials","section_enabled":"active","Sec7_title":"What Our Customers Say About Us","Sec7_info":"We\u2019re proud of the impact our software has had on businesses just like yours. Hear directly from our customers about how our solutions have made a difference in their day-to-day operations","Sec7_box1_name":"Lenore Becker","Sec7_box1_tag":null,"Sec7_box1_Enabled":"active","Sec7_box1_review":"Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum rutrum, mi nec elementum vehicula, eros quam gravida nisl, id fringilla neque ante vel mi. Quisque ut nisi. Nulla porta dolor. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc.","Sec7_box2_name":"Damian Morales","Sec7_box2_tag":"New","Sec7_box2_Enabled":"active","Sec7_box2_review":"Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum rutrum.","Sec7_box3_name":"Oleg Lucas","Sec7_box3_tag":null,"Sec7_box3_Enabled":"active","Sec7_box3_review":"Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum rutrum, mi nec elementum vehicula, eros quam gravida nisl, id fringilla neque ante vel mi. Quisque ut nisi. Nulla porta dolor. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc.","Sec7_box4_name":"Jerome Mccoy","Sec7_box4_tag":null,"Sec7_box4_Enabled":"active","Sec7_box4_review":"Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum rutrum, mi nec elementum vehicula, eros quam gravida nisl, id fringilla neque ante vel mi. Quisque ut nisi. Nulla porta dolor. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc.","Sec7_box5_name":"Rafael Carver","Sec7_box5_tag":null,"Sec7_box5_Enabled":"active","Sec7_box5_review":"Aenean leo ligula, porttitor eu, consequat vitae, eleifend.","Sec7_box6_name":"Edan Rodriguez","Sec7_box6_tag":null,"Sec7_box6_Enabled":"active","Sec7_box6_review":"Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum rutrum, mi nec elementum vehicula, eros quam gravida nisl, id fringilla neque ante vel mi. Quisque ut nisi. Nulla porta dolor. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc.","Sec7_box7_name":"Kalia Middleton","Sec7_box7_tag":null,"Sec7_box7_Enabled":"active","Sec7_box7_review":"Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum rutrum, mi nec elementum.","Sec7_box8_name":"Zenaida Chandler","Sec7_box8_tag":null,"Sec7_box8_Enabled":"active","Sec7_box8_review":"Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum rutrum, mi nec elementum vehicula, eros quam gravida nisl, id fringilla neque ante vel mi. Quisque ut nisi. Nulla porta dolor. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc.","Sec7_box1_image":{},"Sec7_box2_image":{},"Sec7_box3_image":{},"Sec7_box4_image":{},"Sec7_box5_image":{},"Sec7_box6_image":{},"Sec7_box7_image":{},"Sec7_box8_image":{},"section_footer_image_path":"","section_main_image_path":"","box_image_1_path":"","box_image_2_path":"","box_image_3_path":"","Box1_image_path":"","Box2_image_path":"","Sec4_box1_image_path":"","Sec4_box2_image_path":"","Sec4_box3_image_path":"","Sec4_box4_image_path":"","Sec4_box5_image_path":"","Sec4_box6_image_path":"","Sec7_box1_image_path":"upload\/homepage\/review_1.png","Sec7_box2_image_path":"upload\/homepage\/review_2.png","Sec7_box3_image_path":"upload\/homepage\/review_3.png","Sec7_box4_image_path":"upload\/homepage\/review_4.png","Sec7_box5_image_path":"upload\/homepage\/review_5.png","Sec7_box6_image_path":"upload\/homepage\/review_6.png","Sec7_box7_image_path":"upload\/homepage\/review_7.png","Sec7_box8_image_path":"upload\/homepage\/review_8.png"}',
                'content'  => '
                <section>
                    <div class="container">
                        <div class="row justify-content-center title">
                            <div class="col-md-9 col-lg-6 text-center">
                                <h2 class="h1">Testaments</h2>
                                <p class="text-lg">We are so grateful for your positive review and appreciate your support of our
                                    product</p>
                            </div>
                        </div>
                        <div class="testaments-cards">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-l">
                                                <img src="assets/images/user/avatar-1.jpg" alt="img"
                                                    class="img-fluid rounded-circle wid-40" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h4 class="mb-0">Nelu</h4>
                                            <h6 class="mb-0 text-primary">@Quality Support</h6>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        This is a quality team with quality support. Number of available modules is incredible.
                                        Anytime I thought "oh I wish it had
                                        this" I was able to find exactly that already pre-made in the template.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-l">
                                                <img src="assets/images/user/avatar-2.jpg" alt="img"
                                                    class="img-fluid rounded-circle wid-40" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h4 class="mb-0">Bente</h4>
                                            <h6 class="mb-0 text-primary">@Customer Support</h6>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        Very good customer service! I liked the design and there was nothing wrong, but found out
                                        after testing that it did not
                                        quite match the functionality and overall design that I needed for my type of software. I
                                        therefore contacted customer
                                        service and it was no problem even though the deadline for refund had actually expired.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-l">
                                                <img src="assets/images/user/avatar-3.jpg" alt="img"
                                                    class="img-fluid rounded-circle wid-40" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h4 class="mb-0">William</h4>
                                            <h6 class="mb-0 text-primary">@Code Quality</h6>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        One of the better themes I have used. Beautiful and clean design. Also included a NextJS
                                        project. Ultimately it didnt work
                                        out for my specific use case, but this is a well organized theme. Definitely keeping it in
                                        mind for future projects.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-l">
                                                <img src="assets/images/user/avatar-4.jpg" alt="img"
                                                    class="img-fluid rounded-circle wid-40" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h4 class="mb-0">Besart</h4>
                                            <h6 class="mb-0 text-primary">@Customizability</h6>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        Very well written code and good structure. Very customizable and tons of nice components.
                                        Good documentation. Team is very
                                        responsive too
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-l">
                                                <img src="assets/images/user/avatar-5.jpg" alt="img"
                                                    class="img-fluid rounded-circle wid-40" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h4 class="mb-0">Dillon</h4>
                                            <h6 class="mb-0 text-primary">@Codebase</h6>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        The project template is great, as well as the codebase. I am a backend developer, new to
                                        frontend and learning. So this
                                        template is turning out to be a great foundation...
                                    </p>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-l">
                                                <img src="assets/images/user/avatar-1.jpg" alt="img"
                                                    class="img-fluid rounded-circle wid-40" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h4 class="mb-0">Nelu</h4>
                                            <h6 class="mb-0 text-primary">@Quality Support</h6>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        This is a quality team with quality support. Number of available modules is incredible.
                                        Anytime I thought "oh I wish it had
                                        this" I was able to find exactly that already pre-made in the template.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-l">
                                                <img src="assets/images/user/avatar-2.jpg" alt="img"
                                                    class="img-fluid rounded-circle wid-40" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h4 class="mb-0">Bente</h4>
                                            <h6 class="mb-0 text-primary">@Customer Support</h6>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        Very good customer service! I liked the design and there was nothing wrong, but found out
                                        after testing that it did not
                                        quite match the functionality and overall design that I needed for my type of software. I
                                        therefore contacted customer
                                        service and it was no problem even though the deadline for refund had actually expired.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avtar avtar-l">
                                                <img src="assets/images/user/avatar-3.jpg" alt="img"
                                                    class="img-fluid rounded-circle wid-40" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h4 class="mb-0">William</h4>
                                            <h6 class="mb-0 text-primary">@Code Quality</h6>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        One of the better themes I have used. Beautiful and clean design. Also included a NextJS
                                        project. Ultimately it didnt work
                                        out for my specific use case, but this is a well organized theme. Definitely keeping it in
                                        mind for future projects.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
                '
            ],
            [
                'title' => 'Choose US',
                'section' => 'Section 8',
                'content_value' => '{"name":"Choose US","section_enabled":"active","Sec8_title":"Reason to Choose US","Sec8_box1_info":"Proven Expertise","Sec8_box2_info":"Customizable Solutions","Sec8_box3_info":"Seamless Integration","Sec8_box4_info":"Exceptional Support","Sec8_box5_info":"Scalable and Future-Proof","Sec8_box6_info":"Security You Can Trust","Sec8_box7_info":"User-Friendly Interface","Sec8_box8_info":"Innovation at Its Core","section_footer_image_path":"","section_main_image_path":"","box_image_1_path":"","box_image_2_path":"","box_image_3_path":"","Box1_image_path":"","Box2_image_path":"","Sec4_box1_image_path":"","Sec4_box2_image_path":"","Sec4_box3_image_path":"","Sec4_box4_image_path":"","Sec4_box5_image_path":"","Sec4_box6_image_path":"","Sec7_box1_image_path":"","Sec7_box2_image_path":"","Sec7_box3_image_path":"","Sec7_box4_image_path":"","Sec7_box5_image_path":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}',
                'content' => '
                <section class="bg-dark choose-section">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <h2 class="mb-0 text-white">Choose Smart Visitor for</h2>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="swiper choose-slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <h2>Highly Responsive</h2>
                                                </div>
                                                <div class="swiper-slide">
                                                    <h2>Design Consistency</h2>
                                                </div>
                                                <div class="swiper-slide">
                                                    <h2>Effective Support</h2>
                                                </div>
                                                <div class="swiper-slide">
                                                    <h2>Standardization</h2>
                                                </div>
                                                <div class="swiper-slide">
                                                    <h2>Compatibility</h2>
                                                </div>
                                                <div class="swiper-slide">
                                                    <h2>Easy Customizability</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-none d-md-block">
                                <img src="assets/images/landing/img-bg-hand.png" alt="img" class="img-fluid hand-img" />
                            </div>
                        </div>
                    </div>
                </section>
                '
            ],
            [
                'title' => 'FAQ',
                'section' => 'Section 9',
                'content_value' => '{"name":"FAQ","section_enabled":"active","Sec9_title":"Frequently Asked Questions (FAQ)","Sec9_info":"Please refer the Frequently ask question for your quick help","section_footer_image_path":"","section_main_image_path":"","box_image_1_path":"","box_image_2_path":"","box_image_3_path":"","Box1_image_path":"","Box2_image_path":"","Sec4_box1_image_path":"","Sec4_box2_image_path":"","Sec4_box3_image_path":"","Sec4_box4_image_path":"","Sec4_box5_image_path":"","Sec4_box6_image_path":"","Sec7_box1_image_path":"","Sec7_box2_image_path":"","Sec7_box3_image_path":"","Sec7_box4_image_path":"","Sec7_box5_image_path":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}',
                'content' => '
                <section class="frameworks-section" id="faqs">
                    <div class="container">
                        <div class="row justify-content-center title">
                            <div class="col-md-9 col-lg-6 text-center">
                                <h2 class="h1">FAQ</h2>
                                <p class="text-lg">Please refer the Frequently ask question for your quick help
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button text-muted" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false">
                                        <b>when do I need Extended License?</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                        If your End Product which is sold - Then only your required Extended License. i.e. If you take
                                        subscription charges
                                        (monthly, yearly, etc...) from your end users in this case you required Extended License.
                                        </div>
                                    </div>
                                    </div>
                                    <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed text-muted" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        <b>What Support Includes?</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                        6 Months of Support Includes with 1 year of free updates. We are happy to solve your bugs, issue.
                                        </div>
                                    </div>
                                    </div>
                                    <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed text-muted" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                        <b>Is Smart Visitor Support Typescript?</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                        Yes, Smart Visitor Support the TypeScript and it is only available in Plus and Extended License.
                                        </div>
                                    </div>
                                    </div>
                                    <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingfour">
                                        <button class="accordion-button collapsed text-muted" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse-four" aria-expanded="false" aria-controls="flush-collapseThree">
                                        <b>Is there any Road map for Smart Visitor?</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapse-four" class="accordion-collapse collapse" aria-labelledby="flush-headingfour"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                        Smart Visitor is our flagship React Dashboard Template and we always add the new features for the long
                                        run. You can check
                                        the Road map in Documentation.
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                '
            ],
            [
                'title' => 'AboutUS - Footer',
                'section' => 'Section 10',
                'content_value' => '{"name":"AboutUS - Footer","section_enabled":"active","Sec10_title":"Smart Visitor","Sec10_info":"A Visitor Management System (VMS) is a comprehensive solution designed to enhance the efficiency, security, and overall experience associated with visitor interactions within a facility.","section_footer_image_path":"","section_main_image_path":"","box_image_1_path":"","box_image_2_path":"","box_image_3_path":"","Box1_image_path":"","Box2_image_path":"","Sec4_box1_image_path":"","Sec4_box2_image_path":"","Sec4_box3_image_path":"","Sec4_box4_image_path":"","Sec4_box5_image_path":"","Sec4_box6_image_path":"","Sec7_box1_image_path":"","Sec7_box2_image_path":"","Sec7_box3_image_path":"","Sec7_box4_image_path":"","Sec7_box5_image_path":"","Sec7_box6_image_path":"","Sec7_box7_image_path":"","Sec7_box8_image_path":""}',
                'content' => '
                <footer class="bg-dark footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                                <img src="assets/images/logo-white.svg" alt="image" class="img-fluid" />
                                <h4 class="my-3 text-white">About Smart Visitor</h4>
                                <p class="mb-4 text-white text-opacity-75">
                                    Smart Visitor React is a dashboard template that utilizes the Material-UI framework and the React
                                    JavaScript library. It offers a
                                    range of features and customization options to help you create a powerful and user-friendly
                                    admin panel.
                                </p>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-4">
                                    <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">Help</h5>
                                        <ul class="list-unstyled footer-link">
                                            <li><a href="#" target="_blank">Blog</a></li>
                                            <li><a href="#" target="_blank">Documentation</a>
                                            </li>
                                            <li><a href="#" target="_blank">Change
                                                    Log</a></li>
                                            <li><a href="#" target="_blank">Support</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">Store Help</h5>
                                        <ul class="list-unstyled footer-link">
                                            <li><a href="https://mui.com/store/license/" target="_blank">License</a></li>
                                            <li><a href="https://mui.com/store/customer-refund-policy/" target="_blank">Refund
                                                    Policy</a></li>
                                            <li>
                                                <a href="https://support.mui.com/hc/en-us/sections/360002564979-For-customers"
                                                    target="_blank">Submit a Request</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">Smart Visitor Eco-System</h5>
                                        <ul class="list-unstyled footer-link">
                                            <li><a href="#" target="_blank">Bootstrap 5</a></li>
                                            <li><a href="#" target="_blank">Angular</a></li>
                                            <li><a href="#" target="_blank">CodeIgniter</a></li>
                                            <li><a href="#" target="_blank">.Net</a></li>
                                            <li>
                                                <a href="/" target="_blank">
                                                    Shopify
                                                    <div><span class="badge bg-light-primary ms-2">Upcoming</span></div>
                                                </a>
                                            </li>
                                            <li><a href="#" target="_blank">Vuetify 3</a></li>
                                            <li><a href="#" target="_blank">Full Stack</a></li>
                                            <li><a href="#" target="_blank">Django</a></li>
                                            <li><a href="#" target="_blank">Flask</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-6 col-md-3 wow fadeInUp" data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">Free Versions</h5>
                                        <ul class="list-unstyled footer-link">
                                            <li><a href="#" target="_blank">Free React MUI</a>
                                            </li>
                                            <li><a href="#" target="_blank">Free Bootstrap 5</a>
                                            </li>
                                            <li><a href="#" target="_blank">Free Angular</a>
                                            </li>
                                            <li><a href="#" target="_blank">Free Django</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sub-footer">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col my-1 wow fadeInUp" data-wow-delay="0.4s">
                                    <p class="mb-0 text-white text-opacity-75">
                                        ' . __('Copyright') . ' ' . date('Y') . ' ' . env('APP_NAME') . '
                                    </p>
                                </div>
                                <div class="col-auto my-1">
                                    <ul class="list-inline footer-sos-link mb-0">
                                        <li class="list-inline-item wow fadeInUp" data-wow-delay="0.4s">
                                            <a href="#" class="link-primary">
                                                <svg class="pc-icon">
                                                    <use xlink:href="#custom-facebook"></use>
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                '
            ],
        ];

        foreach ($retuen as $key => $value) {
            $HomePage = new HomePage();
            $HomePage->title = $value['title'];
            $HomePage->content = $value['content'];
            $HomePage->section = $value['section'];
            if (!empty($value['content_value'])) {
                $HomePage->content_value = $value['content_value'];
            }
            $HomePage->enabled = 1;
            $HomePage->parent_id = 1;
            $HomePage->save();
        }
        return '';
    }
}

if (!function_exists('CustomPage')) {
    function CustomPage()
    {
        $retuen = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy_policy',
                'content' => "<h3><strong>1. Information We Collect</strong></h3><p>We may collect the following types of information from you:</p><h4><strong>a. Personal Information</strong></h4><ul><li>Name, email address, phone number, and other contact details.</li><li>Payment information (if applicable).</li></ul><h4><strong>b. Non-Personal Information</strong></h4><ul><li>Browser type, operating system, and device information.</li><li>Usage data, including pages visited, time spent, and other analytical data.</li></ul><h4><strong>c. Information You Provide</strong></h4><ul><li>Information you voluntarily provide when contacting us, signing up, or completing forms.</li></ul><h4><strong>d. Cookies and Tracking Technologies</strong></h4><ul><li>We use cookies, web beacons, and other tracking tools to enhance your experience and analyze usage patterns.</li></ul><h3><strong>2. How We Use Your Information</strong></h3><p>We use the information collected for the following purposes:</p><ul><li>To provide, maintain, and improve our Services.</li><li>To process transactions and send you confirmations.</li><li>To communicate with you, including responding to inquiries or providing updates.</li><li>To personalize your experience and deliver tailored content.</li><li>To comply with legal obligations and protect against fraud or misuse.</li></ul><h3><strong>3. How We Share Your Information</strong></h3><p>We do not sell your personal information. However, we may share your information with:</p><ul><li><strong>Service Providers:</strong> Third-party vendors who assist in providing our Services.</li><li><strong>Legal Authorities:</strong> When required to comply with legal obligations or protect our rights.</li><li><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets, your information may be transferred.</li></ul><h3><strong>4. Data Security</strong></h3><p>We implement appropriate technical and organizational measures to protect your data against unauthorized access, disclosure, alteration, or destruction. However, no method of transmission or storage is 100% secure, and we cannot guarantee absolute security.</p><h3><strong>5. Your Rights</strong></h3><p>You have the right to:</p><ul><li>Access, correct, or delete your personal data.</li><li>Opt-out of certain data processing activities, including marketing communications.</li><li>Withdraw consent where processing is based on consent.</li></ul><p>To exercise your rights, please contact us at [contact email].</p><h3><strong>6. Third-Party Links</strong></h3><p>Our Services may contain links to third-party websites. We are not responsible for the privacy practices or content of these websites. Please review their privacy policies before engaging with them.</p><h3><strong>7. Children's Privacy</strong></h3><p>Our Services are not intended for children under the age of [13/16], and we do not knowingly collect personal information from them. If we become aware that a child has provided us with personal data, we will take steps to delete it.</p><h3><strong>8. Changes to This Privacy Policy</strong></h3><p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised 'Last Updated' date. Your continued use of the Services after such changes constitutes your acceptance of the new terms.</p><h3>&nbsp;</h3>"
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms_conditions',
                'content' => "<h3><strong>1. Acceptance of Terms</strong></h3><p>By using our Services, you confirm that you are at least [18 years old or the legal age in your jurisdiction] and capable of entering into a binding agreement. If you are using our Services on behalf of an organization, you represent that you have the authority to bind that organization to these Terms.</p><h3><strong>2. Use of Services</strong></h3><p>You agree to use our Services only for lawful purposes and in accordance with these Terms. You must not:</p><ul><li>Violate any applicable laws or regulations.</li><li>Use our Services in a manner that could harm, disable, overburden, or impair them.</li><li>Attempt to gain unauthorized access to our systems or networks.</li><li>Transmit any harmful code, viruses, or malicious software.</li></ul><h3><strong>3. User Accounts</strong></h3><p>If you create an account with us, you are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You agree to notify us immediately of any unauthorized use of your account or breach of security.</p><h3><strong>4. Intellectual Property</strong></h3><p>All content, trademarks, logos, and intellectual property associated with our Services are owned by [Your Company Name] or our licensors. You are granted a limited, non-exclusive, non-transferable license to access and use the Services for personal or authorized business purposes. Any unauthorized use, reproduction, or distribution is prohibited.</p><h3><strong>5. Payment and Billing</strong> (if applicable)</h3><p>If our Services involve payments:</p><ul><li>All fees are due at the time of purchase unless otherwise agreed.</li><li>We reserve the right to change pricing or introduce new fees with prior notice.</li><li>Refunds, if applicable, will be handled according to our [Refund Policy].</li></ul><h3><strong>6. Termination of Services</strong></h3><p>We reserve the right to suspend or terminate your access to our Services at our discretion, without prior notice, if:</p><ul><li>You breach these Terms.</li><li>We are required to do so by law.</li><li>Our Services are discontinued or altered.</li></ul><h3><strong>7. Limitation of Liability</strong></h3><p>To the fullest extent permitted by law:</p><ul><li>[Your Company Name] and its affiliates shall not be liable for any direct, indirect, incidental, or consequential damages resulting from your use of our Services.</li><li>Our liability is limited to the amount you paid, if any, for accessing our Services.</li></ul><h3><strong>8. Indemnification</strong></h3><p>You agree to indemnify and hold [Your Company Name], its affiliates, employees, and partners harmless from any claims, liabilities, damages, losses, or expenses arising from your use of the Services or violation of these Terms.</p><h3><strong>9. Modifications to Terms</strong></h3><p>We may update these Terms from time to time. Any changes will be effective immediately upon posting, and your continued use of the Services constitutes your acceptance of the revised Terms.</p>"
            ],
        ];
        foreach ($retuen as $key => $value) {
            $Page = new Page();
            $Page->title = $value['title'];
            $Page->slug = $value['slug'];
            $Page->content = $value['content'];
            $Page->enabled = 1;
            $Page->parent_id = 1;
            $Page->save();
        }


        $FAQ_retuen = [
            [
                'question' => 'What features does your software offer?',
                'description' => 'Our software provides a range of features including automation tools, real-time analytics, cloud-based access, secure data storage, seamless integrations, and customizable solutions tailored to your business needs.',
            ],
            [
                'question' => 'Is your software easy to use?',
                'description' => 'Yes! Our platform is designed to be user-friendly and intuitive, so your team can get started quickly without a steep learning curve.',
            ],
            [
                'question' => 'Can I integrate your software with my existing systems?',
                'description' => 'Absolutely! Our software is built to easily integrate with your current tools and systems, making the transition seamless and efficient.',
            ],
            [
                'question' => 'Is customer support available?',
                'description' => 'Yes! We offer 24/7 customer support. Our dedicated team is ready to assist you with any questions or issues you may have.',
            ],
            [
                'question' => 'Is my data secure with your software?',
                'description' => 'Yes. We use advanced encryption and data protection protocols to ensure your data is secure and private at all times.',
            ],
            [
                'question' => 'Can I customize the software to fit my business needs?',
                'description' => 'Yes! Our software is highly customizable to adapt to your unique workflows and requirements.',
            ],
            [
                'question' => 'What types of businesses can benefit from your software?',
                'description' => 'Our solutions are suitable for a wide range of industries, including retail, healthcare, finance, marketing, and more. We tailor our offerings to meet the specific needs of each business.',
            ],

            [
                'question' => 'Is there a free trial available?',
                'description' => 'Yes! We offer a free trial so you can explore the features and capabilities of our software before committing.',
            ],

            [
                'question' => 'Do I need technical expertise to use the software?',
                'description' => 'Not at all. Our software is designed for users of all skill levels. Plus, our support team is available to guide you through any setup or usage questions.',
            ],

            [
                'question' => 'How often is the software updated?',
                'description' => 'We regularly release updates to improve features, security, and overall performance, ensuring that you always have access to the latest technology.',
            ],
        ];
        foreach ($FAQ_retuen as $key => $FAQ_value) {
            $FAQs = new FAQ();
            $FAQs->question = $FAQ_value['question'];
            $FAQs->description = $FAQ_value['description'];
            $FAQs->enabled = 1;
            $FAQs->parent_id = 1;
            $FAQs->save();
        }
        return '';
    }
}
if (!function_exists('DefaultCustomPage')) {
    function DefaultCustomPage()
    {
        $return = Page::where('enabled', 1)->whereIn('id', [1, 2])->get();
        return $return;
    }
}

if (!function_exists('DefaultBankTransferPayment')) {
    function DefaultBankTransferPayment()
    {
        $bankArray = [
            'bank_transfer_payment' => 'on',
            'bank_name' => 'Bank of America',
            'bank_holder_name' => 'SmartWeb Infotech',
            'bank_account_number' => '4242 4242 4242 4242',
            'bank_ifsc_code' => 'BOA45678',
            'bank_other_details' => '',
        ];

        foreach ($bankArray as $key => $val) {
            \DB::insert(
                'insert into settings (`value`, `name`, `type`,`parent_id`) values (?, ?, ?,?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                [
                    $val,
                    $key,
                    'payment',
                    1,
                ]
            );
        }

        return '';
    }
}

if (!function_exists('QrCode2FA')) {
    function QrCode2FA()
    {
        $user = Auth::user();

        $google2fa = new Google2FA();

        // generate a secret
        $secret = $google2fa->generateSecretKey();

        // generate the QR code, indicating the address
        // of the web application and the user name
        // or email in this case
        $company = env('APP_NAME');
        if ($user->type != 'super admin') {
            $company = isset(settings()['company_name']) && !empty(settings()['company_name']) ? settings()['company_name'] : $company;
        }

        $qr_code = $google2fa->getQRCodeInline(
            $company,
            $user->email,
            $secret
        );

        // store the current secret in the session
        // will be used when we enable 2FA (see below)
        session(["2fa_secret" => $secret]);

        return $qr_code;
    }
}

if (!function_exists('authPage')) {
    function authPage($id)
    {

        $templateData = [
            'title' => [
                "Secure Access, Seamless Experience.",
                "Your Trusted Gateway to Digital Security.",
                "Fast, Safe & Effortless Login."
            ],
            'description' => [
                "Securely access your account with ease. Whether you're logging in, signing up, or resetting your password, we ensure a seamless and protected experience. Your data, your security, our priority.",
                "Fast, secure, and hassle-free authentication. Sign in with confidence and experience a seamless way to access your account—because your security matters.",
                "A seamless and secure way to access your account. Whether you're logging in, signing up, or recovering your password, we ensure your data stays protected at every step."
            ],
        ];

        $authPage = new AuthPage();
        $authPage->title = json_encode($templateData['title']);
        $authPage->description = json_encode($templateData['description']);
        $authPage->section = 1;
        $authPage->image = 'upload/images/auth_page.svg';
        $authPage->parent_id = $id;
        $authPage->save();

        $createdTemplates[] = $authPage;

        return $createdTemplates;
    }
}

if (!function_exists('getMarkup')) {
    function getMarkup($seriesId, $price)
    {
       $markup = DB::table('elitevw_master_markup')
            ->where('series_id', $seriesId)
            ->value('percentage');

        if ($markup) {
            $price = round($price * (1 + $markup / 100), 2);
        }
        
        return $price;
    }
}

if(!function_exists('quoteToOrder')) {
    function quoteToOrder($quote)
    {
        try {
            DB::beginTransaction();
            // Create Order
            $order = Order::create([
                'quote_id'          => $quote->id,
                'customer_id'       => $quote->customer->id,
                'order_number'      => 'O' . str_pad(Order::max('id') + 1, 6, '0', STR_PAD_LEFT),
                'invoice_date'      => now()->toDateString(),
                'net_price'         => $quote->items->sum('total'),
                'surcharge'         => $quote->surcharge,
                'sub_total'         => $quote->sub_total,
                'tax'               => $quote->tax,
                'total'             => $quote->total,
                'status'            => 'draft',
                'notes'             => $quote->notes,
                'paid_amount'       => 0,
                'remaining_amount'  => $quote->total,
                'expected_delivery_date' => $quote->expected_delivery,
                'approved_by'       => null,
                'entered_by'        => auth()->user()->id,
                'due_date'          => now()->addDays(14)->toDateString(),
                'work_order_number' => 'WO' . str_pad(Order::max('id') + 1, 6, '0', STR_PAD_LEFT),
            ]);

            // Create Order Items from Quote Items
            foreach ($quote->items as $item) {
                $order->items()->create([
                    'series_id' => $item->series_id,
                    'series_type' => $item->series_type,
                    'description' => $item->description,
                    'width' => $item->width,
                    'height' => $item->height,
                    'glass' => $item->glass,
                    'grid' => $item->grid,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'total' => $item->total,
                    'item_comment' => $item->item_comment,
                    'internal_note' => $item->internal_note,
                    'color_config' => $item->color_config,
                    'color_exterior' => $item->color_exterior,
                    'color_interior' => $item->color_interior,
                    'frame_type' => $item->frame_type,
                    'fin_type' => $item->fin_type,
                    'glass_type' => $item->glass_type,
                    'spacer' => $item->spacer,
                    'tempered' => $item->tempered,
                    'specialty_glass' => $item->specialty_glass,
                    'grid_pattern' => $item->grid_pattern,
                    'grid_profile' => $item->grid_profile,
                    'retrofit_bottom_only' => $item->retrofit_bottom_only,
                    'no_logo_lock' => $item->no_logo_lock,
                    'double_lock' => $item->double_lock,
                    'custom_lock_position' => $item->custom_lock_position,
                    'custom_vent_latch' => $item->custom_vent_latch,
                    'knocked_down' => $item->knocked_down,
                    'checked_count' => $item->checked_count,
                ]);
            }
            DB::commit();

            return $order;
        }  catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error('Error converting quote to order: ' . $e->getMessage());
            return null;
        }
    }
}

if(!function_exists('quoteToInvoice')) {
    function quoteToInvoice($quote, $order)
    {
            $invoice = Invoice::create([
                'order_id' => $order->id,
                'quote_id' => $quote->id,
                'invoice_number' => generateInvoiceNumber(),
                'work_order' => 'WO' . $order->id,
                'due_date' => now()->addDays(14)->format('Y-m-d'),
                'entered_by' => auth()->user()->name,
                'status' => 'Pending',
                'quote_id' => $quote->id,
                'order_id' => $order->id,
                'customer_id' => $quote->customer?->id,
                'invoice_date' => now(),
                'total' => $quote->total,
                'tax' => $quote->tax,
                'net_price' => $quote->sub_total,
                'surcharge' => $quote->surcharge,
                'paid_amount' => 0,
                'remaining_amount' => $quote->total,
                'status' => 'Pending',
                'notes' => null,
                'payment_method' => null,
                'gateway_response' => null,
            ]);

            $firstServe = new FirstServe();
            $firstServeInvoice = $firstServe->createInvoice($invoice);

            if($firstServeInvoice) {
                $invoice->update([
                    'gateway_response' => json_encode($firstServeInvoice),
                    'serve_invoice_id' => $firstServeInvoice['id'],
                    'payment_link' => $firstServeInvoice['payment_link'],
                ]);

                $mail = new InvoiceMail($invoice);
                $mail->to($invoice->customer->email)->send($mail);
            }

        return $invoice;
    }
}

if(!function_exists('generateInvoiceNumber')) {
    function generateInvoiceNumber()
    {
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        return 'INV-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
}