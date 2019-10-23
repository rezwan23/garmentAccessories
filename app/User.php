<?php

namespace App;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','company_id', 'status', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $statusInfo = [
        ['danger', 'Inactive'],
        ['success', 'Active'],
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function statusClass()
    {
        return $this->statusInfo[$this->status][0];
    }
    public function statusText()
    {
        return $this->statusInfo[$this->status][1];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isSuperAdmin()
    {
        if($this->role->name == 'Super Super Admin')
            return true;
        return false;
    }
}
