<?php

namespace App\Http\Controllers;

use App\Models\DeliveryItem;
use App\Models\DyeingCompany;
use App\Models\DyeingOrderRawMaterial;
use App\Models\DyeingYarnInventory;
use App\Models\Inventory;
use App\Models\ItemInventory;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\OrderItemRequirement;
use App\Models\PurchaseAccessoryItem;
use App\Models\ReceiveDyeingYarnMaterial;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
    public function inventory()
    {
        $data = Inventory::with('accessory', 'accessory.unit', 'todayInventoryIn', 'todayInventoryOut')->paginate();
        return view('report.inventory', [
            'data'  =>  $data,
        ]);
    }

    public function yarnInventory()
    {
        $data = DyeingYarnInventory::with([
            'accessory', 'accessory' ,'inventoryIn', 'color', 'accessory.unit',
            'inventoryInsAll.receiveYarn.orders'
        ])->paginate();
        return view('report.yarn-inventory', [
            'data'  => $data,
        ]);
    }
    public function ItemInventory()
    {
        $data = ItemInventory::with(['item', 'todayIn', 'color', 'item.unit'])->paginate();
        return view('report.item', [
            'data'  => $data,
        ]);
    }

    public function orderReport(Request $request)
    {
        $dyeingCompany = [];
        $orders = Order::with('items', 'items.producedQuantity', 'items.requirements','items.requirements.getReceivedMaterial');
        if($request->filled('job_id')){
            $orders->whereId($request->get('job_id'));
        }
        if($request->filled('start_date')&&$request->filled('end_date')){
            if($request->start_date==$request->end_date){
                $orders->whereDate('created_at', $request->start_date);
            }else{
                $orders->whereBetween('created_at',[$request->get('start_date'),$request->get('end_date')]);
            }
        }
        if($request->filled('dyeing_id')){
            $orders->where('dyeing_company_id',$request->get('dyeing_id'));
            $dyeingCompany = DyeingCompany::find($request->get('dyeing_id'));
        }
        return view('report.order', ['orders'=>$orders->orderBy('order_date', 'desc')->paginate(), 'dyeing'=>$dyeingCompany]);
    }

    public function dyeingCompanyReport(Request $request)
    {
        $data = DyeingOrderRawMaterial::query()->whereHas('itemRequirement.orderedItem.order', function($q){
            $q->where('is_active', 1);
        })
            ->selectRaw('sum(quantity) as assignedQty, dyeing_company_id, accessory_id, id')
            ->groupBy('dyeing_company_id', 'accessory_id');
        if($request->filled('dyeing_id')){
            $data->where('dyeing_company_id', $request->get('dyeing_id'));
        }
        if($request->filled('job_id')){
            $data->whereHas('itemRequirement.orderedItem.order', function($query)use($request){
               $query->where('id', $request->get('job_id'));
            });
        }
//        $data = OrderItemRequirement::query()
//            ->with('accessory', 'accessory.unit', 'dyeingCompany', 'getReceivedYarnQuantity', 'color','orderedItem', 'orderedItem.order')
//            ->where('yarn_type', 1)
//            ->join('dyeing_order_raw_materials', 'order_item_requirements.accessory_id', 'dyeing_order_raw_materials.accessory_id')
//            ->join('dyeing_orders', 'dyeing_order_raw_materials.dyeing_order_id', 'dyeing_orders.id')
//            ->selectRaw('order_item_requirements.id, order_item_requirements.ordered_item_id, order_item_requirements.accessory_id, order_item_requirements.color_id, order_item_requirements.dyeing_company_id, sum(order_item_requirements.quantity) as quantity, sum(dyeing_order_raw_materials.quantity) as totalAssignedQty')
//            ->groupBy('dyeing_orders.dyeing_company_id','order_item_requirements.accessory_id');

        return view('report.dyeing', ['allData'=>$data->paginate()]);
    }

    public function dyeingCompanyBasedReport(Request $request)
    {
        $dyeingCompany = [];
        $data = ReceiveDyeingYarnMaterial::with('color', 'receiveDyeingYarn', 'material','receiveDyeingYarn.dyeingCompany' , 'material.getReceivedMaterial', 'accessory');
        if($request->filled('job_id')){
            $data->whereHas('receiveDyeingYarn', function($query) use ($request){
                $query->whereOrderId($request->get('job_id'));
            });
        }
        if($request->filled('start_date')&&$request->filled('end_date')){
            if($request->start_date==$request->end_date){
                $data->whereDate('created_at', $request->start_date);
            }else{
                $data->whereBetween('created_at',[$request->get('start_date'),$request->get('end_date')]);
            }
        }
        if($request->filled('dyeing_id')){
            $data->whereHas('receiveDyeingYarn', function($query) use ($request){
                $query->whereDyeingCompanyId($request->get('dyeing_id'));
            });
            $dyeingCompany = DyeingCompany::find($request->get('dyeing_id'));
        }
        return view('report.dyeing-company', ['allData'=>$data->orderBy('created_at', 'desc')->paginate(), 'dyeingCompany'=>$dyeingCompany]);
    }

    public function production(Request $request)
    {
        $data = Order::query()
            ->leftJoin('ordered_items', 'orders.id', '=', 'ordered_items.order_id')
            ->leftJoin('production_items', 'ordered_items.id', '=', 'production_items.ordered_item_id')
            ->leftJoin('items', 'ordered_items.item_id', '=', 'items.id')
            ->leftJoin('units', 'items.unit_id', 'units.id')
            ->selectRaw('orders.id as jobId, ordered_items.size as itemSize, units.name as unitName, items.name as itemName, sum(production_items.quantity) as productionQuantity, production_items.created_at as productionDate, production_items.ordered_item_id')
            ->groupBy('production_items.ordered_item_id')
            ->orderBy('production_items.created_at', 'desc');
        if($request->filled('start_date') && $request->filled('end_date')){
            if($request->start_date == $request->end_date){
                $data->whereDate('production_items.created_at', $request->start_date);
            }else{
                $data->whereBetween('production_items.created_at', [
                    $request->get('start_date'),
                    $request->get('end_date'),
                ]);
            }
        }
        if($request->filled('job_id') && $request->filled('job_id')){
            $data->where('orders.id', $request->get('job_id'));
        }
        return view('report.production', ['allData' => $data->paginate()]);
    }

    public function delivery(Request $request)
    {
        $data = DeliveryItem::with('orderedItem', 'orderedItem.item' ,'orderedItem.item.unit' ,'orderedItem.order', 'orderedItem.deliveredQuantity');
        if($request->filled('start_date') && $request->filled('end_date')){
            if($request->start_date == $request->end_date){
                $data->whereDate('delivery_items.created_at', $request->start_date);
            }else{
                $data->whereBetween('delivery_items.created_at', [
                    $request->get('start_date'),
                    $request->get('end_date'),
                ]);
            }
        }
        if($request->filled('job_id')){
            $data->whereHas('orderedItem.order', function ($query) use ($request){
                $query->whereId($request->job_id);
            });
        }
        return view('report.delivery', ['allData'=>$data->orderBy('id', 'desc')->groupBy('ordered_item_id')->paginate()]);
    }

    public function purchase(Request $request)
    {
        $data = PurchaseAccessoryItem::query()->with('purchase', 'accessory', 'accessory.unit', 'inventory');
        if($request->filled('start_date') && $request->filled('end_date')){
            if($request->start_date == $request->end_date){
                $data->whereDate('created_at',$request->start_date);
            }else{
                $data->whereBetween('created_at', [
                    $request->get('start_date'),
                    $request->get('end_date'),
                ]);
            }
        }
        if($request->filled('accessory')){
            $data->whereHas('accessory', function ($query) use ($request){
                $query->where('name', 'LIKE', '%'.$request->get('accessory').'%');
            });
        }
        return view('report.purchase', ['allData' => $data->orderBy('id', 'desc')->paginate()]);
    }

    public function dailyDelivery(Request $request)
    {
        $data = DeliveryItem::query()->with('item', 'delivery', 'item.unit', 'delivery.order');
        if($request->filled('start_date') && $request->filled('end_date')){
            if($request->start_date == $request->end_date){
                $data->whereDate('delivery_items.created_at', $request->start_date);
            }else{
                $data->whereBetween('delivery_items.created_at', [
                    $request->get('start_date'),
                    $request->get('end_date'),
                ]);
            }
        }
        if($request->filled('job_id')){
            $data->whereHas('delivery.order', function ($query) use ($request){
                $query->whereId($request->job_id);
            });
        }
        return view('report.daily-delivery', ['data' => $data->orderBy('created_at', 'desc')->paginate()]);
    }
}
