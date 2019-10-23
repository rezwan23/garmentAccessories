<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['order_id', 'company_id', 'created_by', 'updated_by'];

    public function productionItems()
    {
        return $this->hasMany(ProductionItem::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
