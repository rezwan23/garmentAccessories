<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class CommercialDetail extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['commercial_id', 'ordered_item_id', 'unit_price', 'quantity', 'company_id', 'created_by', 'updated_by', 'style_number'];

    public function orderedItem()
    {
        return $this->belongsTo(OrderedItem::class);
    }
}
