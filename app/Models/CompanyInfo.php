<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    protected $fillable = [
        'name', 'website', 'emails', 'phones', 'logo', 'address', 'company_id', 'created_by', 'updated_by'
    ];
}
