<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class DyeingCompany extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'name', 'emails', 'phones','status', 'created_by', 'updated_by', 'company_id','address'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
