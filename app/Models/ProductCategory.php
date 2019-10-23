<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['name', 'company_id', 'created_by', 'updated_by'];
}
