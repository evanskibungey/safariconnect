<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;

class PreventAdminRegistration
{
    /**
     * Handle an incoming request.
     * Prevents admin registration if an admin already exists
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if admin already exists
        if (Admin::adminExists()) {
            // Log the attempt for security monitoring
            \Log::warning('Attempt to access admin registration when admin already exists', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'timestamp' => now()
            ]);

            // Return 403 Forbidden with clear message
            abort(403, 'Admin registration is permanently disabled. Only one admin account is allowed for security reasons.');
        }

        return $next($request);
    }
}
