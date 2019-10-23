<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'account_id', 'company_id', 'payment_method_id', 'user_id', 'transaction_type',
        'payment_date', 'amount', 'transactionable_type', 'transactionable_id', 'account_sector_id',
        'party_id'
    ];

    protected $casts = [
        'amount' => 'float'
    ];

    protected $dates = [
        'payment_date'
    ];

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function isDebit()
    {
        return $this->transactionable instanceof DebitVoucherRecord;
    }

    public function isCredit()
    {
        return $this->transactionable instanceof CreditVoucherRecord;
    }

    public function amount()
    {
        if($this->isDebit()){
            return - $this->transactionable->amount;
        }
        return $this->transactionable->amount;
    }
}
