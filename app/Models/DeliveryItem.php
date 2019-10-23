<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable =[
        'delivery_id',
        'ordered_item_id',
        'quantity',
        'item_id',
        'color_id',
        'created_by',
        'updated_by',
        'company_id',
        'remarks',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function orderedItem()
    {
        return $this->belongsTo(OrderedItem::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
