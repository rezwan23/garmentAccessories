<?php

namespace App\Models;

use App\Traits\CreateUpdateCompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ReceiveDyeingYarnMaterial extends Model
{
    use CreateUpdateCompanyScope;
    protected $fillable = [
        'receive_dyeing_yarn_id',
        'dyeing_material_id',
        'accessory_id',
        'received_quantity',
        'due_quantity',
        'company_id',
        'created_by',
        'updated_by',
        'given_quantity',
        'color_id',
        'material_id',
        'challan_number'
    ];
    public function dyeingCompanyId()
    {
        return $this->receiveDyeingYarn->dyeingCompany->id;
    }

    public function dyeingAssignedQuantity()
    {
        return DyeingOrderRawMaterial::query()->selectRaw('sum(quantity) as assignedQuantity')
            ->where('dyeing_company_id', $this->dyeingCompanyId())
            ->where('accessory_id', $this->accessory_id)
            ->first();

    }

    public function getDueAccessory()
    {
        $dyeingCompany = $this->dyeingCompanyId();
        $received = ReceiveDyeingYarnMaterial::query()->whereHas('receiveDyeingYarn', function($q) use ($dyeingCompany){
            $q->where('dyeing_company_id', $dyeingCompany);
        })->where('accessory_id', $this->accessory_id)
            ->selectRaw('sum(received_quantity) as receivedQuantity')
            ->first();
        $received = Arr::get($received, 'receivedQuantity', 0);
        $due = $this->dyeingAssignedQuantityCount() - $received;
        return $due<0?'Not Assigned':$due;
    }

    public function dyeingAssignedQuantityCount()
    {
        return Arr::get($this->dyeingAssignedQuantity(), 'assignedQuantity', 0);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function receiveDyeingYarn()
    {
        return $this->belongsTo(ReceiveDyeingYarn::class);
    }
    public function material()
    {
        return $this->belongsTo(OrderItemRequirement::class, 'material_id');
    }

    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }

    public function dyeingRawMaterial()
    {
        return $this->belongsTo(DyeingOrderRawMaterial::class, 'dyeing_material_id');
    }

    public function yarnInventory(){
        return DyeingYarnInventory::where('accessory_id', $this->accessory_id)->where('color_id', $this->color_id)->first();
    }

    public function availableYarn()
    {
        if($this->yarnInventory()){
            return $this->yarnInventory()->available_quantity;
        }
        return 0;
    }

    public function todayIn()
    {
        return $this->yarnInventory()->getInventoryInCount();
    }

    public function todayOut()
    {
        return $this->yarnInventory()->inventoryOutCount();
    }
}
