<?php

namespace Packagit\Common\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Factory;
use Packagit\Common\Http\Controllers\BaseController;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Common';

    /**
     * @var string
     */
    protected $moduleNameLower = 'common';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(dirname(__DIR__, 2) . '/database/migrations');
        $this->registerResponseMacro();
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(dirname(__DIR__, 2) . '/resources/lang', $this->moduleNameLower);
    }

    public function registerResponseMacro()
    {
        Response::macro('ok', function ($message = 'success', $errCode = 0, $attachData = []) {
            return app(BaseController::class)
                ->ok($message, $errCode, $attachData);
        });

        Response::macro('error', function ($message = 'error', $errCode = 1000, $attachData = []) {
            return app(BaseController::class)
                ->error($message, $errCode, $attachData);
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__, 2) . '/config/config.php', $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $this->loadViewsFrom(dirname(__DIR__, 2) . '/resource/views', $this->moduleNameLower);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->register(RouteServiceProvider::class);
        if ($this->app->runningInConsole()) {
            $this->app->register(CommandServiceProvider::class);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
