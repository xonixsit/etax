<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Employee\AuthController as EmployeeAuthController;
use App\Http\Controllers\Employee\FeedbackController;
use App\Http\Controllers\HomeController;
use HomeController as GlobalHomeController;

//add default routes
Route::get('/', [HomeController::class, 'index'])->name('home'); // Admin Guest Routes
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Admin Authenticated Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Employee Management
    Route::resource('employees', EmployeeController::class);
    Route::get('employees/create', [EmployeeController::class, 'create'])->name('employees.create');

    // Profile Management
    Route::resource('profile', ProfileController::class);
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Reports
    Route::get('reports', [\App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports.index');
    Route::post('reports/export', [\App\Http\Controllers\Admin\ReportsController::class, 'export'])->name('reports.export');
    Route::get('reports/statistics', [\App\Http\Controllers\Admin\ReportsController::class, 'statistics'])->name('reports.statistics');
    Route::get('reports/analytics', [\App\Http\Controllers\Admin\ReportsController::class, 'statistics'])->name('reports.analytics');
    Route::get('reports/{response}', [\App\Http\Controllers\Admin\ReportsController::class, 'show'])->name('reports.show');
    Route::post('reports/review-answer/{answer}', [\App\Http\Controllers\Admin\ReportsController::class, 'reviewAnswer'])->name('reports.review-answer');
    //admin.reports.complete
    Route::post('reports/complete/{response}', [\App\Http\Controllers\Admin\ReportsController::class,'complete'])->name('reports.complete');
    // Assessments
    Route::resource('assessments', AssessmentController::class);
    Route::get('assessments/{assessment}/questions/create', [QuestionController::class, 'create'])->name('assessments.questions.create');
    Route::get('assessments/{assessment}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('assessments.questions.edit');
    Route::match(['put', 'get'], 'assessments/{assessment}/questions/{question}', [QuestionController::class, 'update'])->name('assessments.questions.update');
    Route::delete('assessments/{assessment}/questions/{question}', [QuestionController::class, 'destroy'])->name('assessments.questions.destroy');
    Route::post('assessments/{assessment}/questions', [QuestionController::class, 'store'])->name('assessments.questions.store');

    //admin.feedback
    Route::resource('feedback', \App\Http\Controllers\Admin\FeedbackController::class);
    Route::get('/feedback', [\App\Http\Controllers\Admin\FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/{feedback}', [\App\Http\Controllers\Admin\FeedbackController::class, 'show'])->name('feedback.show');

    // routes/web.php
    // Route::post('/export-reports', [ReportsController::class, 'export'])->name('admin.export-reports');
});

// Employee Guest Routes
Route::middleware('guest:employee')->group(function () {
    Route::get('/employee/login', [EmployeeAuthController::class, 'showLoginForm'])->name('employee.login');
    Route::post('/employee/login', [EmployeeAuthController::class, 'login'])->name('employee.login.submit');
});

// Employee Authenticated Routes
Route::middleware('auth:employee')->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [EmployeeAuthController::class, 'logout'])->name('logout');
    //employee profile
    Route::get('/profile', [\App\Http\Controllers\Employee\AuthController::class, 'profile'])->name('profile');
    //profile update
    Route::put('/profile/{employee}', [\App\Http\Controllers\Employee\AuthController::class, 'update'])->name('profile.update');
    
    Route::get('/assessments', [\App\Http\Controllers\Employee\AssessmentController::class, 'index'])->name('assessments.index');
    Route::get('/assessments/{assessment}', [\App\Http\Controllers\Employee\AssessmentController::class, 'show'])->name('assessments.show');
    Route::get('/assessments/{assessment}/take', [\App\Http\Controllers\Employee\AssessmentController::class, 'take'])->name('assessments.take');
    Route::get('/assessments/{assessment}/question/{response}', [\App\Http\Controllers\Employee\AssessmentController::class, 'question'])->name('assessments.question');
    Route::post('/assessments/{assessment}/question/{response}', [\App\Http\Controllers\Employee\AssessmentController::class, 'submitAnswer'])->name('assessments.submit-answer');
    Route::get('/assessment-confirmation', [\App\Http\Controllers\Employee\AssessmentController::class, 'showConfirmation'])->name('assessment.confirmation');
    Route::get('/assessments/{assessment}/results', [\App\Http\Controllers\Employee\AssessmentController::class, 'results'])->name('assessments.results');
    Route::get('/results', [\App\Http\Controllers\Employee\AssessmentController::class, 'allResults'])->name('results');

    Route::resource('feedback', FeedbackController::class);

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');

    // Route for saving feedback (POST)
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
 
});