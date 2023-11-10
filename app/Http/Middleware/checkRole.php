<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // dd($roles);
        $user = $request->user();

        if (!$user || !in_array($user->role_id, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
