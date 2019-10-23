<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'name', 'account_id', 'status', 'company_id', 'created_by', 'updated_by'
    ];

    protected $statusInfo = [
        ['danger', 'Inactive'],
        ['primary', 'Active'],
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getStatusClass()
    {
        return $this->statusInfo[$this->status][0];
    }

    public function getStatus()
    {
        return $this->statusInfo[$this->status][1];
    }
}
