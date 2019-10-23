<?php

namespace App\Rules;

use App\Models\DyeingCompany;
use App\Models\DyeingOrderRawMaterial;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class CheckAccessoryAssigned implements Rule
{

    private $dyeingCompanyId;
    private $request;


    public function __construct($dyeingCompanyId, Request $request){
        $this->dyeingCompanyId = $dyeingCompanyId;
        $this->request = $request;
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $values)
    {
        $flag=true;
        foreach($this->request->accessory_id as $key => $value){
            $receiveMaterial = DyeingOrderRawMaterial::query()
                ->where('dyeing_company_id', $this->dyeingCompanyId)
                ->where('accessory_id', $value)
                ->selectRaw('sum(quantity) as qty')
                ->first();
            if($receiveMaterial) {
                if($receiveMaterial->qty < $this->request->received_quantity[$key]){
                    $flag = false;
                    break;
                }
            }else{
                $flag = false;
                break;
            }
        }
        return $flag;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Raw materials not assigned to dyeing.';
    }
}
