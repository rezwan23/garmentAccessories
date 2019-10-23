<?php

namespace App\Models\Accounts;

use App\Models\AccountSector;
use Illuminate\Database\Eloquent\Model;

class DebitVoucherRecord extends Model
{
    protected $fillable = [
        'amount', 'account_sector_id'
    ];
    
    protected $casts = [
        'amount' => 'float'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function (DebitVoucherRecord $record){
            /** @var DebitVoucher $voucher */
            $voucher = $record->payment->voucher;

            $record->transactions()->create(array_merge(
                $record->only('account_sector_id', 'amount'),
                $record->payment->toArray(),
                [
                    'transaction_type', 'debit',
                    'party_id' => $voucher->party_id
                ]
            ));

            if($voucher->total_amount == $voucher->paid()){
                $voucher->markAsPaid();
            }
        });

        static::deleting(function (DebitVoucherRecord $record){
            $record->transactions()->delete();
            $record->payment->voucher->markAsUnpaid();
        });
    }

    // Relations
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
    public function sector()
    {
        return $this->belongsTo(AccountSector::class, 'account_sector_id');
    }

    public function voucherSector()
    {
        return $this->belongsTo(DebitVoucherSector::class, 'account_sector_id', 'account_sector_id');
    }

    public function payment()
    {
        return $this->belongsTo(DebitVoucherPayment::class, 'debit_voucher_payment_id');
    }
    
    // Helpers
    public function amount()
    {
        return number_format($this->amount, 2);
    }

}
