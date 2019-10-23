<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
      'department_id',
      'name',
      'status',
      'company_id',
      'created_by',
      'updated_by'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
