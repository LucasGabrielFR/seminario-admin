<?php

namespace App\Http\Middleware\UserPermissions;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSeminarian
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

        $sValid = false;
        foreach ($user->permissions as $permission) {
            if ($permission->id === 2) {
                $sValid = true;
                break;
            }
        }

        if (!$sValid) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
