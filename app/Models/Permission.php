<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name', 'group', 'permission', 'company_id', 'created_by', 'updated_by',
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
