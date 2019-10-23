<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable =['name', 'accessory_category_id', 'unit_id', 'company_id', 'created_by', 'updated_by'];

    public function accessoryCategory()
    {
        return $this->belongsTo(AccessoryCategory::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'dyeing_yarn_inventories', 'accessory_id', 'color_id')->withoutGlobalScope('company');
    }
}
