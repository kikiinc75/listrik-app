<?php

namespace App\Http\Controllers;

use App\Http\Request\ElectricityUsage\CreateRequest;
use App\Http\Request\ElectricityUsage\EditRequest;
use App\Models\Billing;
use App\Models\ElectricityAccount;
use App\Models\ElectricityUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ElectricityUsageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator')->except('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            if (Auth::user()->roles[0]->slug === 'administrator') {
                $usages = ElectricityUsage::join('electricity_accounts', 'electricity_account_id', '=', 'electricity_accounts.id')
                    ->select('electricity_usages.id', 'name', 'month', 'year', 'meter_from', 'meter_to');
            } else {
                $usages = ElectricityUsage::join('electricity_accounts', 'electricity_usages.electricity_account_id', '=', 'electricity_accounts.id')
                    ->join('electricity_account_users', 'electricity_account_users.electricity_account_id', '=', 'electricity_accounts.id')
                    ->where('electricity_account_users.user_id', '=', Auth::user()->id)
                    ->select('electricity_usages.id', 'name', 'month', 'year', 'meter_from', 'meter_to');
            }
            return DataTables::eloquent($usages)
                ->make();
        }

        return view('electricity_usage.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = ElectricityAccount::get();

        return view('electricity_usage.create', ['accounts' => $accounts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $usage = ElectricityUsage::create([
                'electricity_account_id' => $request->get('account'),
                'month' => $request->get('month'),
                'year' => $request->get('year'),
                'meter_from' => $request->get('meter_from'),
                'meter_to' => $request->get('meter_to'),
            ]);

            $billing = Billing::create([
                'electricity_usage_id' => $usage->id,
                'month' => $usage->month,
                'year' => $usage->year,
                'total_meter' => $usage->meter_to - $usage->meter_from,
                'status' => 'UNPAID',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        DB::commit();
        return redirect()->route('electricity-usages.index')->with('success', 'Usage and billing created successfully');
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
    public function edit(ElectricityUsage $electricityUsage)
    {
        if ($electricityUsage->billing->status === 'PAID') {
            return redirect()->back()->with('error', 'Cannot edit data because billing already paid');
        }

        return view('electricity_usage.edit', ['usage' => $electricityUsage]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, ElectricityUsage $electricityUsage)
    {
        if ($electricityUsage->billing->status === 'PAID') {
            return redirect()->back()->with('error', 'Cannot update data because billing already paid');
        }

        DB::beginTransaction();
        try {
            $electricityUsage->billing->delete();
            $electricityUsage->update([
                'month' => $request->get('month'),
                'year' => $request->get('year'),
                'meter_from' => $request->get('meter_from'),
                'meter_to' => $request->get('meter_to'),
            ]);

            $billing = Billing::create([
                'electricity_usage_id' => $electricityUsage->id,
                'month' => $electricityUsage->month,
                'year' => $electricityUsage->year,
                'total_meter' => $electricityUsage->meter_to - $electricityUsage->meter_from,
                'status' => 'UNPAID',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }

        DB::commit();
        return redirect()->route('electricity-usages.index')->with('success', 'Usage and billing updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ElectricityUsage $electricityUsage)
    {
        if ($electricityUsage->billing->status === 'PAID') {
            return redirect()->back()->with('error', 'Cannot delete data because billing already paid');
        }

        $electricityUsage->billing->delete();
        $electricityUsage->delete();
        return redirect()->route('electricity_usages.index')->with('success', 'Usage deleted successfully');
    }
}
