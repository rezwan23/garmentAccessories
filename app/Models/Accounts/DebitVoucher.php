<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use NumberFormatter;
use Illuminate\Database\Eloquent\Model;

class DebitVoucher extends Model
{
    protected $fillable = [
        'party_id', 'company_id', 'date', 'invoice_id', 'total_amount'
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
            $model->company_id = auth()->user()->company_id;
        });

        static::deleting(function (DebitVoucher $model){
            $model->payments->each->delete();
        });

        static::addGlobalScope('company', function (Builder $builder){

            $builder->where('debit_vouchers.company_id', auth()->user()->company_id);
        });
    }

    public function sectors()
    {
        return $this->hasMany(DebitVoucherSector::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
    

    public function payments()
    {
        return $this->hasMany(DebitVoucherPayment::class);
    }

    public function paidAmount()
    {
        return $this->hasOne( DebitVoucherPayment::class)
            ->join('debit_voucher_records', 'debit_voucher_payments.id', '=', 'debit_voucher_records.debit_voucher_payment_id')
            ->selectRaw('debit_voucher_payments.debit_voucher_id, sum(debit_voucher_records.amount) as amount')
            ->groupBy('debit_voucher_payments.debit_voucher_id');
    }

    public function records()
    {
        return $this->hasManyThrough(DebitVoucherRecord::class, DebitVoucherPayment::class);
    }

    //Scopes
    public function scopeUnpaid(Builder $builder)
    {
        return $builder->where('is_paid', 0);
    }

    public function scopePaid(Builder $builder)
    {
        return $builder->where('is_paid', 1);
    }
    

    // Helpers
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
        return route('accounts.debit-vouchers.show', $this);
    }

    public function totalInWord()
    {
        return (new NumberFormatter(app()->getLocale(), NumberFormatter::SPELLOUT))->format($this->total_amount);
    }

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
}
