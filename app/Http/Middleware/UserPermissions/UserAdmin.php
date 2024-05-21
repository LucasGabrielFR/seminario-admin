<?php

namespace App\Http\Middleware\UserPermissions;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $isAdmin = false;
        foreach ($user->permissions as $permission) {
            if ($permission->id === 1) {
                $isAdmin = true;
                break;
            }
        }

        if (!$isAdmin) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
