<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use Illuminate\Http\Request;

// Test Cloudinary configuration
Route::get('/debug-cloudinary', function () {
    $config = config('cloudinary');
    
    return response()->json([
        'config' => $config,
        'cloud_name' => config('cloudinary.cloud_name'),
        'api_key' => config('cloudinary.api_key'),
        'env_values' => [
            'CLOUDINARY_CLOUD_NAME' => env('CLOUDINARY_CLOUD_NAME'),
            'CLOUDINARY_API_KEY' => env('CLOUDINARY_API_KEY'),
            'CLOUDINARY_KEY' => env('CLOUDINARY_KEY'),
        ]
    ]);
})->middleware(['auth', 'web']);

// Add this temporary debug route
Route::post('/debug-create', function (Request $request) {
    logger('Debug create request', [
        'user_id' => auth()->id(),
        'user_role' => auth()->user()->role ?? 'no role',
        'all_data' => $request->all(),
        'has_file' => $request->hasFile('cover'),
        'file_info' => $request->hasFile('cover') ? [
            'name' => $request->file('cover')->getClientOriginalName(),
            'size' => $request->file('cover')->getSize(),
            'mime' => $request->file('cover')->getMimeType(),
        ] : null,
        'validation_rules' => [
            'judul' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'max:100'],
            'sinopsis' => ['required', 'string'],
            'cover' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]
    ]);
    
    // Test validation
    try {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'max:100'],
            'sinopsis' => ['required', 'string'],
            'cover' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        
        return response()->json([
            'status' => 'validation_passed',
            'validated_data' => $validated,
            'user_info' => [
                'id' => auth()->id(),
                'role' => auth()->user()->role,
                'is_admin' => auth()->user()->isAdmin(),
                'is_super_admin' => auth()->user()->isSuperAdmin(),
            ]
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => 'validation_failed',
            'errors' => $e->errors(),
            'user_info' => [
                'id' => auth()->id(),
                'role' => auth()->user()->role,
            ]
        ], 422);
    }
})->middleware(['auth', 'web']);