<?php

namespace BwtTeam\LaravelAPI\Providers;

use BwtTeam\LaravelAPI\Response\ApiResponse;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();

        if(!$this->isLumen()) {
            $this->app->make('Illuminate\Contracts\Routing\ResponseFactory')->macro('api', [ApiResponse::class, 'create']);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $configPath = __DIR__ . '/../../config/api.php';

        if (function_exists('config_path')) {
            $publishPath = config_path('api.php');
        } else {
            $publishPath = base_path('config/api.php');
        }

        $this->publishes([$configPath => $publishPath], 'config');
        $this->mergeConfigFrom($configPath, 'api');
    }

    /**
     * Check if package is running under Lumen app.
     *
     * @return bool
     */
    protected function isLumen()
    {
        return is_a(\app(), 'Laravel\Lumen\Application');
    }
}
