<?php

namespace App\Http\Controllers;

use App\Models\AccountPayable;
use App\Models\YearnSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DebitPaymentController extends Controller
{
    public function index(Request $request)
    {
        $acountsPayable = new Collection();
        $vendors = YearnSupplier::all();
        if($request->filled('vendor_id')){
            $acountsPayable = AccountPayable::query()->whereHas('vendor', function($query)use($request){
                $query->whereId($request->vendor_id);
            })->get();
        }
        return view('account.general.debit.make-payment', [
            'accountsPayable'=>$acountsPayable,
            'vendors'   =>  $vendors,
        ]);
    }
}
