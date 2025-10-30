<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BukuController;
use Illuminate\Http\Request;

// Comprehensive system health check
Route::get('/debug-system', function () {
    try {
        $info = [
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'app_url' => config('app.url'),
            'db_connection' => config('database.default'),
            'db_host' => config('database.connections.mysql.host'),
            'db_database' => config('database.connections.mysql.database'),
            'session_driver' => config('session.driver'),
            'cache_driver' => config('cache.default'),
            'filesystem_disk' => config('filesystems.default'),
        ];

        // Test database connection
        try {
            DB::connection()->getPdo();
            $info['db_status'] = 'Connected';
            $info['db_tables_count'] = count(DB::select('SHOW TABLES'));
            $info['users_count'] = DB::table('users')->count();
        } catch (\Exception $e) {
            $info['db_status'] = 'Failed';
            $info['db_error'] = $e->getMessage();
        }

        // Test session
        try {
            session(['test_key' => 'test_value_' . time()]);
            $info['session_status'] = session('test_key') ? 'Working' : 'Failed';
        } catch (\Exception $e) {
            $info['session_status'] = 'Failed';
            $info['session_error'] = $e->getMessage();
        }

        // Test Cloudinary config
        $info['cloudinary_configured'] = config('cloudinary.cloud_name') ? 'Yes' : 'No';

        return response()->json($info, 200, [], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        Log::error('System debug failed', ['error' => $e->getMessage()]);
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => explode("\n", $e->getTraceAsString())
        ], 500, [], JSON_PRETTY_PRINT);
    }
});

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