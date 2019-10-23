<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Garment;
use App\Models\Item;
use App\Models\Merchant;
use App\Models\SampleOrder;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function createOrder()
    {
        return view('sample.create', ['items'=>Item::all()]);
    }

    public function getGarments($name)
    {
        $garment = Garment::where('name', $name)->first();
        if($garment){
            return $garment->id;
        }else{
            return null;
        }
    }

    public function getMerchant($name)
    {
        $merchant = Merchant::where('name', $name)->first();
        if($merchant){
            return $merchant->id;
        }else{
            return null;
        }
    }
    public function getBuyer($name)
    {
        $buyer = Buyer::where('name', $name)->first();
        if($buyer){
            return $buyer->id;
        }else{
            return null;
        }
    }

    public function storeOrder(Request $request)
    {
        $data = $this->validate($request, [
            'item_name' =>  '',
            'garments_name' =>  '',
            'merchant_name' =>  '',
            'buyer_name'    =>  '',
            'order_number'  =>  '',
            'receive_date'  =>  '',
            'delivery_date' =>  '',
            'remarks'   =>  '',
            'status'    =>  '',
            'size'  =>  '',
        ]);
        $data['status']= 'processing';
        $data['garment_id'] = $this->getGarments($data['garments_name']);
        $data['merchant_id'] = $this->getMerchant($data['merchant_name']);
        $data['buyer_id'] = $this->getBuyer($data['buyer_name']);
        if($data['garment_id']==null || $data['merchant_id']==null ||$data['buyer_id']==null){
            return back()->withErrors(['error-message'=>'Select Correct Garment, Merchant or Buyer']);
        }
        $order = SampleOrder::create($data);
        return redirect()->route('sample.order.index')->with('success-message', 'Sample Order '.$order->id.' Created Successfully!');
    }

    public function index(Request $request)
    {
        $orders = SampleOrder::query();
        if($request->filled('delivery_date')){
            $orders->where('delivery_date', $request->get('delivery_date'));
        }
        if($request->filled('status')){
            $orders->where('status', $request->get('status'));
        }
        return view('sample.index', ['orders'=>$orders->orderBy('id','desc')->paginate()]);
    }

    public function destroy(SampleOrder $order)
    {
        $order->delete();
        return back();
    }

    public function deliver(SampleOrder $order)
    {
        return view('sample.deliver', ['order'=>$order]);
    }

    public function deliverOrder(Request $request, SampleOrder $order)
    {
        $order->update([
            'delivered_date' =>  date('y-m-d'),
            'status'    =>  'delivered',
            'delivery_person'   =>  $request->delivery_person,
        ]);
        return redirect()->route('sample.order.index')->with('success-message', 'Order '.$order->id.' Status Changed to Delivered');
    }

    public function editRemarks(SampleOrder $order)
    {
        return view('sample.edit-remarks', ['order'=>$order]);
    }

    public function updateRemarks(Request $request, SampleOrder $order)
    {
        $order->update(['remarks'=>$request->remarks]);
        return redirect()->route('sample.order.index')->with('success-message', 'Remarks Edited Successfully');
    }

    public function edit(SampleOrder $order)
    {
        return view('sample.edit', ['order' => $order,'items'=>Item::all()]);
    }

    public function update(Request $request, SampleOrder $order)
    {
        $data = $this->validate($request, [
            'item_name' =>  '',
            'garments_name' =>  '',
            'merchant_name' =>  '',
            'buyer_name'    =>  '',
            'order_number'  =>  '',
            'receive_date'  =>  '',
            'delivery_date' =>  '',
            'remarks'   =>  '',
            'status'    =>  '',
            'size'  =>  '',
        ]);
        $data['garment_id'] = $this->getGarments($data['garments_name']);
        $data['merchant_id'] = $this->getMerchant($data['merchant_name']);
        $data['buyer_id'] = $this->getBuyer($data['buyer_name']);
        if($data['garment_id']==null || $data['merchant_id']==null ||$data['buyer_id']==null){
            return back()->withErrors(['error-message'=>'Select Correct Garment, Merchant or Buyer']);
        }
        $order->update($data);
        return redirect()->route('sample.order.index')->with('success-message', 'Sample Order '.$order->id.' Created Successfully!');
    }
}
