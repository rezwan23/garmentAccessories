<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class SampleOrder extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'item_name', 'garments_name', 'merchant_name', 'buyer_name', 'order_number', 'receive_date',
        'delivery_date', 'status', 'delivery_person', 'remarks', 'company_id', 'created_by', 'updated_by',
        'delivered_date','size','garment_id', 'merchant_id', 'buyer_id'
    ];

    public function getStatusClass()
    {
        return $this->statusInfo[$this->status][0];
    }
    public function getStatus(){
        return $this->statusInfo[$this->status][1];
    }

    protected $statusInfo = [
        'processing'    =>  ['warning', 'Processing'],
        'delivered'     =>  ['success', 'Delivered'],
    ];
}
