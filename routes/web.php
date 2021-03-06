<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchivesController;
use App\Http\Controllers\BillsAttachmentsController;
use App\Http\Controllers\billsController;
use App\Http\Controllers\BillsDetailsController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserManagement\RoleController;
use App\Http\Controllers\UserManagement\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
// Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles',RoleController::class);
    Route::resource('users',UserController::class);
    });
// ------------------------------------------------------------------------------------------------------
Route::resource('bills' , billsController::class);
Route::resource('sections' , SectionController::class);
Route::resource('products' , ProductController::class);
Route::resource('billAttachments' , BillsAttachmentsController::class);
Route::resource('Archive' , ArchivesController::class);
// ------------------------------------------------------------------------------------------------------
Route::get('/section/{id}' , [billsController::class , 'getproducts']);
Route::get('/edit_bill/{id}' , [billsController::class , 'edit']);
// ------------------------------------------------------------------------------------------------------
Route::get('/billsDetails/{id}' , [BillsDetailsController::class , 'edit'])->name('billDetails');
Route::get('view_file/{bill_number}/{file_name}' , [BillsDetailsController::class , 'open_file']);
Route::get('download/{bill_number}/{file_name}' , [BillsDetailsController::class , 'get_file']);
Route::post('delete_file' , [BillsDetailsController::class , 'destroy'])->name('delete_file');
// ------------------------------------------------------------------------------------------------------
Route::get('/Status_show/{id}' , [billsController::class , 'show'])->name('Status_show');
Route::post('/Status_Update/{id}' , [billsController::class , 'Status_Update'])->name('Status_Update');
Route::get('/paid_bills', [billsController::class , 'paid_bills'])->name('paid_bills');
Route::get('/unpaid_bills', [billsController::class , 'unpaid_bills'])->name('unpaid_bills');
Route::get('/partial_bills', [billsController::class , 'partial_bills'])->name('partial_bills');
Route::get('/print_bills/{id}', [billsController::class , 'print_bill'])->name('print_bills');
Route::get('/MarkAsRead_all',[billsController::class ,'MarkAsRead_all'])->name('MarkAsRead_all');

// ------------------------------------------------------------------------------------------------------
Route::get('export_bills', [billsController::class , 'export'])->name('export_bills');
// ------------------------------------------------------------------------------------------------------
Route::get('/bill_report', [ReportsController::class , 'bills'])->name('bill_report');
Route::post('/Search_bills', [ReportsController::class , 'Search_bills'])->name('Search_bills');
Route::get('/customer_report', [ReportsController::class , 'customers'])->name('customer_report');
Route::post('/search_customers', [ReportsController::class , 'search_customers'])->name('search_customers');

// ------------------------------------------------------------------------------------------------------

//Route::get('/{page}', [AdminController::class ,'index']);



