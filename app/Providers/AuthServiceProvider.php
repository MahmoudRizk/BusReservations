<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\AdminPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Enum\Roles;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('is-admin', [AdminPolicy::class, 'isAdmin']);

        Gate::define('is-admin', function($user){  
            foreach($user->roles as $role){  
                if ($role->role_name == Roles::Admin->toString()){ 
                    return True;
                }
            }
            return False; 

        });
    }
}
