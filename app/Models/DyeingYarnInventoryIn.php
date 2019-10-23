<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class DyeingYarnInventoryIn extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'inventory_id',
        'accessory_id',
        'quantity',
        'company_id',
        'created_by',
        'updated_by',
        'receive_id'
    ];

    public function receiveYarn()
    {
        return $this->belongsTo(ReceiveDyeingYarn::class, 'receive_id');
    }
}
