<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Inventory extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'accessory_id', 'available_quantity', 'company_id', 'created_by', 'updated_by'
    ];

    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }

    public function todayInventoryIn()
    {
        return $this->hasOne(InventoryIn::class)
            ->whereDate('created_at', date('Y-m-d'))
            ->selectRaw('sum(quantity) as totalIn, inventory_id')
            ->groupBy('inventory_id')
            ->whereDate('created_at', date('Y-m-d'));
    }

    public function todayInventoryOut()
    {
        return $this->hasOne(InventoryOut::class)
            ->whereDate('created_at', date('Y-m-d'))
            ->selectRaw('sum(quantity) as totalOut, inventory_id')
            ->groupBy('inventory_id')
            ->whereDate('created_at', date('Y-m-d'));
    }

    public function getInventoryInCount()
    {
        return Arr::get($this->todayInventoryIn, 'totalIn', 0);
    }
    public function getInventoryOutCount()
    {
        return Arr::get($this->todayInventoryOut, 'totalOut', 0);
    }
}
