<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class AccessoryCategory extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['name', 'company_id', 'created_by', 'updated_by'];

    public function accessory()
    {
        return $this->hasMany(Accessory::class);
    }
}
