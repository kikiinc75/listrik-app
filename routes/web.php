<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\ElectricityAccountController;
use App\Http\Controllers\ElectricityUsageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/users', UserController::class)->middleware('role:administrator');
Route::resource('/roles', RoleController::class)->middleware('role:administrator');
Route::resource('/costs', CostController::class)->middleware('role:administrator');
Route::resource('/electricity-accounts', ElectricityAccountController::class);
Route::post('/electricity-accounts/search', [ElectricityAccountController::class, 'search'])->name('electricity-accounts.search')->middleware('role:pelanggan');
Route::resource('/electricity-usages', ElectricityUsageController::class);
Route::get('/billings', [BillingController::class, 'index'])->name('billings.index');
Route::get('/billings/{id}', [BillingController::class, 'show'])->name('billings.show');
Route::put('/billings/{id}/status', [BillingController::class, 'updateStatus'])->name('billings.updateStatus')->middleware('role:administrator');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
