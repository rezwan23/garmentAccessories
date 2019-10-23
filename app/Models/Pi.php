<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Pi extends Model
{
    use CreateUpdateCompanyScope;

    protected $fillable =[
        'garment_id',
        'buyer_id',
        'merchant_id',
        'item_id',
        'quantity',
        'unit_price',
        'total',
        'serial_number',
        'company_id',
        'created_by',
        'updated_by',
        'is_lc',
    ];

    public function garment()
    {
        return $this->belongsTo(Garment::class);
    }
    public function buyer()
{
    return $this->belongsTo(Buyer::class);
}
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_pis');
    }

    public function getBuyers()
    {
        $buyers = [];
        foreach($this->orders as $order){
            $buyers[] = $order->buyer->name;
        }
        return $buyers;
    }

    public function lcDetails()
    {
        return $this->hasOne(LcDetails::class, 'serial_number', 'serial_number');
    }
    
}
