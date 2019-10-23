<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class YearnSupplier extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'name', 'representative', 'website_address', 'email', 'phone', 'created_by', 'address', 'company_id', 'updated_by'
    ];
}
