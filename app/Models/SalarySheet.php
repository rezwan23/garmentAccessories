<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SalarySheet extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'total_payable',
        'company_id',
        'created_by',
        'updated_by',
        'month',
        'year'
    ];

    public function details()
    {
        return $this->hasMany(SalarySheetDetail::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
