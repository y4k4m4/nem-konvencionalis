<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App;
use App\Support\UserProvider;
use Auth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
     */
    public function boot(): void
    {
        Auth::provider('neo4j', function (Application $app, array $config) {
            return new UserProvider();
        });
    }
}
