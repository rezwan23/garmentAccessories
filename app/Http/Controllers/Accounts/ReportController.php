<?php

namespace App\Http\Controllers\Accounts;

use App\Models\Account;
use App\Models\Accounts\{CreditVoucher, CreditVoucherRecord, DebitVoucher, DebitVoucherRecord, Party, Transaction};
use App\Models\AccountSector;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function incomeExpense(Request $request)
    {
        $dates = [date('Y-m-d'), date('Y-m-d')];

        if($request->filled('start-date', 'end-date')){
            $dates = $request->only('start-date', 'end-date');
        }

        $income = AccountSector::with(['creditAmount' => function(HasOne $builder) use($dates){
            $builder->whereHas('payment', function (Builder $builder) use($dates){
                $builder->whereBetween('payment_date', $dates);
            })->selectRaw("sum(amount) as amount, account_sector_id")
            ->groupBy('account_sector_id');
        }])->whereHas('creditAmount', function (Builder $builder) use($dates){
            $builder->join('credit_voucher_payments', 'credit_voucher_records.credit_voucher_payment_id', '=', 'credit_voucher_payments.id')
            ->whereBetween('credit_voucher_payments.payment_date', $dates);
        })->income()->get();

        $expense = AccountSector::with(['debitAmount' => function(HasOne $builder) use($dates){
            $builder->whereHas('payment', function (Builder $builder) use($dates){
                $builder->whereBetween('payment_date', $dates);
            })->selectRaw("sum(amount) as amount, account_sector_id")
            ->groupBy('account_sector_id');
        }])->whereHas('debitAmount', function (Builder $builder) use($dates){
            $builder->join('debit_voucher_payments', 'debit_voucher_records.debit_voucher_payment_id', '=', 'debit_voucher_payments.id')
            ->whereBetween('debit_voucher_payments.payment_date', $dates);
        })->expense()->get();

        return view('account.general.report.income-expense', [
            'expenseSectors' => $expense,
            'incomeSectors' => $income
        ]);
    }


    public function partyReport(Request $request)
    {
        $party = null;
        $transactions = null;

        if($request->filled('party_id')){
            $party = Party::findOrFail($request->get('party_id'));

            $transactions = Transaction::query()->where('party_id', $party->id);

            if($request->filled('start-date', 'end-date')){
                $transactions->whereBetween('payment_date', $request->only('start-date', 'end-date'));
            }

            $transactions = $transactions->with('transactionable')->get();
        }

        return view('account.general.report.party', [
            'party' => $party,
            'data' => [0],
            'transactions' => $transactions
        ]);
    }

    public function cashReport(Request $request)
    {
        $transactions = Transaction::query();

        if($request->filled('account_id')){
            $transactions->whereAccountId($request->account_id);
        }

        $previousBalance = clone $transactions;

        $transactions->with('transactionable');

        if($request->filled('start-date', 'end-date')){
            $transactions->whereBetween('payment_date', $request->only('start-date', 'end-date'));
        }else{
            $transactions->where('payment_date', date('Y-m-d'));
        }

        $openingBalance = $previousBalance->join('accounts', 'transactions.account_id', '=', 'accounts.id')
            ->selectRaw('sum(amount) as amount, transaction_type')
            ->where('payment_date', '<', $request->get('start-date', date('Y-m-d')))
            ->groupBy('transaction_type')
            ->get()->keyBy('transaction_type');


        return view('account.general.report.cash', [
            'accounts' => Account::orderBy('name')->get(),
            'transactions' => $transactions->get(),
            'data' => collect([Arr::get($openingBalance->get('credit'), 'amount', 0) - Arr::get($openingBalance->get('debit'), 'amount', 0)])
        ]);
    }

    public function partyBillReport(Request $request)
    {
        $party = null;
        $vouchers = null;

        if($request->filled('party_id', 'type')){
            /** @var Party $party */
            $party = Party::findOrFail($request->get('party_id'));

            $vouchers = $party->{$request->get('type').'Vouchers'}();

            if($request->filled('start-date', 'end-date')){
                $vouchers->with('sectors.sector', 'paidAmount')->whereRaw('date(created_at) between ? and ?', $request->only('start-date', 'end-date'));
            }

            $vouchers = $vouchers->get();
        }
        return view('account.general.report.party-bill', [
            'party' => $party,
            'vouchers' => $vouchers,
        ]);
    }

    public function partyReportV3(Request $request)
    {
        $party = null;
        $vouchers = null;
        $previous = null;

        $models = [
            'debit' => [
                'record' => DebitVoucherRecord::class,
                'record_table' => 'debit_voucher_records',
                'record_id' => 'debit_voucher_payment_id',
                'payment_table' => 'debit_voucher_payments',
                'table' => 'debit_vouchers',
                'voucher_id' => 'debit_voucher_id'
            ],
            'credit' => [
                'record' => CreditVoucherRecord::class,
                'record_table' => 'credit_voucher_records',
                'record_id' => 'credit_voucher_payment_id',
                'payment_table' => 'credit_voucher_payments',
                'table' => 'credit_vouchers',
                'voucher_id' => 'credit_voucher_id'
            ]
        ];


        $dates = [date('Y-m-d'), date('Y-m-d')];

        if($request->filled('start-date', 'end-date')){
            $dates = $request->only('start-date', 'end-date');
        }


        if($request->filled('party_id', 'type')){
            /** @var Party $party */
            $party = Party::findOrFail($request->get('party_id'));

            $vouchers = $party->{$request->get('type').'Vouchers'}()->with([
                'payments.records.sector', 'payments.paymentMethod', 'sectors.sector'
            ])->whereRaw('date(created_at) between ? and ?', $dates);

            /** @var User $user */
            $user = auth()->user();

            $model = $models[$request->get('type')];

            /** @var Builder $previous */
            $recordModel = $model['record'];

            $previous = clone $party->{$request->get('type').'Vouchers'}();

            $previous->whereRaw('date(created_at) < ?', Arr::first($dates));

            $previous->selectRaw('sum(total_amount) as total_amount');

            $column1 = $model['record_table'] . "." .$model['record_id'];

            $column2 = $model['payment_table'] . ".id";

            $previousPaid =  $recordModel::selectRaw('sum('.$model['record_table'].'.amount) as amount')
            ->join($model['payment_table'], $column1, '=', $column2)
            ->join($model['table'], $model['payment_table'] . '.' . $model['voucher_id'], '=', $model['table'] . '.id')
                ->whereRaw('date('.$model['table'] . '.created_at) < ?', Arr::first($dates))
            ->where($model['table'] . '.company_id', $user->company_id)
            ->where($model['table'] . '.party_id', $request->party_id);

            $previous = ($previous->first()->total_amount - $previousPaid->first()->amount);

            $vouchers = $vouchers->get();
        }

        return view('account.general.report.party-report', [
            'party' => $party,
            'vouchers' => $vouchers,
            'previous' => $previous
        ]);
    }
}
