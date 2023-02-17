<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\Auth\LogoutController;
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


Route::group(['prefix' => 'employe','middleware'    => 'auth'],function(){
    Route::get('/',[EmployeController::class, 'index']);
    Route::get('/view',[EmployeController::class, 'view_data']);
    Route::get('/getdata',[EmployeController::class, 'get_data']);
    Route::get('/getrole',[EmployeController::class, 'get_role']);
    Route::get('/delete',[EmployeController::class, 'delete']);
    Route::get('/create',[EmployeController::class, 'create']);
    Route::get('/modal',[EmployeController::class, 'modal']);
    Route::post('/',[EmployeController::class, 'store']);
});

Route::group(['prefix' => 'cost','middleware'    => 'auth'],function(){
    Route::get('/',[CostController::class, 'index']);
    Route::get('/view',[CostController::class, 'view_data']);
    Route::get('/getdata',[CostController::class, 'get_data']);
    Route::get('/create',[CostController::class, 'create']);
    Route::get('/delete',[CostController::class, 'delete']);
    Route::get('/modal',[CostController::class, 'modal']);
    Route::post('/',[CostController::class, 'store']);
});

Route::group(['prefix' => 'customer','middleware'    => 'auth'],function(){
    Route::get('/',[CustomerController::class, 'index']);
    Route::get('/view',[CustomerController::class, 'view_data']);
    Route::get('/getdata',[CustomerController::class, 'get_data']);
    Route::get('/create',[CustomerController::class, 'create']);
    Route::get('/delete',[CustomerController::class, 'delete']);
    Route::get('/modal',[CustomerController::class, 'modal']);
    Route::post('/',[CustomerController::class, 'store']);
});
Route::group(['prefix' => 'material','middleware'    => 'auth'],function(){
    Route::get('/',[MaterialController::class, 'index']);
    Route::get('/view',[MaterialController::class, 'view_data']);
    Route::get('/getdata',[MaterialController::class, 'get_data']);
    Route::get('/create',[MaterialController::class, 'create']);
    Route::get('/delete',[MaterialController::class, 'delete']);
    Route::get('/modal',[MaterialController::class, 'modal']);
    Route::post('/',[MaterialController::class, 'store']);
});
Route::group(['prefix' => 'project','middleware'    => 'auth'],function(){
    Route::get('/',[ProjectController::class, 'index']);
    Route::get('/view',[ProjectController::class, 'view_data']);
    Route::get('/form_send',[ProjectController::class, 'form_send']);
    Route::get('/timeline',[ProjectController::class, 'timeline']);
    Route::get('/getdata',[ProjectController::class, 'get_data']);
    Route::get('/get_status_data',[ProjectController::class, 'get_status_data']);
    Route::get('/getdatamaterial',[ProjectController::class, 'getdatamaterial']);
    Route::get('/create',[ProjectController::class, 'create']);
    Route::get('/total_item',[ProjectController::class, 'total_item']);
    Route::get('/tampil_material',[ProjectController::class, 'tampil_material']);
    Route::get('/total_qty',[ProjectController::class, 'total_qty']);
    Route::get('/delete',[ProjectController::class, 'delete']);
    Route::get('/delete_material',[ProjectController::class, 'delete_material']);
    Route::get('/modal',[ProjectController::class, 'modal']);
    Route::post('/',[ProjectController::class, 'store']);
    Route::post('/kirim_komersil',[ProjectController::class, 'kirim_komersil']);
    Route::post('/kembali_komersil',[ProjectController::class, 'kembali_komersil']);
    Route::get('/kirim_procurement',[ProjectController::class, 'kirim_procurement']);
    Route::post('/store_material',[ProjectController::class, 'store_material']);
});

Route::group(['middleware' => 'auth'], function() {
    /**
    * Logout Route
    */
    Route::get('/logout-perform', [LogoutController::class, 'perform'])->name('logout.perform');
 });

Route::group(['prefix' => 'user'],function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/create', [UserController::class, 'create']);
    Route::get('/get_data', [UserController::class, 'get_data']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
