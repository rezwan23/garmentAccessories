<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use CreateUpdateCompanyScope;
    protected  $fillable = [
        'account_id', 'payment_method_id', 'paid_amount', 'date', 'status', 'ref_id', 'account_payable_id', 'cheque_number', 'company_id', 'created_by', 'updated_by'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
