<?php

namespace App\Models;


use App\Models\Interfaces\AdminUserPermissionsInterface;
use App\Models\Scopes\PermissionScope;
use Illuminate\Database\Eloquent\Model;

class AdminUserPermissions extends Model implements AdminUserPermissionsInterface
{

    /**
     * Table name.
     *
     * @var array
     */
    public $table = 'admin_users_permissions';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PermissionScope);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];


    /**
     * Get all the permissions list from config file.
     *
     * @var array
     */

    function scopeGetAllPermissions()
    {
        return config('permissions');
    }

    /**
     * Get all the permissions list from config file.
     *
     * @var array
     */

    function scopeGetAllDashboardCardPermissions()
    {
        return config('dashboard-cards-permissions');
    }


    /**
     * Get all the permissions Super Admin role id from config file.
     *
     * @var array
     */

    function scopeGetSuperAdminRole()
    {
        return config('app.super_admin_role_id');
    }


}
