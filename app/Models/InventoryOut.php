<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class InventoryOut extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['accessory_id', 'inventory_id', 'quantity', 'company_id', 'created_by', 'updated_by'];

    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }
}
