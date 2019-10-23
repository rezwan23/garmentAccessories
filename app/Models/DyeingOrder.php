<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class DyeingOrder extends Model
{
    protected $statusInfo = [
        ['warning', 'Have Due'],
        ['success', 'All Received'],
    ];

    public function getStatusClass()
    {
        return $this->statusInfo[$this->status][0];
    }

    public function getStatus()
    {
        return $this->statusInfo[$this->status][1];
    }

    use CreateUpdateCompanyScope;
    protected $fillable = ['dyeing_company_id', 'order_date', 'company_id', 'created_by', 'updated_by', 'status'];

    public function materials()
    {
        return $this->hasMany(DyeingOrderRawMaterial::class);
    }

    public function getChallanId()
    {
        return 'Dye-'.$this->id;
    }

    public function dyeingCompany()
    {
        return $this->belongsTo(DyeingCompany::class);
    }

    public function receiveOrders()
    {
        return $this->hasMany(ReceiveDyeingYarn::class);
    }
}
