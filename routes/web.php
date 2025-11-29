<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\FinanceExpenseController;

// ----------------------------------------------
// Public Route
// ----------------------------------------------
Route::get('/', function () {
    return redirect()->route('login');
});

// ----------------------------------------------
// Guest Routes (Unauthenticated Users)
// ----------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ----------------------------------------------
// Authenticated Routes
// ----------------------------------------------
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ------------------------------------------
    // Expense Routes (All Logged-in Users)
    // ------------------------------------------
    Route::resource('expenses', ExpenseController::class);

    // ------------------------------------------
    // Approvals (Finance Staff + Admin)
    // ------------------------------------------
    Route::middleware(['role:finance_staff,admin'])->group(function () {
        Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
        Route::post('/approvals/{expense}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{expense}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
    });

    // ------------------------------------------
    // Categories (Admin Only)
    // ------------------------------------------
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('categories', CategoryController::class);
    });

    // ------------------------------------------
    // Reports (Finance Staff + Admin)
    // ------------------------------------------
    Route::middleware(['role:finance_staff,admin'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/preview', [ReportController::class, 'preview'])->name('reports.preview');
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    });

    // ------------------------------------------
    // Finance: Edit/Delete Pending Expenses
    // ------------------------------------------
    Route::middleware(['role:finance_staff,admin'])->group(function () {
        Route::get('/finance/expenses/{expense}/edit', [FinanceExpenseController::class, 'edit'])->name('finance.expenses.edit');
        Route::put('/finance/expenses/{expense}', [FinanceExpenseController::class, 'update'])->name('finance.expenses.update');
        Route::delete('/finance/expenses/{expense}', [FinanceExpenseController::class, 'destroy'])->name('finance.expenses.destroy');
    });

    // ------------------------------------------
    // Admin: User Management
    // ------------------------------------------
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    });
});
