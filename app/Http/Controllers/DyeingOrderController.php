<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\DyeingCompany;
use App\Models\DyeingOrder;
use App\Models\DyeingOrderRawMaterial;
use App\Models\Inventory;
use App\Models\InventoryIn;
use App\Models\InventoryOut;
use App\Models\Unit;
use Illuminate\Http\Request;

class DyeingOrderController extends Controller
{

    public function index()
    {
        return view('order.dyeing.index', ['orders'=>DyeingOrder::orderBy('id', 'desc')->paginate()]);
    }
    public function create()
    {
        return view('order.dyeing.create', ['units'=>Unit::all()]);
    }

    public function allAccessories(Request $request)
    {
        return Accessory::with('unit')->where('name', 'LIKE', '%'.$request->get('name').'%')->get();
    }

    public function storeOrder(Request $request)
    {
        // checking valid accessory/raw materials
        foreach($request->accessory_id as $accessory){
            if($accessory==-1){
                return back()->withErrors(['error-message'=>'Please Select Raw Materials Correctly']);
            }
        }

        $accessories = [];

        foreach($request->accessory_id as $key=>$value){
            if(isset($accessories[$value])){
                $accessories[$value]['quantity'] += $request->quantity[$key];
            }else{
                $accessories[$value]['quantity'] = $request->quantity[$key];
            }
        }
        foreach($accessories as $key=>$values){
            foreach($values as $value){
                $inventory = Inventory::where('accessory_id', $key)->first();
                if($inventory){
                    if($inventory->available_quantity<$value){
                        return back()->withErrors(['error-message'=>'Not enough in stock']);
                    }
                }else{
                    return back()->withErrors(['error-message'=>'Plsease Purchase Raw Materials']);
                }
            }
        }
        $dyeingCompany = $this->getDyeingCompany($request->dyeing_company, $request->address);
        if($dyeingCompany==null){
            return back()->withErrors(['error-message'=>'Select Dyeing Company Correctly!']);
        }
        $order = DyeingOrder::create([
            'dyeing_company_id'    =>  $dyeingCompany->id,
            'order_date'    =>   $request->order_date,
        ]);
        foreach($request->accessory_id as $key => $value){
            DyeingOrderRawMaterial::create([
                'dyeing_order_id'   =>  $order->id,
                'dyeing_company_id' =>  $dyeingCompany->id,
                'accessory_id'  =>  $value,
                'quantity'  =>  $request->quantity[$key],
                'unit_id'  =>  Accessory::find($value)->unit->id,
                'remarks'   =>  $request->remarks[$key],
            ]);
        }
        $this->updateInventory($request);
        return redirect()->route('dyeing.order.challan', $order)->with('success-message', 'Dyeing Order Added Successfully!');
    }

    public function updateInventory(Request $request)
    {
        foreach($request->accessory_id as $key => $value){
            $inventory = Inventory::where('accessory_id', $value)->first();
            if($inventory){
                $inventory->available_quantity-=$request->quantity[$key];
                $inventory->update();
                InventoryOut::create([
                    'inventory_id'  =>  $inventory->id,
                    'accessory_id'  =>  $value,
                    'quantity'  =>  $request->quantity[$key],
                ]);
            }
        }
    }

    public function getDyeingCompany($name, $address)
    {
        $company = DyeingCompany::where('name', $name)->first();
        return $company;
    }

    public function destroy(DyeingOrder $order)
    {
        foreach($order->materials as $material){
            if(count($material->receiveMaterial)>0){
                return back()->withErrors(['error-message'=>'This Data is Used in Another Place']);
            }
        }
        $order->materials()->delete();
        $order->delete();
        return back()->with('success-message', 'Dyeing Order Deleted Successfully!');
    }

    public function challan(DyeingOrder $order)
    {
        return view('order.dyeing.challan', ['order'=>$order]);
    }

    public function getAllDyeingCompany(Request $request)
    {
        return DyeingCompany::where('name', 'LIKE', '%'.$request->get('name').'%')->where('status', 1)->get();
    }

}
