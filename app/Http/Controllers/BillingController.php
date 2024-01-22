<?php

namespace App\Http\Controllers;

use App\Http\Request\Billing\EditRequest;
use App\Models\Billing;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BillingController extends Controller
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
            if (Auth::user()->roles[0]->slug === 'administrator') {
                $billings = Billing::join('electricity_usages', 'electricity_usage_id', '=', 'electricity_usages.id')
                    ->join('electricity_accounts', 'electricity_account_id', '=', 'electricity_accounts.id')
                    ->select('billings.id', 'electricity_accounts.name', 'electricity_accounts.kwh_number', 'billings.month', 'billings.year', 'billings.total_meter', 'billings.status');
            } else {
                $billings = Billing::join('electricity_usages', 'electricity_usage_id', '=', 'electricity_usages.id')
                    ->join('electricity_accounts', 'electricity_usages.electricity_account_id', '=', 'electricity_accounts.id')
                    ->join('electricity_account_users', 'electricity_account_users.electricity_account_id', '=', 'electricity_accounts.id')
                    ->where('electricity_account_users.user_id', '=', Auth::user()->id)
                    ->select('billings.id', 'electricity_accounts.name', 'electricity_accounts.kwh_number', 'billings.month', 'billings.year', 'billings.total_meter', 'billings.status');
            }
            return DataTables::of($billings)
                ->make();
        }

        return view('billing.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $billing = Billing::findOrFail($id);
        $billing->usage_fee = $billing->total_meter * $billing->electricityUsage->electricityAccount->cost->cost_per_kwh;
        $billing->admin_fee = 1500;
        $billing->total_fee = $billing->usage_fee + $billing->admin_fee;

        return view('billing.show', ['billing' => $billing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(EditRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $billing = Billing::findOrFail($id);
            if ($billing->status === 'PAID') {
                return redirect()->route('billings.index')->with('warning', 'Billing already been paid');
            }
            if ($request->get('status') != 'PAID') {
                return redirect()->back()->with('error', 'Status not valid');
            }
            $billing->update(['status' => $request->get('status')]);

            $usage_fee = $billing->total_meter * $billing->electricityUsage->electricityAccount->cost->cost_per_kwh;
            $transaction = Transaction::create([
                'admin_id' => Auth::user()->id,
                'billing_id' => $billing->id,
                'paid_at' => Carbon::now(),
                'admin_fee' => 1500,
                'total_fee' => $usage_fee + 1500,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        DB::commit();
        return redirect()->route('billings.index')->with('success', 'Billing successfully ' . $request->get('status'));
    }
}
