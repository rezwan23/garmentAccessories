<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class ReceiveDyeingYarn extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['dyeing_order_id', 'order_id', 'dyeing_company_id', 'receive_date', 'company_id', 'created_by', 'updated_by'];

    public function dyeingOrder()
    {
        return $this->belongsTo(DyeingOrder::class);
    }

    public function getInvoiceLinkName()
    {
        return 'Rec-'.$this->id;
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_receive_dyeing_yarns', 'receive_dyeing_yarn_id', 'order_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function materials()
    {
        return $this->hasMany(ReceiveDyeingYarnMaterial::class);
    }

    public function dyeingCompany()
    {
        return $this->belongsTo(DyeingCompany::class);
    }
}
