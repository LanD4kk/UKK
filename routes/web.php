<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard']);

    // API endpoint untuk dashboard siswa (fetch via JS)
    Route::get('/api/student/dashboard', [StudentController::class, 'apiDashboard'])->name('api.student.dashboard');

    // API endpoint untuk detail laporan (fetch via JS)
    Route::get('/api/student/report/{id}', [StudentController::class, 'apiReportDetail'])->name('api.student.report.detail');

    // API endpoint untuk daftar kategori
    Route::get('/api/student/categories', [StudentController::class, 'apiCategories'])->name('api.student.categories');

    // API endpoint untuk membuat laporan baru
    Route::post('/api/student/report', [StudentController::class, 'storeReport'])->name('api.student.report.store');

    // API endpoint untuk update laporan
    Route::post('/api/student/report/{id}', [StudentController::class, 'updateReport'])->name('api.student.report.update');

    Route::get('/student/create-report', function () {
        return view('student.create-report');
    });

    Route::get('/student/report/{id}', function ($id) {
        return view('student.report-detail');
    });

    Route::get('/student/edit-report/{id}', function ($id) {
        return view('student.edit-report', ['id' => $id]);
    });
});

Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard']);

    Route::get('/admin/accounts', [\App\Http\Controllers\AdminController::class, 'accounts'])->name('admin.accounts.index');
    Route::post('/admin/accounts/user', [\App\Http\Controllers\AdminController::class, 'storeAccount'])->name('admin.accounts.user.store');
    Route::put('/admin/accounts/user/{id}', [\App\Http\Controllers\AdminController::class, 'updateAccount'])->name('admin.accounts.user.update');
    Route::delete('/admin/accounts/user/{id}', [\App\Http\Controllers\AdminController::class, 'destroyAccount'])->name('admin.accounts.user.destroy');

    Route::get('/admin/categories', [\App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories.index');
    Route::post('/admin/categories', [\App\Http\Controllers\AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/admin/categories/{id}', [\App\Http\Controllers\AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [\App\Http\Controllers\AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');

    Route::get('/admin/aspirations', [\App\Http\Controllers\AdminController::class, 'aspirations']);
    Route::get('/admin/aspirations/{id}', [\App\Http\Controllers\AdminController::class, 'showAspiration'])->name('admin.aspirations.show');
    Route::put('/admin/aspirations/{id}', [\App\Http\Controllers\AdminController::class, 'updateAspiration'])->name('admin.aspirations.update');
    
    // API endpoint untuk profile akun admin/staff
    Route::get('/api/admin/profile', function () {
        return response()->json(auth()->user());
    })->name('api.admin.profile');
});

Route::get('/hello', function () {
    return 'Hello World! Environment Ready';
});
