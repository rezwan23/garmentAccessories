<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class SalaryAllowance extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'prepare_salary_id', 'allowance_id', 'allowance', 'type','company_id', 'created_by', 'updated_by'
    ];

    public function prepareSalary()
    {
        return $this->belongsTo(PrepareSalary::class);
    }
    public function salaryExtra()
    {
        return $this->belongsTo(Allowance::class, 'allowance_id');
    }
}
