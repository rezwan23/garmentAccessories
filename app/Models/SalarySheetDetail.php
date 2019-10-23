<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class SalarySheetDetail extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'salary_sheet_id',
        'employee_id',
        'total_allowance',
        'total_deduction',
        'payable',
        'company_id',
        'created_by',
        'updated_by',
        'month',
        'year',
        'prepare_salary_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function prepareSalary()
    {
        return $this->belongsTo(PrepareSalary::class);
    }
}
