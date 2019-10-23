<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class PrepareSalary extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'month',
        'paid',
        'year',
        'employee_id',
        'designation_id',
        'department_id',
        'total_payable',
        'is_paid',
        'total_allowance',
        'total_deduction',
        'paid',
        'company_id',
        'created_by',
        'updated_by'
    ];

    public function prepareSalaryAllowances()
    {
        return $this->hasMany(SalaryAllowance::class);
    }

    public function markAsPaid()
    {
        $this->is_paid = 1;
        $this->update();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
