<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['name','status',  'company_id', 'created_by', 'updated_by'];
}
