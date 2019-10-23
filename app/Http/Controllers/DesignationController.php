<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:add-designation')->only('index');
    }

    public function index()
    {
        $departments = Department::where('status',1)->get();
        $designations = Designation::all();
        return view('employee.designation.index',compact('designations','departments'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $this->validate($request,[
           'department_id' => 'required',
           'name' => 'required',
           'status' => 'required',
        ]);
        Designation::create($data);
        return back()->withResponse('Success Inserted Designation');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $departments = Department::where('status',1)->get();
        $edit = Designation::find($id);
        return view('employee.designation.edit',compact('edit','departments'));
    }

    public function update(Request $request, Designation $designation)
    {
        $data = $this->validate($request,[
            'department_id' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        $designation->update($data);
        return back()->withResponse('Success Updated Desigantion');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return back();
    }
}
