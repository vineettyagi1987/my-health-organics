<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip console, API, and admin routes if needed
        if (!app()->runningInConsole() && !$request->is('admin/*')) {

            DB::table('visits')->updateOrInsert(
                [
                    'ip' => $request->ip(),
                    'visit_date' => now()->toDateString(),
                ],
                [
                     'page_views' => DB::raw('page_views + 1'),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return $next($request);
    }
}
