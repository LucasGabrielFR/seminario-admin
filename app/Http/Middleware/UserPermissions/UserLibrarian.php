<?php

namespace App\Http\Middleware\UserPermissions;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLibrarian
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

        $isValid= false;
        foreach ($user->permissions as $permission) {
            if ($permission->id === 4) {
                $isValid = true;
                break;
            }
        }

        if (!$isValid) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
