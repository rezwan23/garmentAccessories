<?php

namespace App\Models\Accounts;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = [
        'name', 'phone', 'company_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model){
            $model->company_id = auth()->user()->company_id;
        });

        static::addGlobalScope(new CompanyScope());
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creditVouchers()
    {
        return $this->hasMany(CreditVoucher::class);
    }

    public function debitVouchers()
    {
        return $this->hasMany(DebitVoucher::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
