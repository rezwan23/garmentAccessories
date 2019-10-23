<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:merchant-crud');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('merchant.index', ['merchants'=>Merchant::paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name'=>'required']);
        Merchant::create(['name'=>$request->name]);
        return redirect()->route('merchants.index')->with('success-message', 'Merchant Created Successfully!');
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
    public function edit(Merchant $merchant)
    {
        return view('merchant.edit', ['merchant'=>$merchant]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merchant $merchant)
    {
        $this->validate($request, ['name'=>'required']);
        $merchant->update(['name'=>$request->name]);
        return redirect()->route('merchants.index')->with('success-message', 'Merchant updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function inactive(Merchant $merchant)
    {
        if($merchant->status){
            $merchant->update(['status'=>0]);
        }else{
            $merchant->update(['status'=>1]);
        }
        return back()->with('success-message', 'Status Changed');
    }
}
