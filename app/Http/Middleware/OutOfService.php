<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OutOfService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        /*
        |--------------------------------------------------------------------------
        | Out of Service Mode
        |--------------------------------------------------------------------------
        | When APP_OUT_OF_SERVICE=true, every web route will redirect to the
        | out-of-service page, except the out-of-service page itself.
        */

        if (config('app.out_of_service')) {
            if ($request->routeIs('out-of-service') || $request->is('out-of-service')) {
                return $next($request);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The application is currently out of service. Please try again later.'
                ], 503);
            }

            return redirect()->route('out-of-service');
        }

        return $next($request);
    }
}
