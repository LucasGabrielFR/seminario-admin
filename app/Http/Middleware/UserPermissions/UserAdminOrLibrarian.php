<?php

namespace App\Http\Middleware\UserPermissions;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAdminOrLibrarian
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

        // Verifica se o usuário possui a permissão de admin (ID = 1) ou librarian (ID = 4)
        $hasPermission = $user->permissions->contains(function ($permission) {
            return $permission->id === 1 || $permission->id === 4;
        });

        if (!$hasPermission) {
            return redirect('/admin')->with('error', 'Acesso negado.');
        }

        return $next($request);
    }
}
