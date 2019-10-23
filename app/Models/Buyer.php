<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['name', 'company_id','status', 'created_by', 'updated_by'];
}
