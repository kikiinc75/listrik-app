<?php

namespace App\Http\Controllers;

use App\Http\Request\ElectricityAccount\CreateRequest;
use App\Http\Request\ElectricityAccount\EditRequest;
use App\Models\Cost;
use App\Models\ElectricityAccount;
use App\Models\ElectricityAccountUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware(['role:administrator'])->only(['store', 'edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            if (Auth::user()->roles[0]->slug === 'administrator') {
                $accounts = ElectricityAccount::join('costs', 'cost_id', '=', 'costs.id')
                    ->select('electricity_accounts.id', 'name', 'kwh_number', 'address', 'power', 'cost_per_kwh');
            } else {
                $accounts = ElectricityAccount::join('costs', 'cost_id', '=', 'costs.id')
                    ->join('electricity_account_users', 'electricity_account_id', '=', 'electricity_accounts.id')
                    ->where('electricity_account_users.user_id', '=', Auth::user()->id)
                    ->select('electricity_accounts.id', 'name', 'kwh_number', 'address', 'power', 'cost_per_kwh');
            }

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
        if (Auth::user()->roles[0]->slug === 'administrator') {
            $costs = Cost::get();

            return view('electricity_account.create', ['costs' => $costs]);
        }
        return view('electricity_account.search');
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
     * Store a newly created resource in storage.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'kwh_number' => 'required|numeric',
        ]);

        $account = ElectricityAccount::where('kwh_number', $request->get('kwh_number'))->first();
        if (!$account) {
            return redirect()->back()->with('error', 'kWh number not registered');
        }

        $account = ElectricityAccountUser::create([
            'electricity_account_id' => $account->id,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('electricity-accounts.index')->with('success', 'Account added successfully');
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
    public function destroy(ElectricityAccount $electricityAccount)
    {
        if (Auth::user()->roles[0]->slug === 'administrator') {
            $electricityAccount->delete();
        } else {
            ElectricityAccountUser::where('electricity_account_id', $electricityAccount->id)->delete();
        }

        return redirect()->route('electricity-accounts.index')->with('success', 'Account deleted successfully');
    }
}
