<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'company_id', 'created_by', 'updated_by'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
