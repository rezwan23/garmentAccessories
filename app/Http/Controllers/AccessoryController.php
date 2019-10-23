<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\AccessoryCategory;
use App\Models\Unit;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:raw-materials-crud');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accessory.index', ['accessories'=>Accessory::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accessory.create', [
            'categories'=>AccessoryCategory::all(),
            'units' =>  Unit::all(),
        ]);
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
            'name'  =>  'unique:accessories',
            'accessory_category_id' =>  '',
            'unit_id'   =>  '',
        ]);
        Accessory::create($data);
        return back()->with('success-message', 'Accessory Added Successfully!');
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
    public function edit(Accessory $accessory)
    {
        return view('accessory.edit', [
            'accessory'=>$accessory,
            'categories'=>AccessoryCategory::all(),
            'units' =>  Unit::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accessory $accessory)
    {
        $data = $this->validate($request,[
            'name'  =>  'unique:accessories,name,'.$accessory->id,
            'accessory_category_id' =>  '',
            'unit_id'=> '',
        ]);
        $accessory->update($data);
        return back()->with('success-message', 'Accessory Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accessory $accessory)
    {
        $accessory->delete();
        return back()->with('success-message', 'Accessory Deleted Successfully!');
    }
}
