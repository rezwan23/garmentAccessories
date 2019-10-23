<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class ProductionItemRawMaterial extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['production_item_id', 'accessory_id', 'accessory_type', 'quantity', 'color_id', 'company_id', 'created_by', 'updated_by', 'material_id'];

    public function productionItem()
    {
        return $this->belongsTo(ProductionItem::class);
    }
}
