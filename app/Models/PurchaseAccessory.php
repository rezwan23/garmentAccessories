<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class PurchaseAccessory extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['vendor_id', 'order_date', 'total_amount', 'company_id', 'created_by', 'updated_by'];
    public function accessories()
    {
        return $this->hasMany(PurchaseAccessoryItem::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
