<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class DyeingOrderRawMaterial extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['dyeing_order_id', 'dyeing_company_id', 'accessory_id', 'unit_id', 'quantity', 'company_id', 'created_by', 'updated_by', 'remarks'];
    public function dyeingOrder()
    {
        return $this->belongsTo(DyeingOrder::class);
    }

    public function dyeingCompany()
    {
        return $this->belongsTo(DyeingCompany::class);
    }
    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function receivedQuantity()
    {
        return Arr::get($this->getReceiveDyeingMaterialQuantity, 'quantity', 0);
    }
    public function getReceiveDyeingMaterialQuantity()
    {
        return $this->hasOne(ReceiveDyeingYarnMaterial::class, 'dyeing_material_id')
            ->selectRaw('dyeing_material_id, sum(received_quantity) as quantity')
            ->groupBy('dyeing_material_id');
    }

    public function getReceiveDyeingMaterialDueQuantity()
    {
        return $this->quantity - $this->receivedQuantity();
    }

    public function itemRequirement()
    {
        return $this->hasOne(OrderItemRequirement::class, 'accessory_id', 'accessory_id');
    }

    public function rawMaterialOrderQuantity()
    {
        return $this->hasOne(OrderItemRequirement::class, 'accessory_id', 'accessory_id')
            ->whereHas('orderedItem.order', function($q){
                $q->where('is_active', 1);
            })
            ->selectRaw('sum(quantity) as orderQty, accessory_id')
            ->groupBy('accessory_id');
    }

    public function orderRawCount()
    {
        return Arr::get($this->rawMaterialOrderQuantity, 'orderQty', 0);
    }

    public function receivedQtyTotal($dyeingCompanyid, $accId)
    {
        return ReceiveDyeingYarnMaterial::query()->whereHas('receiveDyeingYarn', function($q)use($dyeingCompanyid){
            $q->where('dyeing_company_id', $dyeingCompanyid);
        })->where('accessory_id', $accId)
            ->selectRaw('sum(received_quantity) as recQty')->first();
    }

    public function recieveQtyCount($dyeingCompanyid, $accId)
    {
        return Arr::get($this->receivedQtyTotal($dyeingCompanyid, $accId), 'recQty', 0);
    }
    public function getOrderQuantityCount($acc, $dyeingCompany)
    {
        $qty = 0;
        $orders =  Order::query()->whereHas('items.requirements', function($query)use($acc){
            $query->where('accessory_id', $acc);
        })->whereHas('dyeingCompany', function($q) use($dyeingCompany){
            $q->where('id', $dyeingCompany);
        })->where('is_active', 1)
            ->pluck('id');
        foreach($orders as $o)
        {
            $order = Order::findOrFail($o);
            foreach($order->items as $item){
                foreach($item->requirements as $requirement){
                    if($requirement->accessory_id == $acc && $requirement->yarn_type == 1)
                        $qty+=$requirement->quantity;
                }
            }
        }
        return $qty;
    }
}
