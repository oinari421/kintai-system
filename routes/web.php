<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController; 
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockIn');
    Route::post('/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockOut');
});


// routes/web.php

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    // 管理者ダッシュボード
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // 編集フォーム表示
    Route::get('attendance/{attendance}/edit', [AdminController::class, 'edit'])->name('attendance.edit');

    // ⬇ 確認画面用ルート（編集内容を一旦確認）
    Route::post('attendance/{attendance}/confirm', [AdminController::class, 'confirm'])->name('attendance.confirm');

    // ⬇ 更新処理（確認画面から送信）
    Route::put('attendance/{attendance}/update', [AdminController::class, 'update'])->name('attendance.update');

});
Route::prefix('admin')->group(function () {
    // ...
    Route::patch('{id}/toggle', [AdminController::class, 'toggleAdmin'])->name('admin.toggle');
});







require __DIR__.'/auth.php';




