<?php

namespace App\Models;
use App\Models\Accounts\{CreditVoucherRecord, DebitVoucherRecord};
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\{Model, Builder};

class AccountSector extends Model
{
    use CreateUpdateCompanyScope;

    protected $sectorTypeInfo = [
        ['warning', 'Expense'],
        ['info', 'Income'],
    ];

    protected $statusInfo = [
        ['danger', 'Inactive'],
        ['warning', 'Active'],
    ];
    protected $fillable = ['name', 'status', 'sector_type', 'company_id', 'created_by', 'updated_by'];

    public function getSectorTypeClass()
    {
        return $this->sectorTypeInfo[$this->sector_type][0];
    }
    public function getSectorType()
    {
        return $this->sectorTypeInfo[$this->sector_type][1];
    }

    public function getStatusClass()
    {
        return $this->statusInfo[$this->status][0];
    }
    public function getStatus()
    {
        return $this->statusInfo[$this->status][1];
    }

    public function scopeIncome(Builder $builder)
    {
        return $builder->where('sector_type', 1);
    }

    public function scopeExpense(Builder $builder)
    {
        return $builder->where('sector_type', 0);
    }

    public function creditAmount()
    {
        return $this->hasOne(CreditVoucherRecord::class);
    }
    public function debitAmount()
    {
        return $this->hasOne(DebitVoucherRecord::class);
    }
}
