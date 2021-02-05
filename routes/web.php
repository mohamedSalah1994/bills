<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\billsController;
use App\Http\Controllers\BillsDetailsController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsersController;
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
Route::resource('bills' , billsController::class);

Route::resource('sections' , SectionController::class);
Route::resource('products' , ProductController::class);
Route::resource('users' , UsersController::class);
Route::get('/section/{id}' , [billsController::class , 'getproducts']);
Route::get('/billDetails/{id}' , [BillsDetailsController::class , 'edit']);
Route::get('view_file/{bill_number}/{file_name}' , [BillsDetailsController::class , 'open_file']);
Route::get('download/{bill_number}/{file_name}' , [BillsDetailsController::class , 'get_file']);
Route::post('delete_file' , [BillsDetailsController::class , 'destroy'])->name('delete_file');


//Route::get('/{page}', [AdminController::class ,'index']);



