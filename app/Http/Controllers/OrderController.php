<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Buyer;
use App\Models\Color;
use App\Models\Commercial;
use App\Models\CommercialDetail;
use App\Models\DyeingCompany;
use App\Models\Garment;
use App\Models\Item;
use App\Models\Lc;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\OrderItemRequirement;
use App\Models\Pi;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()->where('is_active', 1);
        if($request->filled('delivery_status')){
            $orders = $orders->where('delivery_status', $request->get('delivery_status'));
        }
        if($request->filled('garments')){
            $orders = $orders->whereHas('garments', function($query) use ($request){
                $query->whereName($request->garments);
            });
        }
        if($request->filled('job_id')){
            $orders = $orders->where('id', $request->get('job_id'));
        }
        if($request->filled('style')){
            $orders = $orders->where('style_number','LIKE' , '%'.$request->get('style').'%');
        }
        if($request->filled('pi')){
            $orders = $orders->whereHas('pis', function($query) use ($request){
                $query->whereSerialNumber($request->get('pi'));
            });
        }
        return view('order.index', ['orders'=>$orders
            ->with('commercial', 'commercial.lcDetails', 'commercial.lcDetails.lc', 'garments', 'merchant', 'buyer')
            ->orderBy('id', 'desc')
            ->paginate(), 'garments'=>Garment::all(),
            'allOrders' =>  Order::where('is_assigned', 1)->get(),
            'pis'   =>  Pi::all(),
            ]);

    }

    public function toBeGivenRawMaterialsOrders()
    {
        return view('order.raw', ['orders'=>Order::where('is_assigned', 0)->orderBy('id', 'desc')->paginate()]);
    }
    public function showForm()
    {
        $garments = Garment::where('status', 1)->get();
        $merchants = Merchant::where('status', 1)->get();
        $buyers = Buyer::where('status', 1)->get();
        $items = Item::all();
        $colors = Color::all();
        return view('order.new', [
            'garments'  =>  $garments,
            'merchants' =>  $merchants,
            'buyers'    =>  $buyers,
            'items' =>  $items,
            'colors'    =>  $colors,
        ]);
    }
    public function OrderCreate(Request $request)
    {
        foreach($request->item_name as $key => $value){
            $item = $this->getItems($request->item_name[$key]);
            if($item==null){
                return back()->withErrors(['error-message'=>'Item Not Found']);
            }
        }
        $this->validate($request, [
            'garments_name' =>  'required',
            'merchant_name' =>  'required',
            'buyer_name'    =>  'required',
            'order_date'    =>  'required',
            'delivery_date' =>  'required',
        ]);
        $garmentsId = $this->getGarments($request->garments_name, $request->address);
        $merchantId = $this->getMErchant($request->merchant_name);
        $buyerId = $this->getBuyer($request->buyer_name);
        if(is_null($garmentsId)||is_null($merchantId)||is_null($buyerId)){
            return back()->withErrors((['error-message'=>'Please Select Correct garments, merchant or buyer']));
        }
        $order = Order::create([
            'garments_id'   =>  $garmentsId,
            'merchant_id'   =>  $merchantId,
            'buyer_id'   =>  $buyerId,
            'order_date'    =>  $request->order_date,
            'delivery_date' =>  $request->delivery_date,
            'is_assigned'   =>  0,
            'commercial_assigned'   =>  0,
            'style_number'  =>  $request->style,
        ]);
        foreach($request->item_name as $key => $value){
            $item = $this->getItems($request->item_name[$key]);
            $colorId = $this->getColor($request->color[$key]);
            OrderedItem::create([
                'item_id'   =>  $item->id,
                'color_id'  =>  $colorId,
                'style_number'  =>  $request->style_number[$key],
                'quality'   =>  $request->quality[$key],
                'unit_price'    =>  $request->unit_price[$key],
                'quantity'  =>  $request->quantity[$key],
                'order_id'  =>  $order->id,
                'size'  =>  $request->size[$key],
            ]);
        }
        return redirect()->route('order.index')->with('success-message', 'Order '.$order->id.' Added Successfully!');
    }

    public function getColor($name)
    {
        $color = Color::where('name', $name)->first();
        if($color){
            return $color->id;
        }else{
            return Color::create(['name'=>$name])->id;
        }
    }
    public function getItems($name)
    {
        $item = Item::where('name', $name)->first();
        return $item;
    }
    public function getGarments($name, $address)
    {
        $garments = Garment::where('name', $name)->where('status', 1)->first();
        if($garments){
            if(empty($garments->address)){
                $garments->update(['address'=>$address]);
            }
            return $garments->id;
        }else{
            return null;
        }
    }
    public function getMErchant($name)
    {
        $merchant = Merchant::where('name', $name)->where('status', 1)->first();
        if($merchant){
            return $merchant->id;
        }else{
            return null;
        }
    }
    public function getBuyer($name)
    {
        $buyer = Buyer::where('name', $name)->where('status', 1)->first();
        if($buyer){
            return $buyer->id;
        }else{
            return null;
        }
    }

    public function edit(Order $order)
    {
        $garments = Garment::where('status', 1)->get();
        $merchants = Merchant::where('status', 1)->get();
        $buyers = Buyer::where('status', 1)->get();
        $items = Item::all();
        $colors = Color::all();
        return view('order.edit', [
            'order'=>$order,
            'garments'  =>  $garments,
            'merchants' =>  $merchants,
            'buyers'    =>  $buyers,
            'items' =>  $items,
            'colors'    =>  $colors,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $garmentsId = $this->getGarments($request->garments_name, $request->address);
        $merchantId = $this->getMErchant($request->merchant_name);
        $buyerId = $this->getBuyer($request->buyer_name);
        if(is_null($garmentsId)||is_null($merchantId)||is_null($buyerId)){
            return back()->withErrors((['error-message'=>'Please Select Correct garments, merchant or buyer']));
        }
        $order->update([
            'garments_id'   =>  $garmentsId,
            'merchant_id'   =>  $merchantId,
            'buyer_id'   =>  $buyerId,
            'order_date'    =>  $request->order_date,
            'delivery_date' =>  $request->delivery_date,
        ]);
        foreach($request->item_name as $key => $value){
            $orderedItem = OrderedItem::find($request->item_id[$key]);
            $orderedItem->update([
                'quantity'=>$request->quantity[$key],
                'size'  =>  $request->size[$key],
                'color_id'  =>  $request->color_id[$key],
            ]);
        }
        return redirect()->route('order.index')->with('success-message', 'Order Updated Successfully!');
    }

    public function show(Order $order)
    {
        return view('order.show', ['order'=>$order]);
    }

    public function destroy(Order $order)
    {
        if($order->commercial_assigned==1){
            return back()->withErrors(['error-message'=>'This Data has been used in another data table']);
        }
        foreach ($order->items as $s_item){
            if($s_item->producedQuantity){
                return back()->withErrors(['error-message'=>'This Data has been used in another data table']);
            }
        }
        foreach ($order->items as $item){
            $item->requirements()->delete();
        }
        $order->items()->delete();
        $order->delete();
        return back()->with('success-message', 'Order Deleted Successfully!');
    }

    public function assingRequirementsForm(Order $order)
    {
        return view('order.requirements.new', [
            'order'=>$order,
            'accessories'=>Accessory::all()
        ]);
    }

    public function assignRequirements(Request $request, Order $order)
    {
        if($order->is_assigned == 0) {
            $is_dyeing = 0;
            if ($request->dyeing_company != null) {
                $dyeingCompany = $this->getDygingCompany($request->dyeing_company, $request->address);
                if($dyeingCompany == null){
                    return back()->withErrors(['error-message'=>'Select Correct Dyeing Company']);
                }
                $order->update(['dyeing_company_id' => $dyeingCompany->id, 'dyeing_delivery_date' =>$request->dyeing_delivery_date]);
            }
            foreach ($request->accessory_name as $key => $value) {
                foreach ($value as $singleKey => $singleValue) {
                    if (isset($request->color[$key][$singleKey])) {
                        $is_dyeing = 1;
                        $yarnType = 1;
                        $color_id = $request->color[$key][$singleKey];
                    } else {
                        $yarnType = 0;
                        $color_id = null;
                    }
                    $accessory = Accessory::where('name', $singleValue)->first();
                    OrderItemRequirement::create([
                        'ordered_item_id' => $key,
                        'yarn_type' => $yarnType,
                        'dyeing_company_id' => $yarnType && $dyeingCompany?$dyeingCompany->id:null,
                        'color_id' => $color_id,
                        'accessory_id' => $accessory->id,
                        'quantity' => $request->accessory_quantity[$key][$singleKey],
                    ]);
                }
            }
            if ($request->dyeing_company != null) {
                $order->update(['dyeing_company_id' => $dyeingCompany->id, 'dyeing_delivery_date' =>$request->dyeing_delivery_date]);
            }
            $order->update(['is_assigned'=>1, 'is_dyeing'=>$is_dyeing]);
        }
        return redirect()->route('order.print.dyeing', $order)->with('success-message', 'Order '.$order->id.' Added Successfully!');
    }

    public function getDygingCompany($name, $address){
        $company = DyeingCompany::where('name', $name)->where('address', $address)->first();
        if($company){
            return $company;
        }else{
            return null;
        }
    }


    public function viewRequirements(Order $order)
    {
        return view('order.requirements.show', ['order'=>$order]);
    }

    public function assingCommercialForm(Request $request)
    {
        $orders = Order::query()->where('commercial_assigned', 0)->get();
        $orderDetails = new Collection();
        if($request->filled('order_id')){
            $orderDetails = Order::find($request->get('order_id'));
        }
        return view('order.commercial.assign', ['orders' =>  $orders, 'orderDetails' => $orderDetails]);
    }

    public function commercialStore(Request $request)
    {
        $last = Commercial::latest();
        $commercial = Commercial::create([
            'job_id'    =>  $request->job_id,
            'total_amount'  =>  $request->total_amount,
            'created_by'    =>  auth()->user()->id,
            'serial_number' =>  $last->count()==0?1000:1000+$last->first()->id,
        ]);
        foreach($request->ordered_item_id as $key=>$value)
        {
            CommercialDetail::create([
                'commercial_id'   =>  $commercial->id,
                'ordered_item_id'   =>  $value,
                'unit_price'    =>  $request->unit_price[$key],
                'quantity'      =>  $request->quantity[$key],
                'style_number'  =>  $request->style_number[$key],
            ]);
        }
        $order = Order::find($request->job_id);
        $order->update(['commercial_assigned'=> 1]);
        return redirect()->route('orders.commercial.assigned.get')->with('success-message', 'Commercial Details Added Successfully!');
    }

    public function showCommercialAssignedOrders(Request $request)
    {
        $orders = Order::query();
        if($request->filled('job_id')){
            $orders = $orders->where('id', $request->get('job_id'));
        }
        if($request->filled('garments')){
            $orders = $orders->whereHas('garments', function($query) use ($request){
                $query->whereName($request->get('garments'));
            });
        }
        if($request->filled('lc')){
            $orders = $orders->whereHas('commercial.lcDetails.lc', function($query) use ($request){
                $query->whereLcNumber($request->get('lc'));
            });
        }
        return view('order.commercial.assigned', [
            'orders'=> $orders
            ->with('garments', 'merchant', 'buyer', 'commercial', 'commercial.lcDetails.lc')
            ->where('commercial_assigned', 1)
            ->orderBy('id', 'desc')
            ->paginate(),
            'garments'  =>  Garment::all(),
            'allOrders' =>  Order::where('commercial_assigned', 1)->get(),
            'lcs'   =>  Lc::all(),
        ]);
    }

    public function editCommercial(Order $order)
    {
        return view('order.commercial.edit-commercial', ['order'=>$order]);
    }

    public function updateCommercial(Request $request, Order $order)
    {
//        return $request;
        foreach($request->ordered_item_id as $key=>$value){
            foreach($value as $singleKey => $singleValue){
                $commercialDetails = CommercialDetail::find($key);
                $commercialDetails->update([
                    'unit_price'    =>  $request->unit_price[$key][$singleKey],
                    'quantity'  =>  $request->quantity[$key][$singleKey],
                    'updated_by'    =>  auth()->user()->id,
                ]);

            }
        }
        $commercial = $order->commercial();
        $commercial->update(['total_amount'=>$request->total_amount,'updated_by'    =>  auth()->user()->id,]);
        $order->update(['commercial_assigned'=>1,'updated_by'    =>  auth()->user()->id,]);
        return back()->with('success-message', 'Commercial Details Updated Successfully');
    }

    public function commercialDestroy(Order $order)
    {
        foreach($order->commercial->commercials as $single){
            $single->delete();
        }
//        $order->commercial->commercials()->delete();
        $order->commercial->delete();
        $order->update(['commercial_assigned'=>0]);
        return back()->with('success-message', 'Commercial Details Deleted Successfully!');
    }

    public function getItemDetails(Request $request)
    {
        $item = Item::where('name', $request->get('name'))->first();
        return $item->unit;
    }

    public function getAccessoryUnitDetails(Request $request)
    {
        $accessory = Accessory::where('name', $request->get('name'))->first();
        return $accessory->unit;
    }

    public function getAccessoryColorDetails(Request $request)
    {
        return Color::all();
    }

    public function getGarmentsInfo(Request $request){
        return Garment::where('name', 'LIKE', '%'.$request->name.'%')->where('status', 1)->get();
    }

    public function commercialAssignedPrint(Order $order)
    {
        return view('order.commercial.print', ['order'=>$order]);
    }

    public function viewCommercial(Order $order)
    {
        return view('order.commercial.view', ['order'=>$order]);
    }

    public function requirementsEdit(Order $order)
    {
        if($order->is_production){
            return back()->withErrors(['error-message'=>'Sorry! Editing this data may hamper your application']);
        }
        return view('order.requirements.edit', ['order'=>$order, 'accessories'=>Accessory::all()]);
    }

    public function requirementsUpdate(Order $order, Request $request)
    {
        foreach($order->items as $item)
        {
            foreach($item->requirements as $requirement){
                $requirement->delete();
            }
        }
            $is_dyeing = 0;
            if ($request->dyeing_company != null) {
                $dyeingCompany = $this->getDygingCompany($request->dyeing_company, $request->address);
                if($dyeingCompany == null){
                    return back()->withErrors(['error-message'=>'Select Correct Dyeing Company']);
                }
                $order->update(['dyeing_company_id' => $dyeingCompany->id, 'dyeing_delivery_date' =>$request->dyeing_delivery_date]);
            }
            foreach ($request->accessory_name as $key => $value) {
                foreach ($value as $singleKey => $singleValue) {
                    if (isset($request->color[$key][$singleKey])) {
                        $is_dyeing = 1;
                        $yarnType = 1;
                        $color_id = $request->color[$key][$singleKey];
                    } else {
                        $yarnType = 0;
                        $color_id = null;
                    }
                    $accessory = Accessory::where('name', $singleValue)->first();
                    OrderItemRequirement::create([
                        'ordered_item_id' => $key,
                        'yarn_type' => $yarnType,
                        'dyeing_company_id' => $yarnType && $dyeingCompany?$dyeingCompany->id:null,
                        'color_id' => $color_id,
                        'accessory_id' => $accessory->id,
                        'quantity' => $request->accessory_quantity[$key][$singleKey],
                    ]);
                }
            }
            if ($request->dyeing_company != null) {
                $order->update(['dyeing_company_id' => $dyeingCompany->id, 'dyeing_delivery_date' =>$request->dyeing_delivery_date]);
            }
            $order->update(['is_assigned'=>1, 'is_dyeing'=>$is_dyeing]);
            return back()->with('success-message', 'Raw materials updated successfully!');
    }

    public function changeStatus(Order $order)
    {
        if($order->is_active){
            $order->update(['is_active' => 0]);
        }else{
            $order->update(['is_active' => 1]);
        }
        return back();
    }

    public function inactiveOrders()
    {
        return view('order.inactive', ['orders'=>order::where('is_active', 0)->latest()->paginate()]);
    }
}
