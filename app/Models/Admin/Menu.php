<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'elitevw_enterprise_menus';

    protected $guarded = [];

    /**
     * Get the child menus (submenus).
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get the parent menu.
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Scope to retrieve only top-level menus.
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id')->orderBy('order');
    }
    
    public function roles()
{
    return $this->belongsToMany(\App\Models\User::class, 'menu_role', 'menu_id', 'role_id');
}

protected $casts = [
    'roles' => 'array',
];


}
