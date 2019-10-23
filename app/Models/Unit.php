<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUpdateCompanyScope;
class Unit extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['name', 'company_id', 'created_by', 'updated_by'];
}
