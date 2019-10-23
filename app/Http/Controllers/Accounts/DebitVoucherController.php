<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Resources\DebitVoucherPartyResource;
use App\Models\Account;
use App\Models\PaymentMethod;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\{Request, Response};
use App\Models\Accounts\{DebitVoucherPayment, DebitVoucherRecord, Party, DebitVoucher};

class DebitVoucherController extends Controller
{
    public function __construct(){
        $this->middleware('can:debit-voucher-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $voucher = DebitVoucher::with('party');

        if($request->filled('id')){
            $voucher->whereId($request->get('id'));
        }

        if($request->filled('name')){
            $voucher->whereHas('party', function (Builder $query) use($request){
                $query->where('name', 'like', "%{$request->get('name')}%");
            });
        }

        return view('account.general.debit.voucher.index', [
            'vouchers' => $voucher->latest()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('account.general.debit.voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'party_id' => 'required|exists:parties,id',
            'sectors' => 'required',
            'sectors.*.amount' => 'required|numeric|min:1',
            'sectors.*.account_sector_id' => 'required|numeric|distinct',
        ]);

        /** @var DebitVoucher $voucher */
        $voucher = DebitVoucher::create(array_merge($request->all(), [
            'total_amount' => array_reduce($request->get('sectors', []), function ($carry, $sector){
                return $carry + $sector['amount'];
            }, 0)
        ]));

        foreach ($request->get('sectors', []) as $sector) {
            $voucher->sectors()->create($sector);
        }
        return response([
            'message' => 'Success!',
            'voucher' => $voucher
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param DebitVoucher $debitVoucher
     * @return Response
     */
    public function show(DebitVoucher $debitVoucher)
    {
        $debitVoucher->load('sectors.sector');

        return view('account.general.debit.voucher.show', compact('debitVoucher'));
    }


    public function payment(Party $party, Request $request)
    {
        if($party && $request->ajax()){

            return new DebitVoucherPartyResource($party->load(['debitVouchers' => function($query){
                $query->unpaid();
            }]));
        }

        $parties = Party::query();

        $parties->whereHas('debitVouchers', function($query){
            $query->unpaid();
        });

        return view('account.general.debit.voucher.payment', [
            'parties' => $parties->get(),
            'accounts' => Account::all(),
            'payment_methods' => PaymentMethod::all()
        ]);
    }

    public function paid(DebitVoucher $voucher, Request $request)
    {
        $attributes = $request->validate([
            'amount' => 'required|numeric|min:1',
            'account_id' => 'required',
            'payment_method_id' => 'required',
        ]);

        /** @var DebitVoucherPayment $payment */
        $payment = $voucher->payments()->create($request->all());

        foreach ($voucher->sectors as $sector){

            $paidAmount = $voucher->records()
                ->where('debit_voucher_records.account_sector_id', $sector->account_sector_id)->sum('debit_voucher_records.amount');

            if($paidAmount == $sector->amount){
                continue;
            }
            $needToPaid = ($sector->amount - $paidAmount);

            if($needToPaid < $request->amount){

                $attributes['amount'] = $needToPaid;

                $request->amount -= $needToPaid;

                $payment->records()->create([
                    'amount' => $needToPaid,
                    'account_sector_id' => $sector->account_sector_id
                ]);
            }else{
                $payment->records()->create([
                    'amount' => $request->amount,
                    'account_sector_id' => $sector->account_sector_id
                ]);

                break;
            }
        }

        return response([
            'message' => 'Payment complete.',
            'payment' => $payment,
        ]);
    }

    public function paymentVoucher (DebitVoucherPayment $payment)
    {
        $payment->load(['voucher.party', 'records.sector', 'records.voucherSector' => function($query) use($payment){
            $query->where('debit_voucher_id', $payment->voucher->id);
        }]);
        return view('account.general.debit.voucher.payment-voucher', compact('payment'));
    }

    public function paymentList(DebitVoucher $voucher)
    {
        return view('account.general.debit.voucher.payment-history', compact('voucher'), [
            'payments' => $voucher->payments()->with('account', 'paymentMethod', 'user')->latest()->paginate()
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param DebitVoucher $debitVoucher
     * @throws Exception
     */
    public function destroy(DebitVoucher $debitVoucher)
    {
        $debitVoucher->delete();

        return back()->with('success-message', 'Voucher Deleted Successfully!');
    }

    public function destroyPayment(DebitVoucherPayment $payment)
    {

        $payment->delete();

        $payment->voucher->markAsUnpaid();

        return \response([
            'message' => 'Done!'
        ]);
    }
}
