<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class AccountPayableDetail extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'sector_id', 'account_payable_id', 'amount', 'description', 'company_id', 'created_by', 'updated_by'
    ];

    public function accountPayable()
    {
        return $this->belongsTo(AccountPayable::class);
    }
    public function sector()
    {
        return $this->belongsTo(AccountSector::class, 'sector_id');
    }
}
