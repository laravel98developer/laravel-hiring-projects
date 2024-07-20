<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Modules\Acl\App\Models\Permission;
use Modules\Acl\App\Models\Role;

class User extends Authenticatable
{
    use  HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'verification_code', 'mobile_verified_at', 'verified', 'mobile',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

//
//    /**
//     * Get the user associated with the Delivery.
//     *
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }

    public function generate_token($name="UserToken")
    {
        $client = Client::where('password_client', true)->first();
        $token = $this->createToken($name)->accessToken;
        $this->access_token=$token;
        return $this;
    }

    /**
     * Define a many-to-many relationship between the User model and the Role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Define a many-to-many relationship between the User model and the Permission model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if the user has a specific role.
     *
     * @param  string  $role The name of the role to check.
     * @return bool
     */
    public function hasRole(string $role)
    {
        return $this->roles->contains('name', $role);
    }

    /**
     * Check if the user has any of the specified roles.
     *
     * @param  string|array  $roles The role(s) to check.
     * @return bool
     */
    public function hasRoleArray(array $roles)
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }

        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Check if the user has a specific permission.
     *
     * @param  string  $permission The name of the role to check.
     * @return bool
     */
    public function hasPermission(string $permission)
    {
        return $this->permissions->contains('name', $permission);
    }

    /**
     * Check if the user has a specific permission.
     *
     * @param  string  $permission The name of the role to check.
     * @return bool
     */
    public function hasPermissionArray(array $permissions)
    {
        return $this->permissions->whereIn('name', $permissions)->exists();
    }

    /**
     * Check if the user has a specific permission in any of their assigned roles.
     *
     * @param  string  $permission The name of the permission to check.
     * @return bool
     */
    public function hasPermissionInRoles(string $permission)
    {
        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->contains('name', $permission);
    }

}
