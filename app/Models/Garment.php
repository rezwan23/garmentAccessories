<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Garment extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['name', 'email','status', 'phone_number', 'address', 'company_id', 'created_by', 'updated_by'];
}
