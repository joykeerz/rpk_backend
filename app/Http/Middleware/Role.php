<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role as Roles;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $roles = Roles::all();

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($user->role_id == 2) {
            return $next($request);
        }

        foreach ($roles as $role) {
            if ($user->role_id == $role->id) {
                return $next($request);
            }
        }

        return redirect()->route('login');
    }
}
