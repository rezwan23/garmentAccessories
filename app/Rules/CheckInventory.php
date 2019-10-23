<?php

namespace App\Rules;

use App\Models\DyeingYarnInventory;
use App\Models\Inventory;
use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class CheckInventory implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $order = $this->order;
        $yarnInv = [];
        $accInv = [];
        if($order->is_production==0){
            foreach ($order->items as $item){
                foreach($item->requirements as $material){
                    if($material->yarn_type){
                        $inventory = DyeingYarnInventory::where('accessory_id', $material->accessory_id)
                            ->where('color_id', $material->color_id)->first();
                        if($inventory==null){
                            return false;
                        }
                        $invId = $inventory->id;
                        if(isset($yarnInv[$invId])){
                            $yarnInv[$invId]+=$material->quantity;
                        }else{
                            $yarnInv[$invId]=$material->quantity;
                        }
                    }else{
                        $acc = Inventory::where('accessory_id', $material->accessory_id)
                            ->first();
                        if($acc==null){
                            return false;
                        }
                        if(isset($accInv[$acc->id])){
                            $accInv[$acc->id] += $material->quantity;
                        }else{
                            $accInv[$acc->id] = $material->quantity;
                        }
                    }
                }
            }
        }
        foreach($yarnInv as $key=>$value){
            $inv = DyeingYarnInventory::find($key);
            if($inv->available_quantity<$value){
                return false;
            }
        }
        foreach($accInv as $key=>$value){
            $inv = Inventory::find($key);
            if($inv->available_quantity<$value){
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'not Enough in stock';
    }
}
