<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     // app/Http/Middleware/AdminMiddleware.php
    public function handle(Request $request, Closure $next): Response
    {
        $user = JWTAuth::user();

        if (!$user || $user->role_id !== 1) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        return $next($request);
    }
}
