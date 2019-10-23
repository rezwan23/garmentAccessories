<?php

namespace App\Http\Controllers;

use App\Models\DyeingCompany;
use Illuminate\Http\Request;

class DyeingCompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:dyeing-company-crud');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dyeing-company.index', ['companies'=>DyeingCompany::paginate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dyeing-company.create');
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
            'emails'    =>  '',
            'phones'    =>  '',
        ]);
        DyeingCompany::create($data);
        return redirect()->route('dyeing_companies.index')->with('success-message', 'Dyeing Company Added Successfully!');
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
    public function edit(DyeingCompany $dyeing_company)
    {
        return view('dyeing-company.edit', ['company' => $dyeing_company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DyeingCompany $dyeingCompany)
    {
        $data = $this->validate($request, [
            'name'  =>  'required',
            'address'   =>  'required',
            'emails'    =>  '',
            'phones'    =>  '',
        ]);
        $dyeingCompany->update($data);
        return redirect()->route('dyeing_companies.index')->with('success-message', 'Dyeing Company Updated Successfully!');
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
    public function inactive(DyeingCompany $company)
    {
        if($company->status){
            $company->update(['status'=>0]);
        }else{
            $company->update(['status'=>1]);
        }
        return back()->with('success-message', 'Status Changed');
    }

}
