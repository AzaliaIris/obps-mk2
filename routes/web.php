<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\RincianController;
use App\Http\Controllers\PencatatanController;
use App\Http\Controllers\MonitorController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'view_pengajuan_kegiatan'])->name('view_pengajuan_kegiatan_user');
    Route::post('/user/ajukan-kegiatan', [PencatatanController::class, 'ajukan_kegiatan_user'])->name('ajukan_kegiatan_user');
    // Route::get('user/search-master-kegiatan', [PencatatanController::class, 'search_master_kegiatan'])->name('search_master_kegiatan');
    // Route::get('user/search-master-rincian', [PencatatanController::class, 'search_master_rincian'])->name('search_master_rincian');
    // Route::get('user/search-bobot', [PencatatanController::class, 'search_bobot'])->name('search_bobot');
    Route::put('/user/dashboard/{pencatatan_id}', [PencatatanController::class, 'update_pencatatan_user'])->name('update_pencatatan_user');
    Route::delete('/user/dashboard/{pencatatan_id}', [PencatatanController::class, 'delete_pencatatan_user'])->name('delete_pencatatan_user');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class,'adminindex']);
    Route::get('/admin/view_master_kegiatan',[AdminController::class,'view_master_kegiatan'])->name('view_master_kegiatan');
    Route::get('/admin/view_master_rincian', [AdminController::class, 'view_master_rincian'])->name('view_master_rincian');
    Route::get('/admin/view_pengajuan_kegiatan', [AdminController::class, 'view_pengajuan_kegiatan'])->name('view_pengajuan_kegiatan');
    Route::get('/admin/view_monitor_user', [AdminController::class, 'view_monitor_user'])->name('view_monitor_user');
    Route::get('/admin/view_monitor_kegiatan', [AdminController::class, 'view_monitor_kegiatan'])->name('view_monitor_kegiatan');
    Route::post('/admin/add_kegiatan', [KegiatanController::class, 'add_kegiatan'])->name('add_kegiatan');
    Route::post('/admin/upload_excel_kegiatan', [KegiatanController::class, 'upload_excel_kegiatan'])->name('upload_excel_kegiatan');
    Route::delete('/admin/view_master_kegiatan/{kegiatan_id}', [KegiatanController::class, 'delete_kegiatan'])->name('delete_kegiatan');
    Route::put('/admin/view_master_kegiatan/{kegiatan_id}', [KegiatanController::class, 'update_kegiatan'])->name('update_kegiatan');
    Route::post('/admin/add_rincian', [RincianController::class, 'add_rincian'])->name('add_rincian');
    Route::post('/admin/upload_excel', [RincianController::class, 'upload_excel'])->name('upload_excel_rincian');
    Route::delete('/admin/view_master_rincian/{rincian_id}', [RincianController::class, 'delete_rincian'])->name('delete_rincian');
    Route::put('/admin/view_master_rincian/{rincian_id}', [RincianController::class, 'update_rincian'])->name('update_rincian');
    Route::post('/admin/ajukan-kegiatan', [PencatatanController::class, 'ajukan_kegiatan'])->name('ajukan_kegiatan');
    Route::put('/admin/view_pengajuan_kegiatan/{pencatatan_id}', [PencatatanController::class, 'update_pencatatan'])->name('update_pencatatan');
    Route::delete('/admin/view_pengajuan_kegiatan/{pencatatan_id}', [PencatatanController::class, 'delete_pencatatan'])->name('delete_pencatatan');
    Route::put('/admin/view_monitor_user/{id}', [MonitorController::class, 'update_user'])->name('update_user');
    Route::delete('/admin/view_monitor_user/{id}', [MonitorController::class, 'delete_user'])->name('delete_user');
    Route::get('/admin/filter_kontribusi', [MonitorController::class, 'filter_kontribusi'])->name('filter_kontribusi');
    Route::post('/admin/alokasi_tim', [MonitorController::class, 'alokasi_tim'])->name('alokasi_tim');
    Route::put('/admin/view_monitor_kegiatan/{team_user_id}', [MonitorController::class, 'update_tim'])->name('update_tim');
    Route::delete('/admin/view_monitor_kegiatan/{id}', [MonitorController::class, 'delete_tim'])->name('delete_tim');
});