<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class DyeingYarnInventoryOut extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['inventory_id', 'accessory_id', 'quantity', 'company_id', 'created_by', 'updated_by', 'production_id'];
}
