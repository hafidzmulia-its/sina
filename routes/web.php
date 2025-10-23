<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\BukuUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Use DashboardController instead of closure
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Progress tracking route
    Route::get('/progress', [App\Http\Controllers\ProgressController::class, 'index'])->name('progress');
    
    // User book browsing routes
    Route::get('/buku', [BukuUserController::class, 'index'])->name('buku.index');
    Route::get('/buku/{buku}', [BukuUserController::class, 'show'])->name('buku.show');
    Route::match(['GET', 'POST'], '/buku/{buku}/read', [BukuUserController::class, 'startReading'])->name('buku.read');
    Route::get('/buku/type/{jenis}', [BukuUserController::class, 'byType'])->name('buku.type');
    
    // CSRF Token refresh routes
    Route::get('/csrf-token', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    });
    
    Route::get('/session-check', function () {
        return response()->json([
            'authenticated' => auth()->check(),
            'user_id' => auth()->id(),
            'session_id' => session()->getId()
        ]);
    });
    
    // Debug route to check user permissions
    Route::get('/debug/user', function () {
        if (!auth()->check()) {
            return response()->json(['error' => 'Not authenticated']);
        }
        
        $user = auth()->user();
        return response()->json([
            'user_id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'is_admin' => $user->isAdmin(),
            'is_super_admin' => $user->isSuperAdmin(),
            'session_id' => session()->getId()
        ]);
    });
});

// Book Management Routes (Admin/SuperAdmin only)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('managementbuku', BukuController::class);
});

// Account Management Routes (Admin/SuperAdmin only)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('account', AccountController::class);
});

require __DIR__.'/auth.php';