<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    //showing info form
    public function index()
    {
        $info = Auth::user()->company;
        return view('company.index', ['info'=>$info]);
    }

    public function update(Request $request)
    {
        if($request->company_id!=Auth::user()->company_id){
            return back()->withErrors(['message'=>'You Are Not Authorized']);
        }
        $data = $this->validate($request, [
            'name'  =>  'required',
            'website'   =>  '',
            'emails'    =>  'required',
            'phones'    =>  'required',
            'logo'  =>  'image',
            'address'   =>  'required',
            'terms_conditions'  =>  '',
            'authorize_name'    =>  '',
            'additional_details'    =>  '',
            'dyeing_delivery_place' =>  ''
        ]);
        $info = Company::find($request->company_id);
        if($info!=null){
            $this->infoUpdate($request, $info, $data);
        }else{
            $this->infoCreate($request, $data);
        }
        return back();
    }

    public function infoUpdate(Request $request, Company $info, $data)
    {
        if($request->hasFile('logo')){
            $logo = $request->file('logo');
            if($info->logo!=null){
                Storage::delete($info->logo);
            }
            $newLogo = $logo->store('/');
            $data['logo'] = $newLogo;
        }
        $info->update($data);
    }

    public function infoCreate(Request $request, $data)
    {
        $logo = $request->file('logo');
        $newLogo = $logo->store('/');
        $data['logo']   = $newLogo;
        Company::create($data);
    }
}
