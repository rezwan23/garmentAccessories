<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class InventoryIn extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['accessory_id', 'quantity', 'inventory_id', 'purchase_accessory_id', 'company_id', 'created_by', 'updated_by'];
    public function accessory()
    {
        $this->belongsTo(Accessory::class);
    }
}
