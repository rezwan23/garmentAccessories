<?php

namespace App\Models\Accounts;

use App\Models\Account;
use App\Models\PaymentMethod;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use NumberFormatter;

class CreditVoucherPayment extends Model
{
    protected $fillable = [
        'account_id', 'payment_method_id', 'cheque_no', 'payment_date', 'user_id', 'company_id'
    ];

    public $dates = [
        'payment_date'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model){
            /** @var User $user */
            $user = auth()->user();

            $model->fill([
                'user_id' => $user->id,
                'company_id' => $user->company_id
            ]);
        });

        static::deleting(function (CreditVoucherPayment $payment){
            $payment->records->each->delete();
        });
    }

    public function voucher()
    {
        return $this->belongsTo(CreditVoucher::class, 'credit_voucher_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function records()
    {
        return $this->hasMany(CreditVoucherRecord::class);
    }

    public function paidAmount()
    {
        return $this->hasOne(CreditVoucherRecord::class)
            ->selectRaw('credit_voucher_payment_id, sum(amount) as amount')
            ->groupBy('credit_voucher_payment_id');
    }

    // Amounts

    public function paid()
    {
        return Arr::get($this->paidAmount, 'amount', 0);
    }

    public function amount()
    {
        return number_format($this->paid(), 2);
    }

    public function amountInWord()
    {
        return (new NumberFormatter(app()->getLocale(), NumberFormatter::SPELLOUT))->format($this->paid());
    }
}
