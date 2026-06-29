<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dosen\FormController as DosenFormController;
use App\Http\Controllers\FormController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/login', function () {
    return view('sign_in');
})->name('sign_in');

// Route::get('/signup', function () {
//     return view('sign_up');
// })->name('sign_up');
// Route::post('/check-sign', [AuthController::class,'register'])->name('auth.check-register');

Route::post('/check-sign', [AuthController::class,'login'])->name('auth.check-login');

Route::middleware('guest')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/form', [DosenFormController::class, 'index'])->name('form');
    Route::post('/form/{form}/fill', [DosenFormController::class, 'fillResponse'])->name('forms.fill');
    Route::post('/forms/{id}/check-access-code', [DosenFormController::class, 'checkAccessCode'])->name('forms.checkAccessCode');
});


Route::middleware('auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/form', [FormController::class, 'index'])->name('admin.form');
    Route::post('/admin/form/create', [FormController::class, 'create'])->name('admin.form.create');
    Route::get('/admin/form/show/{id}', [FormController::class, 'show'])->name('admin.form.show');

    Route::put('/admin/form/edit/{id}', [FormController::class, 'update'])->name('admin.form.update');

    Route::delete('/admin/form/delete/{id}', [FormController::class, 'destroy'])->name('admin.form.destroy');
});
