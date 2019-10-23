<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountPayable;
use App\Models\AccountPayableDetail;
use App\Models\AccountSector;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\YearnSupplier;
use Illuminate\Http\Request;

class AccountPayableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.general.debit.account-payable.index', [
            'accounts' => AccountPayable::with('details')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('account.general.debit.account-payable.create', [
            'vendors' => YearnSupplier::all(),
            'sectors' => AccountSector::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendorId = $this->manageVendor($request->vendor);
        if ($vendorId == null) {
            return back()->withErrors(['message' => 'Vendor not found']);
        }
        $accountPayable = AccountPayable::create([
            'vendor_id' => $vendorId,
            'lc_number' => $request->lc_number,
            'order_number' => $request->order_number,
            'order_date' => $request->order_date,
            'total_amount' => $request->total_amount,
            'due' => $request->total_amount,
        ]);
        foreach ($request->sector as $key => $value) {
            $sectorId = $this->getSectorId($request->sector[$key]);
            AccountPayableDetail::create([
                'sector_id' => $sectorId,
                'account_payable_id' => $accountPayable->id,
                'amount' => $request->amount[$key],
                'description' => $request->description[$key],
            ]);
        }
        return back();
    }

    private function getSectorId($sectorName)
    {
        $sector = AccountSector::where('name', $sectorName)->first();
        return $sector->id;
    }

    private function manageVendor($vendor)
    {
        $vendor = YearnSupplier::where('name', $vendor)->first();
        if ($vendor != null) {
            return $vendor->id;
        }
        return $vendor;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(AccountPayable $accountPayable)
    {
        return view('account.general.debit.account-payable.show', [
            'details' => $accountPayable->details,
            'account' => $accountPayable,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getVendors()
    {
        return YearnSupplier::all();
    }

    public function payment(AccountPayable $accountPayable)
    {
        return view('account.general.debit.account-payable.payment', [
            'account'   =>  $accountPayable,
            'accounts'  =>  Account::all(),
        ]);
    }

    public function makePayment(Request $request, AccountPayable $accountPayable)
    {
        $data = $this->validate($request, [
            'account_id'    => 'required|numeric',
            'payment_method_id' =>  'required|numeric',
            'ref_id'    =>  'required',
            'paid_amount'   =>  'required',
            'date'  =>  'required',
        ]);
        $data['account_payable_id'] = $accountPayable->id;
        $accountPayable->due-=$data['paid_amount'];
        $accountPayable->update();
        Payment::create($data);
        return redirect()->route('accountPayable.index');
    }

    public function getMethods(Request $request)
    {
        return Account::find($request->account_id)->paymentMethods;
    }
}
