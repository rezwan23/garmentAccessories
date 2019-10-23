<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:add-department')->only('index');
    }

    public function index()
    {
        $departments = Department::all();
        return view('employee.department.index',compact('departments'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $this->validate($request,[
           'name'=> 'required',
           'status'=> 'required',
        ]);
        Department::create($data);
        return back()->withResponse('Success inserted Department');
    }


    public function show(Department $department)
    {
        //
    }

    public function edit(Department $department)
    {
        $departments = Department::all();
        return view('employee.department.edit',compact('departments','department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $this->validate($request,[
            'name'=> 'required',
            'status'=> 'required',
        ]);
        $department->update($data);
        return back()->withResponse('Success Updated Department');
    }


    public function destroy(Department $department)
    {
        $department->delete();
        return back();
    }
}
