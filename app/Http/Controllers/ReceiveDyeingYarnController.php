<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Color;
use App\Models\DyeingCompany;
use App\Models\DyeingOrder;
use App\Models\DyeingYarnInventory;
use App\Models\DyeingYarnInventoryIn;
use App\Models\Order;
use App\Models\ReceiveDyeingYarnMaterial;
use App\Rules\CheckAccessoryAssigned;
use Illuminate\Http\Request;
use App\Models\ReceiveDyeingYarn;
use Illuminate\Support\Collection;

class ReceiveDyeingYarnController extends Controller
{
    public function receiveForm()
    {
        $orders = Order::where('is_assigned', 1)->get();
        return view('order.dyeing.receive.receive', ['orders'=>$orders]);
    }

    public function index()
    {
        $orders = Order::query()->whereHas('receiveYarns')->get();
        return view('order.dyeing.receive.index', ['orders'=>$orders]);
    }
    public function showReceived(Order $order)
    {
        return view('order.dyeing.receive.show', ['order'=>$order]);
    }
    // order based receive
    public function showReceiveForm(Request $request)
    {
        $orders = Order::where('is_dyeing', 1)->where('received_raw', 0)->get();
        $order = new Collection();
        if($request->filled('order')){
            $order = Order::find($request->get('order'));
        }
        return view('order.dyeing.receive.receive-order-based', ['orders'=>$orders, 'order' =>$order]);
    }

    public function receiveOrderBased(Request $request)
    {
        $order = Order::find($request->order_id);
        $request->validate([
            'accessory_id.*' => new CheckAccessoryAssigned($order->dyeing_company_id, $request),
        ]);
        $receiveYarn = ReceiveDyeingYarn::create([
            'order_id' =>  $order->id,
            'receive_date'  =>  $request->receive_date,
            'dyeing_company_id' =>  $order->dyeing_company_id,
        ]);
        foreach($request->accessory_id as $key=>$value){
            if($request->received_quantity[$key]>0){
                $receiveMaterial = ReceiveDyeingYarnMaterial::create([
                    'receive_dyeing_yarn_id' => $receiveYarn->id,
                    'accessory_id'  =>  $value,
                    'received_quantity' =>  $request->received_quantity[$key],
                    'color_id'  =>  $request->color_id[$key],
                    'material_id'   =>  $request->material_id[$key],
                    'challan_number'    =>  $request->challan_number[$key],
                ]);
            }
        }
        $this->updateDyeingYarnInventory($request, $receiveYarn->id);
        $this->updateOrderStatus($request->order_id);
        return back()->with('success-message', 'Dyeing Yarn Received Successfully!');
    }

    public function updateOrderStatus($order_id){
        $flag = [];
        $order = Order::find($order_id);
        foreach($order->items as $item){
            foreach($item->requirements as $material){
                if($material->yarn_type==1){
                    if($material->getDueReceiveCount()>0){
                        array_push($flag, 0);
                    }else{
                        array_push($flag, 1);
                    }
                }
            }
        }
        if(in_array(0, $flag )){
            $order->update(['received_raw'=>0]);
        }else{
            $order->update(['received_raw'=>1]);
        }
    }


    public function getDyeingCompany($company)
    {
        $company = DyeingCompany::where('name', $company)->first();
        if($company){
            return $company;
        }else{
            return DyeingCompany::create(['name'    =>  $company]);
        }
    }


    public function receive( Request $request,DyeingOrder $order)
    {
        $dyeingCompany = $this->getDyeingCompany($request->dyeing_company);
        $receiveYarn = ReceiveDyeingYarn::create([
            'dyeing_company_id' =>  $dyeingCompany->id,
            'receive_date'  =>  $request->receive_date,
        ]);
        foreach($request->accessory_id as $key=>$value){
            if($request->quantity[$key]>0){
                $color = $this->getColor($request->color[$key]);
                $receiveMaterial = ReceiveDyeingYarnMaterial::create([
                    'receive_dyeing_yarn_id' => $receiveYarn->id,
                    'accessory_id'  =>  $value,
                    'received_quantity' =>  $request->quantity[$key],
                    'color_id'  =>  $color->id,
                ]);
            }
        }
        $receiveYarn->orders()->attach($request->order_id);
        $this->updateDyeingYarnInventory($request, $receiveYarn->id);
        return back()->with('success-message', 'Dyeing Yarn Received Successfully!');
    }

    // getting color id
    public function getColor($colorName)
    {
        $color = Color::where('name', $colorName)->first();
        if($color){
            return $color;
        }else{
            return Color::create(['name'=>$colorName]);
        }
    }


    // updating dyeing yarn inventory
    function updateDyeingYarnInventory(Request $request, $receiveYarnId)
    {
        foreach($request->accessory_id as $key=>$value){
            if($request->received_quantity[$key]>0){
                $dyeingYarnInventory = DyeingYarnInventory::query()->where('accessory_id', $value)->where('color_id', $request->color_id[$key])->first();
                if($dyeingYarnInventory){
                    $dyeingYarnInventory->available_quantity+=$request->received_quantity[$key];
                    $dyeingYarnInventory->update();
                }else{
                    $dyeingYarnInventory = DyeingYarnInventory::create([
                        'accessory_id'=>$value,
                        'color_id'  =>  $request->color_id[$key],
                        'available_quantity'    =>     $request->received_quantity[$key],
                    ]);
                }
                DyeingYarnInventoryIn::create([
                    'accessory_id' => $value,
                    'quantity'  =>  $request->received_quantity[$key],
                    'inventory_id'  =>  $dyeingYarnInventory->id,
                    'receive_id'    =>  $receiveYarnId,
                ]);
            }
        }
    }



    // updating dyeing assign status
    public function updateDyeingOrderStatus(DyeingOrder $order)
    {
        $arr = [];
        foreach ($order->materials as $material){
            if($material->getReceiveDyeingMaterialDueQuantity()>0){
                array_push($arr, 0);
            }else{
                array_push($arr, 1);
            }
        }
        if(in_array(0, $arr)){
            $order->update(['status'=>0]);
        }else{
            $order->update(['status'=>1]);
        }
    }


    // Search Color
    public function searchColor(Request $request){
        return Color::where('name', 'LIKE', '%'.$request->get('name').'%')->get();
    }

    public function showInvoice(ReceiveDyeingYarn $receive)
    {
        return view('order.dyeing.receive.invoice', $receive);
    }

    public function getAccessory(Request $request)
    {
        return Accessory::with('unit')
            ->where('name', 'LIKE', '%'.$request->name.'%')
            ->get();
    }
}
