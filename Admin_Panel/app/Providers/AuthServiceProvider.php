<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    // protected $permissions = ['show-products', 'delete-products'];
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('has-permission', function ($user, $permissions) {
            if (is_string($permissions)) {
                $permissions = [$permissions];
            }
            // dd($user->permissions()->whereIn('name', $permissions)->exists());
            return $user->permissions()->whereIn('name', $permissions)->exists();
        });
        
        // Gate::define('show-products', function ($user) {
        //     return Gate::allows('has-any-permission', ['show-products']);
        // });
        
        // Gate::define('edit-products', function ($user) {
        //     return Gate::allows('has-any-permission', ['edit-products', 'show-products']);
        // });
        
        // Gate::define('delete-products', function ($user) {
        //     return Gate::allows('has-any-permission', ['delete-products', 'show-products', 'edit-products']);
        // });
        // Gate::define('show-admins', function ($user) {
        //     return Gate::allows('has-any-permission', ['show-admins']);
        // });
        
        // Gate::define('manage-admins', function ($user) {
        //     return Gate::allows('has-any-permission', ['show-admins', 'delete-admins', 'edit-admins','create-admins']);
        // });
    }
}
