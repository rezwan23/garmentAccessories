<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
      'depart_id',
      'desig_id',
      'joining',
      'salary',
      'fName',
      'faName',
      'moName',
      'gender',
      'blood',
      'religion',
      'nid',
      'dob',
      'marriage',
      'phone',
      'email',
      'phone_emer',
      'image',
      'present_add',
      'permanent_add',
      'company_id',
      'created_by',
      'updated_by'
    ];

   public function department()
   {
       return $this->belongsTo(Department::class, 'depart_id');
   }
   public function designation()
   {
       return $this->belongsTo(Designation::class,'desig_id');
   }
}
