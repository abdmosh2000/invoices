<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\Invoices_ReportController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('sections', [SectionsController::class, 'index'])->name('sections.index');
Route::post('sections/store', [SectionsController::class, 'store'])->name('sections.store');
Route::post('sections/update', [SectionsController::class, 'update'])->name('sections.update');
Route::delete('sections/delete', [SectionsController::class, 'destroy'])->name('sections.delete');


Route::get('products', [ProductsController::class, 'index'])->name('products.index');
Route::post('products/store', [ProductsController::class, 'store'])->name('products.store');
Route::post('products/update', [ProductsController::class, 'update'])->name('products.update');
Route::delete('products/delete', [ProductsController::class, 'destroy'])->name('products.delete');
Route::get('invoices', [InvoicesController::class, 'index'])->name('invoices');
Route::get('invoices/create', [InvoicesController::class, 'create'])->name('invoices.create');
Route::get('section/{id}', [InvoicesController::class, 'getproducts'])->name('get.product');
Route::post('invoices/store', [InvoicesController::class, 'store'])->name('invoices.store');
Route::get('InvoicesDetails/{invoices}', [InvoicesController::class, 'edit_details'])->name('InvoicesDetails.edit');
Route::delete('delete/invoices', [InvoicesController::class, 'forceDelete'])->name('invoices.delete');


Route::delete('delete_file', [InvoiceAttachmentsController::class, 'destroy'])->name('delete_file');
Route::post('add/attachment', [InvoiceAttachmentsController::class, 'store'])->name('add.attachment');
Route::get('add', [\App\Http\Controllers\ButtonsController::class, 'index']);
Route::get('invoices/edit/{id}', [InvoicesController::class, 'edit'])->name('invoices.edit');
Route::post('invoices/update', [InvoicesController::class, 'update'])->name('invoices.update');
Route::get('Status_show/{id}', [InvoicesController::class,'show'])->name('status.show');
Route::post('Status_update/{id}', [InvoicesController::class,'Status_Update'])->name('status.update');
Route::get('Invoice_Paid', [InvoicesController::class,'Invoice_Paid'])->name('Invoice.Paid');
Route::get('Invoice_UnPaid', [InvoicesController::class,'Invoice_UnPaid'])->name('invoice.unPaid');
Route::get('Invoice_Partial', [InvoicesController::class,'Invoice_Partial'])->name('invoice.partial');
Route::get('Archive', [InvoicesArchiveController::class,'index']);
Route::delete('invoices/delete', [InvoicesController::class,'destroy'])->name('invoices.destroy');
Route::post('invoices/restore', [InvoicesArchiveController::class,'update'])->name('invoices.restore');
Route::delete('invoices/deletee', [InvoicesArchiveController::class,'destroy'])->name('invoices.archive.destroy');
Route::get('invoices/print/{id}', [InvoicesController::class,'print'])->name('invoices.print');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('invoices_report', [Invoices_ReportController::class,'index'])->name('report.index');
Route::post('search_invoices', [Invoices_ReportController::class,'Search_invoices'])->name('report.search');
Route::get('customers_report', [ Customers_ReportController::class,'index'])->name("customers.report");
Route::get('read_notifications', [InvoicesController::class, 'markAsRead'])->name('mark.Read');
Route::post('NotifMarkAsRead/{id}', [InvoicesController::class,'show_notification'])->name('show.notification');
Route::post('Search_customers', [Customers_ReportController::class,'Search_customers'])->name('Search.customers');
Route::get('/{page}', [AdminController::class,'index']);







