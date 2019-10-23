<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
      'name',
      'status',
      'company_id',
      'created_by',
      'updated_by'
    ];

    public function designations()
    {
        return $this->hasMany(Designation::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class, 'depart_id');
    }
}
