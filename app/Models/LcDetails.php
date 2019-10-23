<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class LcDetails extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'serial_number',
        'lc_id',
        'total_value',
        'company_id',
        'created_by',
        'updated_by',
    ];

    public function lc()
    {
        return $this->belongsTo(Lc::class);
    }

    public function pi()
    {
        return $this->hasOne(Pi::Class, 'serial_number', 'serial_number');
    }

    public function jobId()
    {
        return $this->pi->orders;
    }
    public function commercial()
    {
        return $this->belongsTo(Commercial::class, 'serial_number', 'serial_number');
    }
}
