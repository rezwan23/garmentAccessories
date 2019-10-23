<?php

namespace App\Http\Controllers\Accounts;

use App\Models\Accounts\Party;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $party = Party::query();

        if($request->ajax() && $request->filled('name')){
            return $party->where('name', 'like', "%{$request->name}%")->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        Party::create($attributes);

        return response([
            'message' => 'Done!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Party $party
     * @return Response
     */
    public function show(Party $party)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Party $party
     * @return Response
     */
    public function edit(Party $party)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Party $party
     * @return Response
     */
    public function update(Request $request, Party $party)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Party $party
     * @return Response
     */
    public function destroy(Party $party)
    {
        //
    }
}
