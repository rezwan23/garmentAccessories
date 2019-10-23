<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable= [
        'order_id',
        'delivery_status',
        'delivery_date',
        'company_id',
        'created_by',
        'updated_by',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function items()
    {
        return $this->hasMany(DeliveryItem::class);
    }
}
