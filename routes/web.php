<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\WarehouseController;
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

Route::get('/', [DashboardController::class, 'showDashboard'])->name('dashboard')->middleware('auth');

Route::get('/revenue', [RevenueController::class, 'showRevenue'])->name('revenue')->middleware('auth');
Route::post('/revenue/customer', [RevenueController::class, 'refreshRevenueCustomer'])->name('refreshRevenueCustomer')->middleware('auth');
Route::post('/revenue/gas', [RevenueController::class, 'refreshRevenueGas'])->name('refreshRevenueGas')->middleware('auth');

Route::get('/payment', [PaymentController::class, 'showPayment'])->name('payment')->middleware('auth');
Route::get('/payment/add', [PaymentController::class, 'showAddPayment'])->name('addPayment')->middleware('auth');
Route::post('/payment/save', [PaymentController::class, 'savePayment'])->name('savePayment')->middleware('auth');

Route::get('/import', [ImportController::class, 'showImport'])->name('import')->middleware('auth');
Route::post('/import/supplier', [ImportController::class, 'arrImportBySupplier'])->name('arrImportBySupplier')->middleware('auth');
Route::get('/import/add', [ImportController::class, 'showAddImport'])->name('addImport')->middleware('auth');
Route::post('/import/save', [ImportController::class, 'saveImport'])->name('saveImport')->middleware('auth');

Route::get('/export', [ExportController::class, 'showExport'])->name('export')->middleware('auth');
Route::post('/export/customer', [ExportController::class, 'arrExportByCustomer'])->name('arrExportByCustomer')->middleware('auth');
Route::get('/export/add', [ExportController::class, 'showAddExport'])->name('addExport')->middleware('auth');
Route::post('/export/save', [ExportController::class, 'saveExport'])->name('saveExport')->middleware('auth');

Route::get('/warehouse', [WarehouseController::class, 'showWarehouse'])->name('warehouse')->middleware('auth');

Route::get('/sign-in', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/sign-in', [AuthController::class, 'postLogin'])->name('postLogin')->middleware('guest');

Route::get('/sign-up', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

