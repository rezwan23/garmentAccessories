<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderPrintController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->where('is_assigned', 1)
            ->orderBy('id', 'desc');
        if($request->filled('job_id')){
            $orders->where('id', $request->get('job_id'));
        }
        return view('order.print.index', [
            'orders'=> $orders->paginate(),
        ]);
    }

    public function officeCopy(Order $order)
    {
        return view('order.print.office', ['order'=>$order]);
    }

    public function factoryCopy(Order $order)
    {
        return view('order.print.factory', ['order'=>$order]);
    }

    public function dyeingCopy(Order $order)
    {
        return view('order.print.dyeing', ['order'=>$order]);
    }
}
