<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Lc extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'created_by', 'updated_by', 'company_id', 'seller_bank'
        , 'seller_bank_branch','buyer_bank','buyer_bank_branch',
        'lc_number',
        'payment_terms',
        'party_date',
        'bank_date',
        'accept_date',
        'adjust_remarks',
        'total_value',
        'garment_id',
        'bank_ref_no',
        'status'
    ];

    protected $lcStatus = [
        ['pending', 'warning'],
        ['done', 'success'],
    ];

    public function markAsDone()
    {
        $this->status = 1;
        $this->update();
    }
    public function markAsPending()
    {
        $this->status = 0;
        $this->update();
    }
    public function getStatus()
    {
        return $this->lcStatus[$this->status][0];
    }
    public function getStatusClass()
    {
        return $this->lcStatus[$this->status][1];
    }

    public function lcDetails()
    {
        return $this->hasMany(LcDetails::class);
    }

    public function garment()
    {
        return $this->belongsTo(Garment::class);
    }

    public function jobId()
    {
        $ids = [];
        foreach($this->lcDetails as $d){
            if($d->pi){
                if($d->pi->orders){
                    foreach($d->pi->orders as $order){
                        $ids[] = $order->id;
                    }
                }
            }
        }
        return $ids;
    }
}
