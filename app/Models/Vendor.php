<?php

namespace App\Models;
use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = ['name','status' ,  'type', 'company_id', 'created_by', 'updated_by'];

    public function changeStatus()
    {
        if($this->status==1)
            $this->update(['status'=>0]);
        else
            $this->update(['status'=>1]);
    }
}
