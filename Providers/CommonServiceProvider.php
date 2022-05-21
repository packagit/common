<?php

namespace Package\Component\Common\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Package\Component\Common\Http\Controllers\BaseController;

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
        $this->loadMigrationsFrom(dirname(__DIR__) . '/Database/Migrations');
        $this->registerResponseMacro();
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(dirname(__DIR__) . '/Resources/lang', $this->moduleNameLower);
        }
    }

    public function registerResponseMacro()
    {
        Response::macro('ok', function ($message, $errCode = 0, $data = []) {
            return app(BaseController::class)
                ->ok($message, $errCode, $data);
        });

        Response::macro('error', function ($message, $errCode = 1000, $data = null) {
            return app(BaseController::class)
                ->error($message, $errCode, $data);
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        // uncomment when you need publish package config
        //        $this->publishes([
        //            dirname(__DIR__) . '/Config/config.php' => config_path($this->moduleNameLower . '.php'),
        //        ], 'config');

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/config.php',
            $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = dirname(__DIR__) . '/Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }

        return $paths;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
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
