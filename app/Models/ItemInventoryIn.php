<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class ItemInventoryIn extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['item_inventory_id', 'item_id', 'quantity', 'created_by', 'updated_by', 'company_id', 'production_id'];
}
