<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate::define('seminarista', function(User $user){
        //     return $user->permissions() === 2;
        // });

        Gate::define('admin', function (User $user) {
            return $user->permissions->contains('id', 1); // Verifica se o usuário tem a permissão com ID 1
        });

        Gate::define('librarian', function (User $user) {
            return $user->permissions->contains('id', 4); // Verifica se o usuário tem a permissão com ID 4
        });
    }
}
