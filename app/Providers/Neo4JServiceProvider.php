<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Contracts\ClientInterface;

class Neo4JServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ClientInterface::class, function () {
            return ClientBuilder::create()
                ->withDriver('bolt', 'bolt://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST'))
                ->withDefaultDriver('bolt')
                ->build();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
