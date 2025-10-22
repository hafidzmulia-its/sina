<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
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