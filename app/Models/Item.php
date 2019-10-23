<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['name', 'unit_id', 'company_id', 'created_by', 'updated_by'];
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
