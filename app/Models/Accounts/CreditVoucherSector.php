<?php

namespace App\Models\Accounts;

use App\Models\AccountSector;
use Illuminate\Database\Eloquent\Model;

class CreditVoucherSector extends Model
{
    protected $fillable = [
        'account_sector_id', 'amount', 'description'
    ];

    protected $casts = [
        'amount' => 'float'
    ];

    public function sector()
    {
        return $this->belongsTo(AccountSector::class, 'account_sector_id');
    }

    // Helpers

    public function amount()
    {
        return number_format($this->amount, 2);
    }
}
