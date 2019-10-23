<?php

namespace App\Http\Controllers;

use App\Models\Garment;
use Illuminate\Http\Request;

class GarmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:garments-crud');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('garments.index', ['garments'=>Garment::paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('garments.create');
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
            'address'   =>  'required',
            'phone_number'  =>  '',
            'email' =>  '',
        ]);
        Garment::create($data);
        return redirect()->route('garments.index')->with('success-message', 'Garment Added Successfully!');
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
    public function edit(Garment $garment)
    {
        return view('garments.edit', ['garment'=>$garment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Garment $garment)
    {
        $data = $this->validate($request, [
            'name'  =>  'required',
            'address'   =>  'required',
            'phone_number'  =>  '',
            'email' =>  ''
        ]);
        $garment->update($data);
        return redirect()->route('garments.index')->with('success-message', 'Garments Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Garment $garment)
    {
        //
    }

    public function inactive(Garment $garment)
    {
        if($garment->status){
            $garment->update(['status'=>0]);
        }else{
            $garment->update(['status'=>1]);
        }
        return back()->with('success-message', 'Status Changed');
    }
}
