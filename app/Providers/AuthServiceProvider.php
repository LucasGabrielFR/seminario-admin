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
            $isAdmin = false;
            foreach ($user->permissions as $permission) {
                if ((int)$permission->id === 1) {
                    $isAdmin = true;
                    break;
                }
            }
            return $isAdmin;
        });
    }
}
