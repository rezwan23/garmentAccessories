<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['company_id', 'phone_type', 'phone_no'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
