<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\WeightTargetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// 会員登録ルート（仕様書: /register/step1）
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return redirect('/register/step1');
    });
    Route::get('/register/step1', function () {
        return view('auth.register');
    })->name('register.step1');
});

Route::middleware(['auth', 'weight.target'])->group(function () {
    Route::get('/register/step2', [AuthController::class, 'showRegisterStep2'])->name('register.step2');
    Route::post('/register/step2', [AuthController::class, 'storeInitialWeight'])->name('register.step2.store');

    Route::get('/weight_logs', [WeightLogController::class, 'index'])->name('weight_logs.index');
    Route::get('/weight_logs/create', [WeightLogController::class, 'create'])->name('weight_logs.create');
    Route::post('/weight_logs', [WeightLogController::class, 'store'])->name('weight_logs.store');
    Route::get('/weight_logs/search', [WeightLogController::class, 'index'])->name('weight_logs.search');
    Route::get('/weight_logs/goal_setting', [WeightTargetController::class, 'edit'])->name('weight_logs.goal_setting');
    Route::put('/weight_logs/goal_setting', [WeightTargetController::class, 'update'])->name('weight_logs.goal_setting.update');
    Route::get('/weight_logs/{weightLog}', [WeightLogController::class, 'show'])->name('weight_logs.show');
    Route::put('/weight_logs/{weightLog}/update', [WeightLogController::class, 'update'])->name('weight_logs.update');
    Route::delete('/weight_logs/{weightLog}/delete', [WeightLogController::class, 'destroy'])->name('weight_logs.delete');
});
