<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use CreateUpdateCompanyScope;

    protected $fillable = [

        'no', 'name', 'opening_balance', 'swift_code', 'routing_number', 'status', 'branch_name', 'company_id', 'created_by', 'updated_by'
    ];

    protected $accountInfo = [
        ['danger', 'Inactive'],
        ['primary', 'Active']
    ];

    public function getStatusClass()
    {
        return $this->accountInfo[$this->status][0];
    }

    public function getStatus()
    {
        return $this->accountInfo[$this->status][1];
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }
}
