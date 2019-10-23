<?php

namespace App\Http\Controllers;

use App\Models\DyeingYarnInventory;
use App\Models\DyeingYarnInventoryIn;
use App\Models\DyeingYarnInventoryOut;
use App\Models\Inventory;
use App\Models\InventoryOut;
use App\Models\Item;
use App\Models\ItemInventory;
use App\Models\ItemInventoryIn;
use App\Models\Order;
use App\Models\Production;
use App\Models\ProductionItem;
use App\Models\ProductionItemRawMaterial;
use App\Rules\CheckInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductionController extends Controller
{
    public function create(Request $request)
    {
        $jobs = Order::query()
            ->with('garments')
            ->where('is_assigned', 1)
            ->where('production_status', 0)
            ->get();
        $job = new Collection();
        if($request->filled('order_id')){
            $job = Order::find($request->get('order_id'));
        }
        return view('production.create', ['jobs'=>$jobs, 'job'=>$job]);
    }

    public function getAccInventory($accessory){
        $inventory = Inventory::where('accessory_id', $accessory)->first();
        if($inventory)
            return $inventory;
        else
            return Inventory::create([
                'accessory_id'  =>  $accessory,
                'available_quantity'    =>  0,
            ]);
    }
    public function getDyeingInventory($accessory, $color){
        $inventory = DyeingYarnInventory::where('accessory_id', $accessory)->where('color_id', $color)->first();
        if($inventory)
            return $inventory;
        else
            return DyeingYarnInventory::create([
                'accessory_id'  =>  $accessory,
                'color_id'  =>  $color,
                'available_quantity'    =>  0,
            ]);
    }
    public function store(Request $request)
    {
        $order = Order::find($request->order_id);
        $this->validate($request, [
            'order_id'  =>  ['required', new CheckInventory($order)]
        ]);
        $production = Production::where('order_id', $request->order_id)->first();
        if($production){
            foreach ($request->accessory_id as $key=>$value){
                if($request->item_quantity[$key]>0){
                    ProductionItem::create([
                        'production_id' =>  $production->id,
                        'ordered_item_id'   =>  $key,
                        'quantity'  =>  $request->item_quantity[$key],
                    ]);
                }
            }
        }else{
            $production = Production::create(['order_id'=>$request->order_id]);
            foreach ($request->accessory_id as $key=>$value){
                if($request->item_quantity[$key]>0) {
                    $productionItem = ProductionItem::create([
                        'production_id' => $production->id,
                        'ordered_item_id' => $key,
                        'quantity' => $request->item_quantity[$key],
                    ]);
                }
            }
        }

        $this->updateItemInventory($request, $production->id);
        $this->updateYarnInventory($production->order_id,$production->id);
        $this->updateOrderStatus($production->order_id);
        return redirect()->route('production.index')->with('success-message', 'Production record Created!');
    }

    public function updateOrderStatus($orderId){
        $flag = [];
        $order = Order::find($orderId);
        foreach($order->items as $item){
            if($item->dueQuantity()>0){
                array_push($flag, 0);
            }else{
                array_push($flag, 1);
            }
        }
        if(in_array(0, $flag)){
            $order->update(['production_status'=>0]);
        }else{
            $order->update(['production_status'=>1]);
        }
        $order->update(['production_init'=>1]);
    }

    public function updateYarnInventory($orderId, $productionId)
    {
        $order = Order::find($orderId);
        if($order->is_production==0){
            foreach ($order->items as $item){
                foreach($item->requirements as $material){
                    if($material->yarn_type){
                        $inventory = DyeingYarnInventory::where('accessory_id', $material->accessory_id)->where('color_id', $material->color_id)->first();
                        if($inventory){
                            $inventory->available_quantity -= $material->quantity;
                            $inventory->update();
                        }
                        DyeingYarnInventoryOut::create([
                            'inventory_id'  =>  $inventory->id,
                            'accessory_id'  =>  $material->accessory_id,
                            'quantity'  =>  $material->quantity,
                            'production_id' =>  $productionId,
                        ]);
                    }else{
                        $inventory = Inventory::where('accessory_id', $material->accessory_id)->first();
                        if($inventory){
                            $inventory->available_quantity -= $material->quantity;
                            $inventory->update();
                        }
                        InventoryOut::create([
                            'inventory_id'  =>  $inventory->id,
                            'accessory_id'  =>  $material->accessory_id,
                            'quantity'  =>  $material->quantity,
                        ]);
                    }
                }
            }
        }
        $order->update(['is_production'=>1]);
    }

    public function updateItemInventory(Request $request, $productionId)
    {
        foreach($request->item_id as $key=>$value){
            $itemInventory = ItemInventory::where('item_id', $value)
                ->where('color_id', $request->item_color_id[$key])
                ->first();
            if(!$itemInventory){
                $itemInventory = ItemInventory::create([
                    'item_id' => $value,
                    'color_id'  =>  $request->item_color_id[$key],
                    'available_quantity'    =>  $request->item_quantity[$key],
                ]);
            }else{
                $itemInventory->available_quantity += $request->item_quantity[$key];
                $itemInventory->update();
            }
            ItemInventoryIn::create([
                'item_id' => $request->item_id[$key],
                'quantity'  =>  $request->item_quantity[$key],
                'item_inventory_id' =>  $itemInventory->id,
                'production_id' =>  $productionId,
            ]);
        }
    }

    public function index()
    {
        return view('production.index', [
            'productions'   =>  Production::query()->orderBy('id', 'desc')->paginate(),
        ]);
    }

    public function destroy(ProductionItem $production)
    {
        return $production;
        $orderedItem = $production->item;
        $order = $orderedItem->order;
        $inventory = ItemInventory::query()
        ->where('item_id', $orderedItem->item->id)
            ->where('color_id', $orderedItem->color_id)
            ->first();
        if($production->quantity>$inventory->available_quantity){
            $production->update(['quantity'=>$production->quantity-$inventory->available_quantity]);
            $inventory->update(['available_quantity'=>0]);
            return back()->with('success-message', 'Stock Inventory Updated');
        }else{
            $production->delete();
            $inventory->update(['available_quantity'=>$inventory->available_quantity-$production->quantity]);
        }
        $order->update(['production_status'=>0]);
        return back()->with('success-message', 'Production Item Deleted');
    }

    public function view(Production $production)
    {
        return view('production.show', ['production'=>$production]);
    }
}
