<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class PurchaseAccessoryItem extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['purchase_accessory_id', 'accessory_id', 'quantity', 'unit_price', 'company_id', 'created_by', 'updated_by'];
    public function purchase()
    {
        return $this->belongsTo(PurchaseAccessory::class);
    }
    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'accessory_id', 'accessory_id');
    }
}
