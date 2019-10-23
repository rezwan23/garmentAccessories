<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUpdateCompanyScope;
class Order extends Model
{
    // id is equivalent to Job ID
    protected $fillable = [
        'is_assigned' ,
        'garments_id',
        'buyer_id',
        'merchant_id',
        'order_date',
        'delivery_date',
        'total_amount',
        'company_id',
        'created_by',
        'updated_by',
        'commercial_assigned',
        'production_status',
        'delivery_status',
        'is_production',
        'dyeing_company_id',
        'style_number',
        'is_dyeing',
        'received_raw',
        'is_pi',
        'production_init',
        'dyeing_delivery_date',
        'is_active'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->created_by = auth()->user()->id;
            $model->company_id = auth()->user()->company_id;
        });

        static::updating(function($model){
            $model->updated_by = auth()->user()->id;
        });

        static::addGlobalScope('company', function(Builder $builder){
            $builder->where('orders.company_id', auth()->user()->company_id);
        });
    }

    public function garments()
    {
        return $this->belongsTo(Garment::class, 'garments_id');
    }



    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
    public function items()
    {
        return $this->hasMany(OrderedItem::class);
    }

    public function commercial()
    {
        return $this->hasOne(Commercial::class, 'job_id');
    }


    public function getDeliveryStatusClass()
    {
        return $this->deliveryStatus[$this->delivery_status]['class'];
    }
    public function getDeliveryStatus()
    {
        return $this->deliveryStatus[$this->delivery_status]['text'];
    }
    protected $deliveryStatus = [
        ['class'=>'warning', 'text' =>  'Have Due'],
        ['class'=>'success', 'text' =>  'All Delivered'],
    ];

    public function Deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function receiveYarns()
    {
        return $this->hasMany(ReceiveDyeingYarn::class);
    }

    public function dyeingCompany()
    {
        return $this->belongsTo(DyeingCompany::class);
    }

    public function getTotalProducedQuantity()
    {
        $total = 0;
        foreach($this->items as $item){
            $total+=$item->getProducedQuantity();
        }
        return $total;
    }

    public function getTotalProduction()
    {
        $total = 0;
        foreach($this->items as $item){
            $total+=$item->quantity;
        }
        return $total;
    }

    public function getTotalReceivedYarn()
    {
        $total = 0;
        foreach($this->items as $item){
            foreach($item->requirements as $accessory){
                $total+=$accessory->getReceivedMaterialCount();
            }
        }
        return $total;
    }
    public function getTotalOrderedYarn()
    {
        $total = 0;
        foreach($this->items as $item){
            foreach($item->requirements as $accessory){
                $total+=$accessory->quantity;
            }
        }
        return $total;
    }
    public function getTotalAssignedYarn()
    {
        $quantity = 0;
        foreach($this->items as $item){
            $quantity+=$item->assignedYarnCount();
        }
        return $quantity;
    }

    public function pis()
    {
        return $this->belongsToMany(Pi::class, 'order_pis');
    }
}
