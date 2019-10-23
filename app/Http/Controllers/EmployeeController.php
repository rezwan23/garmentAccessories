<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;

use Illuminate\Support\Collection;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:add-employee')->only('create');
        $this->middleware('can:salary-setup')->only('salarySetup');
    }

    public function index()
    {
        $employees = Employee::all();
        return view('employee.profile_employee.index',compact('employees'));
    }

    public function create()
    {
       $departments = Department::where('status',1)->get();
       return view('employee.profile_employee.create',compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request,[
           'depart_id' => 'required',
           'desig_id' => 'required',
           'joining' => '',
           'salary' => 'required|numeric',
           'fName' => 'required',
           'faName' => '',
           'moName' => '',
           'gender' => 'required',
           'blood' => 'required',
           'religion' => 'required',
           'nid' => '',
           'dob' => '',
           'marriage' => 'required',
           'phone' => 'required',
           'email' => '',
           'phone_emer' => '',
           'image' => 'image|mimes:jpg,png,jpeg',
           'present_add' => '',
           'permanent_add' => '',
        ]);

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $fileName = $image->hashName();
            $location = public_path('uploads/employee/'.$fileName);
            Image::make($image)->resize(120,120)->save($location);
            $data['image'] = 'uploads/employee/'.$fileName;
        }


//        if ($request->hasFile('image'))
//        {
//
//            $data['image']=$request->file('image')->store('/employee');
//        }
        Employee::create($data);
        return back()->with('success-message', 'Employee Inserted Successfully');
    }

    public function show(Employee $employee)
    {
        //
    }

    public function edit(Employee $employee)
    {
        $departments = Department::where('status',1)->get();
        return view('employee.profile_employee.edit',compact('employee','departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $this->validate($request,[
            'depart_id' => 'required',
            'desig_id' => 'required',
            'joining' => '',
            'salary' => 'required|numeric',
            'fName' => 'required',
            'faName' => '',
            'moName' => '',
            'gender' => 'required',
            'blood' => 'required',
            'religion' => 'required',
            'nid' => '',
            'dob' => '',
            'marriage' => 'required',
            'phone' => 'required',
            'email' => '',
            'phone_emer' => '',
            'image' => 'image|mimes:jpg,png,jpeg',
            'present_add' => '',
            'permanent_add' => '',
        ]);

        if ($request->hasFile('image'))
        {
            Storage::delete($employee->image);
            $image = $request->file('image');
            $fileName = $image->hashName();
            $location = public_path('uploads/employee/'.$fileName);
            Image::make($image)->resize(120,120)->save($location);
            $data['image'] = 'uploads/employee/'.$fileName;
        }
        $employee->update($data);
        return back()->with('success-message', 'Employee Updated Successfully');
    }

    public function destroy(Employee $employee)
    {
        Storage::delete($employee->image);
        $employee->delete();
        return back()->with('success-message', 'Employee Deleted Successfully');
    }

    public function getDesignations(Request $request)
    {
        return Department::find($request->get('id'))->designations;
    }


}
