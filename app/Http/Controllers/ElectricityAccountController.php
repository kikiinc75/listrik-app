<?php

namespace App\Http\Controllers;

use App\Http\Request\ElectricityAccount\CreateRequest;
use App\Http\Request\ElectricityAccount\EditRequest;
use App\Models\Cost;
use App\Models\ElectricityAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ElectricityAccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $accounts = ElectricityAccount::join('costs', 'cost_id', '=', 'costs.id')
                ->select('electricity_accounts.id', 'name', 'kwh_number', 'address', 'power', 'cost_per_kwh');
            return DataTables::eloquent($accounts)
                ->make();
        }

        return view('electricity_account.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $costs = Cost::get();

        return view('electricity_account.create', ['costs' => $costs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $account = ElectricityAccount::create([
            'kwh_number' => $request->get('kwh_number'),
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'cost_id' => $request->get('cost'),
        ]);

        return redirect()->route('electricity-accounts.index')->with('success', 'Account created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ElectricityAccount $electricityAccount)
    {
        $costs = Cost::get();

        return view('electricity_account.edit', [
            'account' => $electricityAccount,
            'costs' => $costs
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, ElectricityAccount $electricityAccount)
    {
        $electricityAccount->update([
            'kwh_number' => $request->get('kwh_number'),
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'cost_id' => $request->get('cost'),
        ]);

        return redirect()->route('electricity-accounts.index')->with('success', 'Account updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
