<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class OrderItemRequirement extends Model
{
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
            $builder->where('order_item_requirements.company_id', auth()->user()->company_id);
        });
    }
    protected $fillable = ['ordered_item_id', 'dyeing_company_id', 'accessory_id','color_id', 'yarn_type' , 'quantity', 'company_id', 'created_by', 'updated_by'];

    public function dyeingCompany()
    {
        return $this->belongsTo(DyeingCompany::class);
    }

    public function orderedItem()
    {
        return $this->belongsTo(OrderedItem::class);
    }
    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function getReceivedMaterial()
    {
        return $this->hasOne(ReceiveDyeingYarnMaterial::class, 'material_id')
            ->selectRaw('material_id, sum(received_quantity) as quantity')
            ->groupBy('material_id');
    }

    public function getReceivedMaterialCount()
    {
        return Arr::get($this->getReceivedMaterial, 'quantity', 0);
    }

    public function getDueReceiveCount()
    {
        return $this->quantity-$this->getReceivedMaterialCount();
    }
    public function getChallan(){
        return $this->hasMany(ReceiveDyeingYarnMaterial::class, 'material_id')
            ->select('challan_number', 'created_at');
    }

    public function getReceivedYarnQuantity()
    {
        return $this->hasOne(ReceiveDyeingYarnMaterial::class, 'material_id')
            ->selectRaw('sum(received_quantity) as recQty, material_id')
            ->groupBy('material_id');
    }

    public function getReceivedYarnCount()
    {
        return Arr::get($this->getReceivedYarnQuantity, 'recQty', 0);
    }

    public function getJobId($acc, $dyeingCompany)
    {
        return Order::query()->whereHas('items.requirements', function($query)use($acc){
            $query->where('accessory_id', $acc);
        })->whereHas('dyeingCompany', function($q) use($dyeingCompany){
            $q->where('id', $dyeingCompany);
        })->where('is_active', 1)
            ->pluck('id');
    }
}
