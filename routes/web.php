<?php

use App\Http\Controllers\CostController;
use App\Http\Controllers\ElectricityAccountController;
use App\Http\Controllers\RoleController;
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
Route::resource('/electricity-accounts', ElectricityAccountController::class)->middleware('role:administrator');
