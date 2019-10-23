<?php

namespace App\Http\Controllers;

use App\Models\AccessoryCategory;
use Illuminate\Http\Request;

class AccessoryCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:materials-category-crud');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accessory-category.index', ['categories'=>AccessoryCategory::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accessory-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AccessoryCategory::create(['name'=>$request->name]);
        return redirect()->route('accessory_category.index')->with('success-message', 'Category Added Successfully!');
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
    public function edit(AccessoryCategory $accessory_category)
    {
        return view('accessory-category.edit', ['category'=>$accessory_category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccessoryCategory $accessory_category)
    {
        $accessory_category->update(['name'=>$request->name]);
        return redirect()->route('accessory_category.index')->with('success-message', 'Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccessoryCategory $accessory_category)
    {
        $accessory_category->delete();
        return back()->with('success-message', 'Data Deleted Successfully!');
    }
}
