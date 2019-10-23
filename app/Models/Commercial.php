<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUpdateCompanyScope;
class Commercial extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['job_id','serial_number', 'is_lc' , 'total_amount', 'company_id', 'created_by', 'updated_by'];
    public function commercials()
    {
        return $this->hasMany(CommercialDetail::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'job_id');
    }

    public function lcDetails()
    {
        return $this->hasOne(LcDetails::class, 'serial_number', 'serial_number');
    }
}
