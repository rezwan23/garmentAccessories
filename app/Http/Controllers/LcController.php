<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Commercial;
use App\Models\Garment;
use App\Models\Lc;
use App\Models\LcDetails;
use App\Models\Pi;
use Illuminate\Http\Request;

class LcController extends Controller
{
    public function create()
    {
        $pis = Pi::where('is_lc', 0)->get();
        return view('pi.lc.create', ['pis'=>$pis]);
    }

    public function search(Request $request)
    {
        return Pi::query()->where('serial_number', $request->serial)->where('is_lc', 0)->first();
    }

    public function store(Request $request)
    {
        $lc = Lc::create([
            'total_value'   =>  $request->all_total,
            'seller_bank'   =>  $request->seller_bank,
            'seller_bank_branch' => $request->seller_bank_branch,
            'buyer_bank'    => $request->buyer_bank,
            'buyer_bank_branch'=> $request->buyer_bank_branch,
            'lc_number' =>  $request->lc_number,
            'payment_terms' =>  $request->payment_terms,
            'party_date'    =>  $request->party_date,
            'bank_date' =>  $request->bank_date,
            'accept_date'   =>  $request->accept_date,
            'adjust_remarks'    =>  $request->adjust_remarks,
            'garment_id'    =>  $request->garment_id,
            'bank_ref_no'   =>  $request->bank_ref_no,
        ]);
        foreach($request->serial_number as $key=>$value){
            $pi = Pi::where('serial_number', $value)->first();
            if($pi){
                $pi->update(['is_lc'=> 1]);
            }
            LcDetails::create([
                'serial_number' =>  $value,
                'lc_id' =>  $lc->id,
                'total_value'   => $request->total_value[$key],
            ]);
        }
        return redirect()->route('lc.index')->with('success-message', 'LC Created Successfully');
    }

    public function edit(Lc $lc)
    {
        return view('pi.lc.edit', ['lc'=>$lc]);
    }

    public function update(Request $request, Lc $lc)
    {
        $lc->update([
            'seller_bank'   =>  $request->seller_bank,
            'seller_bank_branch' => $request->seller_bank_branch,
            'buyer_bank'    => $request->buyer_bank,
            'buyer_bank_branch'=> $request->buyer_bank_branch,
            'lc_number' =>  $request->lc_number,
            'payment_terms' =>  $request->payment_terms,
            'party_date'    =>  $request->party_date,
            'bank_date' =>  $request->bank_date,
            'accept_date'   =>  $request->accept_date,
            'adjust_remarks'    =>  $request->adjust_remarks,
            'garment_id'    =>  $request->garment_id,
            'bank_ref_no'   =>  $request->bank_ref_no,
        ]);
        return redirect()->route('lc.index')->with('success-message', 'LC Updated Successfully');
    }

    public function index(Request $request)
    {
        $lcs = Lc::query()->with('lcDetails')->orderBy('id', 'desc');
        if($request->filled('garments')){
            $lcs = $lcs->whereHas('garment', function($query) use ($request){
                $query->whereName($request->garments);
            });
        }
        return view('pi.lc.index', [
            'lcs'=>$lcs->paginate(),
            'garments'  =>  Garment::all(),
            'buyers'    =>  Buyer::all(),
        ]);
    }

    public function view(Lc $lc)
    {
        return view('pi.lc.view', ['lc'=>$lc]);
    }

    public function destroy(Lc $lc)
    {
        foreach($lc->lcDetails as $detail){
            $pi = Commercial::where('serial_number', $detail->serial_number)->first();
            if($pi){
                $pi->update(['is_lc'=>0]);
            }
        }
        $lc->lcDetails()->delete();
        $lc->delete();
        return back()->with('success-message', 'Lc deleted successfully');
    }

    public function printLc(Lc $lc)
    {
        return view('pi.lc.print', ['lc'=>$lc]);
    }

    public function markAsDone(Lc $lc)
    {
        $lc->markAsDone();
        return back()->with('success-message', 'Lc Status Changed To Done');
    }
    public function markAsPending(Lc $lc)
    {
        $lc->markAsPending();
        return back()->with('success-message', 'Lc Status Changed To Pending');
    }
}
