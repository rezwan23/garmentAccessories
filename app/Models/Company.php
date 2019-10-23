<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Company extends Model
{
    protected $fillable = ['name', 'dyeing_delivery_place', 'terms_conditions', 'authorize_name','additional_details', 'website', 'address', 'emails', 'phones', 'logo', 'company_id', 'created_by', 'updated_by'];
}