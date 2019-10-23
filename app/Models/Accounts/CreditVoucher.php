<?php

namespace App\Models\Accounts;

use App\User;
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Support\Arr;
use NumberFormatter;

class CreditVoucher extends Model
{
    protected $fillable = [
        'party_id', 'company_id', 'date', 'invoice_id', 'total_amount', 'user_id'
    ];

    protected $dates = [
        'date'
    ];

    protected $casts = [
        'total_amount' => 'float'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model){
            /** @var User $user */
            $user = auth()->user();

            $model->fill([
                'company_id' => $user->company_id,
                'user_id' => $user->id
            ]);
        });

        static::deleting(function (CreditVoucher $voucher){
            $voucher->payments->each->delete();
        });

        static::addGlobalScope('company', function (Builder $builder){

            $builder->where('credit_vouchers.company_id', auth()->user()->company_id);
        });
    }

    public function sectors()
    {
        return $this->hasMany(CreditVoucherSector::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function payments()
    {
        return $this->hasMany(CreditVoucherPayment::class);
    }
    public function records()
    {
        return $this->hasManyThrough(CreditVoucherRecord::class, CreditVoucherPayment::class);
    }

    public function paidAmount()
    {
        return $this->hasOne(CreditVoucherPayment::class)
            ->join('credit_voucher_records', 'credit_voucher_payments.id', '=', 'credit_voucher_records.credit_voucher_payment_id')
            ->selectRaw('credit_voucher_payments.credit_voucher_id, sum(credit_voucher_records.amount) as amount')
            ->groupBy('credit_voucher_payments.credit_voucher_id');
    }
    // Scopes
    public function scopeUnpaid(Builder $builder)
    {
        return $builder->where('is_paid', 0);
    }

    public function scopePaid(Builder $builder)
    {
        return $builder->where('is_paid', 1);
    }


    // Helpers
    public function markAsPaid()
    {
        $this->forceFill([
            'is_paid' => 1
        ]);
        $this->save();
    }
    public function markAsUnpaid()
    {
        $this->forceFill([
            'is_paid' => 0
        ]);
        $this->save();
    }

    public function paid()
    {
        return Arr::get($this->paidAmount, 'amount', 0);
    }

    public function due()
    {
        return ($this->total_amount - $this->paid());
    }

    public function totalAmount()
    {
        return number_format($this->total_amount, 2);
    }
    public function voucherLink()
    {
        return route('accounts.credit-vouchers.show', $this);
    }

    public function totalInWord()
    {
        return (new NumberFormatter(app()->getLocale(), NumberFormatter::SPELLOUT))->format($this->total_amount);
    }
}
