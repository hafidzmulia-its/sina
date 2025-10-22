<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            Log::warning('AdminAccess: User not authenticated', [
                'route' => $request->route()?->getName(),
                'url' => $request->url()
            ]);
            
            // Redirect to login instead of aborting
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();
        
        // Check if user has admin privileges
        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            Log::warning('AdminAccess: User lacks admin privileges', [
                'user_id' => $user->id,
                'user_role' => $user->role ?? 'unknown',
                'route' => $request->route()?->getName()
            ]);
            
            // Redirect to dashboard instead of aborting
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Hanya admin dan super admin yang diizinkan.');
        }

        Log::info('AdminAccess: Access granted', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'route' => $request->route()?->getName()
        ]);

        return $next($request);
    }
}