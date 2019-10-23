<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class ProductionItem extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'production_id',
        'ordered_item_id',
        'quantity',
        'company_id',
        'created_by',
        'updated_by',
    ];

    public function item()
    {
        return $this->belongsTo(OrderedItem::class, 'ordered_item_id');
    }

    public function production()
    {
        return $this->belongsTo(Production::class);
    }
    public function rawMaterials()
    {
        return $this->hasMany(ProductionItemRawMaterial::class);
    }
//    public function inventoryOuts()
//    {
//        if($this->accessory_type==1){
//            return $this->hasMany(DyeingYarnInventoryOut::class);
//        }else{
//            return $this->hasMany(InventoryOut::class);
//        }
//    }
}
