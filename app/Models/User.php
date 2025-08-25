<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use Impersonate;


    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'phone_number',
        'profile',
        'lang',
        'subscription',
        'subscription_expire_date',
        'parent_id',
        'is_active',
        'twofa_secret',
        'code',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canImpersonate()
    {
        // Example: Only admins can impersonate others
        return $this->type == 'super admin';
    }

    public function station()
{
    return $this->belongsTo(\App\Models\Manufacturing\Station::class);
}


    public function totalUser()
    {
        return User::whereNotIn('type', ['tenant', 'maintainer'])->where('parent_id', $this->id)->count();
    }
    public function totalTenant()
    {
        return User::where('type', 'tenant')->where('parent_id', $this->id)->count();
    }

    public function totalContact()
    {
        return Contact::where('parent_id', '=', parentId())->count();
    }

    public function roleWiseUserCount($role)
    {
        return User::where('type', $role)->where('parent_id', parentId())->count();
    }

    public static function getDevice($user)
    {
        $mobileType = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
        $tabletType = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';
        if (preg_match_all($mobileType, $user)) {
            return 'mobile';
        } else {
            if (preg_match_all($tabletType, $user)) {
                return 'tablet';
            } else {
                return 'desktop';
            }
        }
    }

    public function subscriptions()
    {
        return $this->hasOne('App\Models\Subscription', 'id', 'subscription');
    }

    public static $systemModules = [
        'user',
        'contact',
        'note',
        'logged history',
        'settings',
        'visitor',
        'visit category',
        'pricing transation',
        'orders', 
        'carts', 
        'deliveries', 
        'pickups', 
        'trucks', 
        'routes', 
        'sr',

    ];

    public function SubscriptionLeftDay()
    {
        $Subscription = Subscription::find($this->subscription);
        if ($Subscription->interval == 'Unlimited') {
            $return = '<span class="text-success">'.__('Unlimited Days Left').'</span>';
        } else {
            $date1 = date_create(date('Y-m-d'));
            $date2 = date_create($this->subscription_expire_date);
            $diff = date_diff($date1, $date2);
            $days = $diff->format("%R%a");
            if($days > 0) {
                $return = '<span class="text-success">'.$days.__(' Days Left').'</span>';
            } else {
                $return = '<span class="text-danger">'.$days.__(' Days Left').'</span>';
            }
        }


        return $return;
    }
    
    public function getProfileAttribute($value)
    {
        if ($value && $value != 'avatar.png') {
            return Storage::url(ltrim($value, '/'));
        } else {
            return asset('assets/images/avatar.png');
        }
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function assignedLeads()
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }



}
