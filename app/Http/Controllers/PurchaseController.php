<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Inventory;
use App\Models\InventoryIn;
use App\Models\InventoryOut;
use App\Models\PurchaseAccessory;
use App\Models\PurchaseAccessoryItem;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('purchase.index', ['purchases'=>PurchaseAccessory::query()->orderBy('id', 'desc')->paginate()]);
    }
    public function create()
    {
        return view('purchase.create', [
            'vendors'   =>  Vendor::where('status', 1)->get(),
            'accessories'   =>  Accessory::all(),
        ]);
    }

    public function store(Request $request)
    {
        $vendorId = $this->getVendor($request->vendor);
        if(is_null($vendorId)){
            return back()->withErrors(['error-message'=>'Please select correct vendor']);
        }
        $purhcaseRecord = PurchaseAccessory::create([
            'vendor_id' =>  $vendorId,
            'order_date'    =>  $request->order_date,
            'total_amount'  => $request->total_amount,
        ]);
        foreach($request->accessory as $key=>$value)
        {
            $acc = $this->getAccessory($value);
            if($acc==null){
                return back()->withErrors(['error-message'=>'Raw Materials Not Found']);
            }
            PurchaseAccessoryItem::create([
                'purchase_accessory_id' =>  $purhcaseRecord->id,
                'accessory_id'  =>  $acc->id,
                'unit_price'    =>  $request->unit_price[$key],
                'quantity'  =>  $request->quantity[$key],
            ]);
        }
        $this->updateInventory($request, $purhcaseRecord);
        return back()->with('success-message', 'Purchase Done!');
    }

    public function updateInventory(Request $request, PurchaseAccessory $purhcaseRecord)
    {
        foreach($request->accessory as $key=>$value){
            $acc = $this->getAccessory($value);
            $inventory = Inventory::where('accessory_id', $acc->id)->first();
            if($inventory){
                $inventory->available_quantity += $request->quantity[$key];
                $inventory->update();
            }else{
                $inventory = Inventory::create([
                    'accessory_id'  =>  $acc->id,
                    'available_quantity'=>$request->quantity[$key],
                ]);
            }
            InventoryIn::create([
                'accessory_id'  =>  $acc->id,
                'inventory_id'  =>  $inventory->id,
                'quantity'    =>  $request->quantity[$key],
                'purchase_accessory_id' =>$purhcaseRecord->id,
            ]);
        }
    }

    public function getAccessory($acc){
        $accessory = Accessory::where('name', $acc)->first();
        return $accessory;
    }
    public function getVendor($vendor){
        $ven = Vendor::where('name', $vendor)->where('status', 1)->first();
        if($ven){
            return $ven->id;
        }else{
            return null;
        }
    }

    public function getUnit(Request $request)
    {
        return Accessory::where('name', $request->accessory_name)->first()->unit;
    }

    public function show(PurchaseAccessory $purchase)
    {
        return view('purchase.view', ['purchase'=>$purchase]);
    }

    public function edit(PurchaseAccessory $purchase)
    {
        return view('purchase.edit', [
            'purchase'=>$purchase,
            'accessories'   =>  Accessory::all(),
            'vendors'   =>  Vendor::all(),
        ]);
    }

    public function update(Request $request)
    {
        return $request;
    }

    public function destroy(PurchaseAccessory $purchase)
    {
        InventoryIn::query()->where('purchase_accessory_id', $purchase->id)->delete();
        foreach($purchase->accessories as $accessory){
            $inventory = Inventory::where('accessory_id', $accessory->accessory_id)->first();
            $inventory->available_quantity -= $accessory->quantity;
            $inventory->update();
        }
        $purchase->accessories()->delete();
        $purchase->delete();
        return back()->with('success-message', 'Purchase Record Deleted Successfully!');
    }
}
