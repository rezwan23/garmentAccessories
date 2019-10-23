<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
      'title',
      'type',
      'status',
      'company_id',
      'created_by',
      'updated_by'
    ];
}
