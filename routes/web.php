<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\PengadaanController;
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

Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/optimize-clear', function() {
    $exitCode = Artisan::call('optimize:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
}); 
Route::group(['prefix' => 'employe','middleware'    => 'auth'],function(){
    Route::get('/',[EmployeController::class, 'index']);
    Route::get('/view',[EmployeController::class, 'view_data']);
    Route::get('/getdata',[EmployeController::class, 'get_data']);
    Route::get('/getdatapm',[EmployeController::class, 'get_data_pm']);
    Route::get('/getrole',[EmployeController::class, 'get_role']);
    Route::get('/delete',[EmployeController::class, 'delete']);
    Route::get('/switch_to',[EmployeController::class, 'switch_to']);
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
    Route::get('/masuk',[MaterialController::class, 'index_masuk']);
    Route::get('/keluar',[MaterialController::class, 'index_keluar']);
    Route::get('/view',[MaterialController::class, 'view_data']);
    Route::get('/getdata',[MaterialController::class, 'get_data']);
    Route::get('/get_material',[MaterialController::class, 'get_material']);
    Route::get('/get_data_stok',[MaterialController::class, 'get_data_stok']);
    Route::get('/getdataevent',[MaterialController::class, 'get_data_event']);
    Route::get('/create_stok',[MaterialController::class, 'create_stok']);
    Route::get('/delete',[MaterialController::class, 'delete']);
    Route::get('/delete_stok',[MaterialController::class, 'delete_stok']);
    Route::get('/modal',[MaterialController::class, 'modal']);
    Route::post('/',[MaterialController::class, 'store']);
    Route::post('/store_stok',[MaterialController::class, 'store_stok']);
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
    Route::get('/total_qty',[ProjectController::class, 'total_qty']);
    Route::get('/delete',[ProjectController::class, 'delete']);
    Route::get('/tampil_risiko',[ProjectController::class, 'tampil_risiko']);
    Route::get('/tampil_risiko_view',[ProjectController::class, 'tampil_risiko_view']);
    Route::get('/delete_risiko',[ProjectController::class, 'delete_risiko']);
    Route::get('/delete_material',[ProjectController::class, 'delete_material']);
    Route::get('/delete_operasional',[ProjectController::class, 'delete_operasional']);
    
    Route::get('/modal',[ProjectController::class, 'modal']);
    Route::get('/reset_material',[ProjectController::class, 'reset_material']);
    Route::get('/reset_operasional',[ProjectController::class, 'reset_operasional']);
    Route::get('/reset_jasa',[ProjectController::class, 'reset_jasa']);
    Route::post('/',[ProjectController::class, 'store']);
    Route::post('/store_import_material',[ProjectController::class, 'store_import_material']);
    Route::get('/kirim_kadis_komersil',[ProjectController::class, 'kirim_kadis_komersil']);
    Route::post('/kembali_komersil',[ProjectController::class, 'kembali_komersil']);
    Route::post('/store_procurement',[ProjectController::class, 'store_procurement']);
    Route::post('/approve_kadis_komersil',[ProjectController::class, 'approve_kadis_komersil']);
    Route::post('/verifikasi_material',[ProjectController::class, 'verifikasi_material']);
    Route::post('/approve_kadis_operasional',[ProjectController::class, 'approve_kadis_operasional']);
    Route::post('/approve_mgr_operasional',[ProjectController::class, 'approve_mgr_operasional']);
    Route::post('/approve_direktur_operasional',[ProjectController::class, 'approve_direktur_operasional']);
    Route::get('/kirim_procurement',[ProjectController::class, 'kirim_procurement']);
    Route::get('/tampil_material',[ProjectController::class, 'tampil_material']);
    Route::get('/tampil_jasa',[ProjectController::class, 'tampil_jasa']);
    Route::get('/tampil_material_in',[ProjectController::class, 'tampil_material_in']);
    Route::get('/tampil_material_proc',[ProjectController::class, 'tampil_material_proc']);
    Route::get('/form_material',[ProjectController::class, 'form_material']);
    Route::get('/cetak',[ProjectController::class, 'cetak']);
    Route::get('/tampil_operasional',[ProjectController::class, 'tampil_operasional']);
    Route::post('/store_material',[ProjectController::class, 'store_material']);
    Route::post('/store_operasional',[ProjectController::class, 'store_operasional']);
    Route::get('/delete_jasa',[ProjectController::class, 'delete_jasa']);
    Route::post('/store_jasa',[ProjectController::class, 'store_jasa']);
    Route::post('/store_risiko',[ProjectController::class, 'store_risiko']);
    Route::post('/store_bidding',[ProjectController::class, 'store_bidding']);
    Route::post('/publish',[ProjectController::class, 'publish']);
    Route::post('/store_negosiasi',[ProjectController::class, 'store_negosiasi']);
});
Route::group(['prefix' => 'projectcontrol','middleware'    => 'auth'],function(){
    Route::get('/',[KontrakController::class, 'index_control']);
    Route::get('/task',[KontrakController::class, 'task']);
    Route::get('/form_material',[KontrakController::class, 'form_material']);
    Route::get('/modal_task',[KontrakController::class, 'modal_task']);
    Route::get('/modal_progres',[KontrakController::class, 'modal_progres']);
    Route::get('/getdata',[KontrakController::class, 'get_data_control']);
    Route::get('/getdatatask',[KontrakController::class, 'get_data_task']);
    Route::post('/store_task',[KontrakController::class, 'store_task']);
    Route::post('/store_progres',[KontrakController::class, 'store_progres']);
});
Route::group(['prefix' => 'pengadaan','middleware'    => 'auth'],function(){
    Route::get('/',[PengadaanController::class, 'index']);
    Route::get('/getdata',[PengadaanController::class, 'get_data']);
    Route::get('/getdatamaterial',[PengadaanController::class, 'get_data_material']);
    Route::get('/getdatapengadaan',[PengadaanController::class, 'get_data_pengadaan']);
    Route::get('/view',[PengadaanController::class, 'view']);
    Route::get('/delete',[PengadaanController::class, 'delete']);
    Route::get('/dashboard_task',[PengadaanController::class, 'dashboard_task']);
    Route::get('/tampil_material',[PengadaanController::class, 'tampil_material']);
    Route::post('/store_material',[PengadaanController::class, 'store_material']);
    Route::post('/store_material_pm',[PengadaanController::class, 'store_material_pm']);
    Route::post('/store_pengadaan',[PengadaanController::class, 'store_pengadaan']);
    Route::post('/store_ready',[PengadaanController::class, 'store_ready']);
    Route::get('/modal_verifikasi',[PengadaanController::class, 'modal_verifikasi']);
});
Route::group(['prefix' => 'kontrak','middleware'    => 'auth'],function(){
    Route::get('/',[KontrakController::class, 'index']);
    Route::get('/form_kontrak',[KontrakController::class, 'form_kontrak']);
    Route::get('/view',[KontrakController::class, 'view_data']);
    Route::get('/cetak',[KontrakController::class, 'cetak']);
    Route::get('/timeline',[KontrakController::class, 'timeline']);
    Route::get('/getdata',[KontrakController::class, 'get_data']);
    Route::get('/modal_material',[KontrakController::class, 'modal_material']);
    
    Route::get('/get_status_data',[KontrakController::class, 'get_status_data']);
    Route::get('/getdatamaterial',[KontrakController::class, 'getdatamaterial']);
    Route::get('/create',[KontrakController::class, 'create']);
    Route::get('/total_item',[KontrakController::class, 'total_item']);
    Route::get('/tampil_personal_periode',[KontrakController::class, 'tampil_personal_periode']);
    Route::get('/tampil_operasional_periode',[KontrakController::class, 'tampil_operasional_periode']);
    Route::get('/tampil_material',[KontrakController::class, 'tampil_material']);
    Route::get('/tampil_jasa',[KontrakController::class, 'tampil_jasa']);
    Route::get('/tampil_material_kontrak',[KontrakController::class, 'tampil_material_kontrak']);
    Route::get('/total_qty',[KontrakController::class, 'total_qty']);
    Route::get('/delete',[KontrakController::class, 'delete']);
    Route::get('/tampil_periode',[KontrakController::class, 'tampil_periode']);
    Route::get('/tampil_personal',[KontrakController::class, 'tampil_personal']);
    Route::get('/tampil_operasional',[KontrakController::class, 'tampil_operasional']);
    Route::get('/tampil_pengeluaran',[KontrakController::class, 'tampil_pengeluaran']);
    Route::get('/tampil_risiko_view',[KontrakController::class, 'tampil_risiko_view']);
    Route::get('/delete_personal',[KontrakController::class, 'delete_personal']);
    Route::get('/delete_operasional',[KontrakController::class, 'delete_operasional']);
    Route::get('/delete_material',[KontrakController::class, 'delete_material']);
    Route::get('/reset_material',[KontrakController::class, 'reset_material']);
    Route::get('/reset_operasional',[KontrakController::class, 'reset_operasional']);
    Route::get('/reset_jasa',[KontrakController::class, 'reset_jasa']);
    Route::get('/modal',[KontrakController::class, 'modal']);
    Route::post('/store_import_material',[KontrakController::class, 'store_import_material']);
    Route::post('/',[KontrakController::class, 'store']);
    Route::get('/kirim_kadis_komersil',[KontrakController::class, 'kirim_kadis_komersil']);
    Route::post('/kembali_komersil',[KontrakController::class, 'kembali_komersil']);
    Route::post('/approve_kadis_komersil',[KontrakController::class, 'approve_kadis_komersil']);
    Route::post('/approve_kadis_operasional',[KontrakController::class, 'approve_kadis_operasional']);
    Route::post('/approve_mgr_operasional',[KontrakController::class, 'approve_mgr_operasional']);
    Route::post('/approve_direktur_operasional',[KontrakController::class, 'approve_direktur_operasional']);
    Route::get('/kirim_procurement',[KontrakController::class, 'kirim_procurement']);
    Route::post('/store_material',[KontrakController::class, 'store_material']);
    Route::post('/store_material_kontrak',[KontrakController::class, 'store_material_kontrak']);
    Route::post('/store_kontrak',[KontrakController::class, 'store_kontrak']);
    Route::post('/store_personal',[KontrakController::class, 'store_personal']);
    Route::post('/store_operasional',[KontrakController::class, 'store_operasional']);
    Route::post('/store_pengadaan',[KontrakController::class, 'store_pengadaan']);
    
    Route::get('/delete_jasa',[KontrakController::class, 'delete_jasa']);
    Route::post('/store_jasa',[KontrakController::class, 'store_jasa']);
    Route::post('/store_periode_personal',[KontrakController::class, 'store_periode_personal']);
    Route::post('/store_periode_operasional',[KontrakController::class, 'store_periode_operasional']);
    Route::post('/store_negosiasi',[KontrakController::class, 'store_negosiasi']);
    Route::post('/publish',[KontrakController::class, 'publish']);
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
