<?php

namespace App\Http\Controllers\Accounts;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\{Request, Response};
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Resources\CreditVoucherPartyResource;
use App\Models\{Account,
    Accounts\CreditVoucher,
    Accounts\CreditVoucherPayment,
    Accounts\DebitVoucher,
    Accounts\Party,
    PaymentMethod};

class CreditVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $voucher = CreditVoucher::with('party');

        if($request->filled('id')){
            $voucher->whereId($request->get('id'));
        }

        if($request->filled('name')){
            $voucher->whereHas('party', function (Builder $query) use($request){
                $query->where('name', 'like', "%{$request->get('name')}%");
            });
        }


        return view('account.general.credit.voucher.index', [
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
        return view('account.general.credit.voucher.create');
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

        /** @var CreditVoucher $voucher */
        $voucher = CreditVoucher::create(array_merge($request->all(), [
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
     * @param CreditVoucher $creditVoucher
     * @return Response
     */
    public function show(CreditVoucher $creditVoucher)
    {
        $creditVoucher->load('sectors');

        return view('account.general.credit.voucher.show', compact('creditVoucher'));
    }

    public function payment(Party $party, Request $request)
    {
        if($party && $request->ajax()){

            return new CreditVoucherPartyResource($party->load(['creditVouchers' => function($query){
                $query->unpaid();
            }]));
        }

        $parties = Party::query();

        $parties->whereHas('creditVouchers', function($query){
            $query->unpaid();
        });

        return view('account.general.credit.voucher.payment', [
            'parties' => $parties->get(),
            'accounts' => Account::all(),
            'payment_methods' => PaymentMethod::all()
        ]);
    }

    /**
     * @param CreditVoucher $voucher
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function paid(CreditVoucher $voucher, Request $request)
    {
        $attributes = $request->validate([
            'amount' => 'required|numeric|min:1',
            'account_id' => 'required',
            'payment_method_id' => 'required',
        ]);

        /** @var CreditVoucherPayment $payment */
        $payment = $voucher->payments()->create($request->all());

        foreach ($voucher->sectors as $sector){

            $paidAmount = $voucher->records()
                ->where('credit_voucher_records.account_sector_id', $sector->account_sector_id)
                ->sum('credit_voucher_records.amount');

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

    public function paymentVoucher (CreditVoucherPayment $payment)
    {
        $payment->load([
            'records.voucherSector' => function($query) use($payment){
                $query->where('credit_voucher_id', $payment->voucher->id);
            },
            'records.sector'
        ]);

        return view('account.general.credit.voucher.payment-voucher', compact('payment'));
    }

    public function paymentList(CreditVoucher $voucher)
    {
        return view('account.general.credit.voucher.payment-history', compact('voucher'), [
            'payments' => $voucher->payments()->with('user', 'account', 'paymentMethod')->latest()->paginate()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CreditVoucher $creditVoucher
     * @return Response
     * @throws Exception
     */
    public function destroy(CreditVoucher $creditVoucher)
    {
        $creditVoucher->delete();

        return response([
            'message' => 'Done!'
        ]);
    }

    /**
     * @param CreditVoucherPayment $payment
     * @return ResponseFactory|Response
     * @throws Exception
     */
    public function destroyPayment(CreditVoucherPayment $payment)
    {
        $payment->delete();

        $payment->voucher->markAsUnpaid();

        return response([
            'message' => 'Done!'
        ]);
    }
}
