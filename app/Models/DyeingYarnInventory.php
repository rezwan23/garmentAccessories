<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class DyeingYarnInventory extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'accessory_id', 'available_quantity', 'company_id', 'created_by', 'updated_by','color_id'
    ];

    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }

    public function inventoryIn()
    {
        return $this->hasOne(DyeingYarnInventoryIn::class, 'inventory_id')
            ->selectRaw('inventory_id, sum(quantity) as quantity')
            ->groupBy('inventory_id')
            ->whereDate('created_at', date('Y-m-d'));
    }

    public function inventoryInsAll()
    {
         return $this->hasMany( DyeingYarnInventoryIn::class, 'inventory_id')
             ->whereDate('created_at', date('Y-m-d'));
    }

    public function getInventoryInCount()
    {
        return Arr::get($this->inventoryIn, 'quantity', 0);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function inventoryOut()
    {
        return $this->hasOne(DyeingYarnInventoryOut::class, 'inventory_id')
            ->selectRaw('inventory_id, sum(quantity) as quantity')
            ->groupBy('inventory_id')
            ->whereDate('created_at', date('Y-m-d'));
    }

    public function inventoryOutCount()
    {
        return Arr::get($this->inventoryOut, 'quantity', 0);
    }

}
