<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ItemInventory extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['item_id', 'available_quantity', 'color_id', 'company_id', 'created_by', 'updated_by'];

    public function todayIn()
    {
        return $this->hasOne(ItemInventoryIn::class)
            ->selectRaw('item_inventory_id, sum(quantity) as quantity')
            ->groupBy('item_inventory_id')
            ->whereDate('created_at', date('Y-m-d'));
    }

    public function todayInCount()
    {
        return Arr::get($this->todayIn, 'quantity', 0);
    }
    public function todayOut()
    {
        return $this->hasOne(ItemInventoryOut::class)
            ->selectRaw('item_inventory_id, sum(quantity) as quantity')
            ->groupBy('item_inventory_id')
            ->whereDate('created_at', date('Y-m-d'));
    }

    public function todayOutCount()
    {
        return Arr::get($this->todayOut, 'quantity', 0);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
