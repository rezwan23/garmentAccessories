<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class OrderedItem extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['order_id', 'size', 'item_id', 'style_number', 'quality', 'unit_price', 'quantity', 'color_id', 'company_id', 'created_by', 'updated_by'];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function requirements()
    {
        return $this->hasMany(OrderItemRequirement::class);
    }

    public function getProducedQuantity()
    {
        return Arr::get($this->producedQuantity, 'quantity', 0);
    }
    public function producedQuantity()
    {
        return $this->hasOne(ProductionItem::class)
            ->selectRaw('ordered_item_id, sum(quantity) as quantity')
            ->groupBy('ordered_item_id');
    }

    public function dueQuantity()
    {
        return $this->quantity-$this->getProducedQuantity();
    }

    public function deliveredQuantity()
    {
        return $this->hasOne(DeliveryItem::class)
            ->selectRaw('ordered_item_id, sum(quantity) as quantity')
            ->groupBy('ordered_item_id');
    }

    public function getDeliveryCount()
    {
        return Arr::get($this->deliveredQuantity, 'quantity', 0);
    }

    public function getDeliveryDue()
    {
        return $this->quantity-$this->getDeliveryCount();
    }

    public function stockQuantity()
    {
        return $this->getProducedQuantity()-$this->getDeliveryCount();
    }

    public function commercialDetails()
    {
        return $this->hasOne(CommercialDetail::class);
    }
}
