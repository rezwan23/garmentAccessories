<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Commercial;
use App\Models\Garment;
use App\Models\Item;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Pi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PIController extends Controller
{
    public function create(Request $request)
    {
        $orders = null;
        if($request->filled('garments_id')){
            $orders = Commercial::whereHas('order', function($query) use ($request){
                $query->where('commercial_assigned', 1)
                    ->where('is_pi', 0)
                    ->whereHas('garments', function($q) use ($request){
                        $q->whereId($request->get('garments_id'));
                    });
            })->get();
        }
        return view('pi.create', [
            'orders'=> $orders,
            'garment'  =>   Garment::find(request()->get('garments_id')),
        ]);
    }

    public function garmentsGet(Request $request)
    {
        return Garment::where('name', 'LIKE', '%'.$request->name.'%')->where('status', 1)->get();
    }
    public function buyersGet(Request $request)
    {
        return Buyer::where('name', 'LIKE', '%'.$request->name.'%')->where('status', 1)->get();
    }
    public function merchantsGet(Request $request)
    {
        return Merchant::where('name', 'LIKE', '%'.$request->name.'%')->where('status', 1)->get();
    }
    public function itemsGet(Request $request)
    {
        return Item::where('name', 'LIKE', '%'.$request->name.'%')->get();
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'total' =>  'required',
            'garment_id'    => 'required'
        ]);
        $lastId = Pi::query()->latest('id')->pluck('id');
        if(count($lastId)==0){
            $data['serial_number']  = 1000;
        }else{
            $data['serial_number']  = 1000+$lastId[0];
        }

        $pi = Pi::create($data);
        $pi->orders()->attach($request->order_id);
        $this->updateORder($request->order_id);
        return redirect()->route('pi.print', $pi)->with('success-message', 'PI created Successfully!');
    }

    public function updateOrder($id)
    {
        foreach($id as $s_id){
            $order = Order::find($s_id);
            $order->update(['is_pi'=>1]);
        }
    }

    public function index(Request $request)
    {
        $pi = Pi::query()->with('garment', 'buyer', 'orders');
        if($request->filled('garments')){
            $pi=$pi->whereHas('garment', function($query) use ($request){
                $query->where('name', 'LIKE', '%'.$request->garments.'%');
            });
        }
        if($request->filled('buyer')){
            $pi=$pi->whereHas('buyer', function($query) use ($request){
                $query->where('name', 'LIKE', '%'.$request->buyer.'%');
            });
        }
        return view('pi.index', ['pis'=>$pi->orderBy('id','desc')->paginate()]);
    }

    public function destroy(Pi $pi)
    {
        foreach($pi->orders as $order){
            $order->update(['is_pi'=>0]);
        }
        $pi->delete();
        return back()->with('success-message', 'Pi deleted Successfully!');
    }

    function getTotal(Request $request)
    {
        if(!$request->id){
            return new Collection(['total'=>'']);
        }
        return Commercial::query()
            ->selectRaw('sum(total_amount) as total')
            ->whereIn('job_id',$request->id)
            ->first();
    }

    public function printPi(Pi $pi)
    {
        return view('pi.print', ['pi'=>$pi]);
    }
}
