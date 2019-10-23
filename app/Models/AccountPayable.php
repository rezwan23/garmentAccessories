<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class AccountPayable extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['vendor_id', 'company_id', 'lc_number', 'order_number', 'total_amount', 'order_date', 'due', 'created_by', 'updated_by'];

    public function details()
    {
        return $this->hasMany(AccountPayableDetail::class);
    }
    public function vendor()
    {
        return $this->belongsTo(YearnSupplier::class, 'vendor_id');
    }
}
