<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
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
                $transactions = Transaction::join('billings', 'billing_id', '=', 'billings.id')
                    ->join('electricity_usages', 'electricity_usage_id', '=', 'electricity_usages.id')
                    ->join('electricity_accounts', 'electricity_account_id', '=', 'electricity_accounts.id')
                    ->select('transactions.id', 'electricity_accounts.name', 'electricity_accounts.kwh_number', 'billings.month', 'billings.year', 'admin_fee', 'total_fee', 'paid_at');
            } else {
                $transactions = Transaction::join('billings', 'billing_id', '=', 'billings.id')
                    ->join('electricity_usages', 'electricity_usage_id', '=', 'electricity_usages.id')
                    ->join('electricity_accounts', 'electricity_usages.electricity_account_id', '=', 'electricity_accounts.id')
                    ->join('electricity_account_users', 'electricity_account_users.electricity_account_id', '=', 'electricity_accounts.id')
                    ->where('electricity_account_users.user_id', '=', Auth::user()->id)
                    ->select('transactions.id', 'electricity_accounts.name', 'electricity_accounts.kwh_number', 'billings.month', 'billings.year', 'admin_fee', 'total_fee', 'paid_at');
            }
            return DataTables::eloquent($transactions)
                ->make();
        }

        return view('transaction.index');
    }
}
