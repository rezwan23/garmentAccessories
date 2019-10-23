<?php

namespace App\Http\Controllers;

use App\Models\YearnSupplier;
use Illuminate\Http\Request;

class YearnSupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-all-supplier')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('yearn-supplier.index', [
            'suppliers' =>  YearnSupplier::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('yearn-supplier.create');
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
            'name'  =>  'required',
            'phone' =>  'required',
            'address'   =>  'required',
            'email'     =>  'required',
            'representative'    =>  'required',
            'website_address'   =>  '',
        ]);
        $data['created_by']= auth()->user()->id;
        YearnSupplier::create($data);
        return redirect()->route('yearn_supplier.index');
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
    public function edit(YearnSupplier $yearn_supplier)
    {
        return $yearn_supplier;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,YearnSupplier $yearn_supplier)
    {
        $data = $this->validate($request, [
            'name'  =>  'required',
            'phone' =>  'required',
            'address'   =>  'required',
            'email'     =>  'required',
            'representative'    =>  'required',
            'website_address'   =>  '',
        ]);
        $yearn_supplier->update($data);
        return $yearn_supplier;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(YearnSupplier $yearn_supplier)
    {
        $yearn_supplier->delete();
        return back();
    }
}
