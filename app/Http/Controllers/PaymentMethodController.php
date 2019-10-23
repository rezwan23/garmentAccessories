<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:payment-method-edit')->only('edit');
        $this->middleware('can:payment-method-delete')->only('destroy');
        $this->middleware('can:payment-method-view')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.payment-method.index', [
            'methods'=>PaymentMethod::where('status', 1)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'account_id'    =>  '',
            'name'  =>  'required',
            'status'    =>  ''
        ]);
        PaymentMethod::create($data);
        return response(['message'=>'Payment method inserted successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('account.payment-method.edit', [
            'method'    =>  $paymentMethod,
            'accounts'  =>  Account::where('status', 1)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $data = $this->validate($request, [
            'account_id'    =>  '',
            'name'  =>  'required',
            'status'    =>  ''
        ]);
        $paymentMethod->update($data);
        return redirect()->route('paymentMethod.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return back();
    }
}
