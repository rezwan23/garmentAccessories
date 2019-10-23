<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:allowance-&-deduction');
    }

    public function index()
    {
        $allowances = Allowance::all();
        return view('salary.allowance.index',compact('allowances'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $data = $this->validate($request,[
           'title' => 'required',
           'type' => 'required',
           'status' => 'required',
        ]);
        Allowance::create($data);
        return back()->with('success-message','Allowance and Deduction Inserted Successfully');
    }

    public function show(Allowance $allowance)
    {
        //
    }


    public function edit(Allowance $allowance)
    {
        $allowances = Allowance::all();
        return view('salary.allowance.edit',compact('allowances','allowance'));
    }


    public function update(Request $request, Allowance $allowance)
    {
        $data = $this->validate($request,[
           'title'=> 'required',
           'type' => 'required',
           'status' => 'required'
        ]);
        $allowance->update($data);
        return back()->with('success-message','Allowance and Deduction Updated Successfully');
    }

    public function destroy(Allowance $allowance)
    {
        $allowance->delete();
        return back()->with('success-message','Allowance and Deduction Deleted Successfully');
    }
}
