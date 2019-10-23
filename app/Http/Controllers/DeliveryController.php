<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryItem;
use App\Models\ItemInventory;
use App\Models\ItemInventoryOut;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()->where('production_init', 1)->orderBy('id', 'desc');
        if($request->filled('job_id')){
            $orders->whereId($request->get('job_id'));
        }
        return view('order.delivery.index', ['orders'=>$orders->paginate()]);
    }

    public function create(Order $order)
    {
        return view('order.delivery.create',['order'=>$order]);
    }

    public function store(Request $request)
    {
        $delivery = Delivery::create([
            'order_id'    =>  $request->order_id,
            'delivery_date' =>  $request->delivery_date,
        ]);
        foreach($request->ordered_item_id as $key=>$value){
            if($request->quantity[$key]>0){
                DeliveryItem::create([
                    'delivery_id'   =>  $delivery->id,
                    'ordered_item_id'   =>  $value,
                    'quantity'  =>  $request->quantity[$key],
                    'item_id'   =>  $request->item_id[$key],
                    'color_id'  =>  $request->color_id[$key],
                    'remarks'   =>  $request->remarks[$key],
                ]);
            }
        }
        $this->updateDeliveryStatus($request->order_id);
        $this->updateItemInventory($request, $delivery->id);
        return redirect()->route('delivery.challan', $delivery)->with('success-message', 'Delivery Record Stored Successfully!');
    }
    public function updateItemInventory(Request $request, $deliveryId)
    {
        foreach($request->ordered_item_id as $key=>$value){
            $inventory = ItemInventory::where('item_id', $request->item_id[$key])->where('color_id', $request->color_id[$key])->first();
            if($inventory){
                $inventory->available_quantity-=$request->quantity[$key];
                $inventory->update();
                ItemInventoryOut::create([
                    'item_inventory_id' =>  $inventory->id,
                    'item_id'   =>  $request->item_id[$key],
                    'quantity'  =>  $request->quantity[$key],
                    'delivery_id'   =>  $deliveryId,
                ]);
            }
        }
    }

    public function updateDeliveryStatus($orderId)
    {
        $flag = [];
        $order = Order::find($orderId);
        foreach($order->items as $item)
        {
            if($item->getDeliveryDue()>0){
                array_push($flag, 0);
            }else{
                array_push($flag, 1);
            }
        }
        if(in_array(0, $flag)){
            $order->update([
                'delivery_status'=>0
            ]);
        }else{
            $order->update([
                'delivery_status'=>1
            ]);
        }
    }

    public function challan(Delivery $delivery)
    {
        return view('order.delivery.challan', ['delivery'=>$delivery]);
    }

    public function show(Order $order)
    {
        return view('order.delivery.show', ['order'=>$order]);
    }

    public function destroy(DeliveryItem $delivery)
    {
        $inventory = ItemInventory::where('item_id', $delivery->item_id)
            ->where('color_id', $delivery->color_id)
            ->first();
        $inventory->available_quantity += $delivery->quantity;
        $inventory->update();
        $delivery->delete();
        return back()->with('success-message', 'Delivery Canceled!');
    }
}
