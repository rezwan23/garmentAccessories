<?php

namespace App\Http\Controllers;

use App\Models\AccountSector;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AccountSectorController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:sector-view')->only('index');
        $this->middleware('can:sector-edit')->only('edit');
        $this->middleware('can:sector-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $accountSector = AccountSector::query();

        if($request->ajax() && $request->filled('name')){

            return $accountSector->where('name', 'like', "%{$request->name}%")
                ->where('sector_type', '=', $request->sector_type)
                ->get();
        }

        return view('account.sector.index', [
            'sectors' =>  $accountSector->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name'  => 'required',
        ]);

        AccountSector::create($data + $request->only('sector_type', 'status'));

        return response(['message'=> 'Sector Created Successfully!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AccountSector $accountSector
     * @return Response
     */
    public function edit(AccountSector $accountSector)
    {
        return view('account.sector.edit', [
            'sector'=>$accountSector
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AccountSector $accountSector
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, AccountSector $accountSector)
    {
        $data = $this->validate($request, [
            'name'  => 'required',
        ]);

        $accountSector->update($data + $request->only('sector_type', 'status'));

        return redirect()->route('accountSector.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AccountSector $accountSector
     * @return Response
     * @throws \Exception
     */
    public function destroy(AccountSector $accountSector)
    {
        $accountSector->delete();

        return back();
    }
}
