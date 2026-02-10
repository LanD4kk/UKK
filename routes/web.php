<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/student/dashboard', function () {
    return view('student.dashboard');
});

Route::get('/student/create-report', function () {
    return view('student.create-report');
});

Route::get('/student/report/{id}', function ($id) {
    return view('student.report-detail');
});

Route::get('/admin/dashboard', function () {
    return view('admin.admin-dashboard');
});

Route::get('/admin/students', function () {
    return view('admin.student-management');
});

Route::get('/admin/categories', function () {
    return view('admin.category-management');
});

Route::get('/admin/aspirations', function () {
    return view('admin.aspiration-management');
});
