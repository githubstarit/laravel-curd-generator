<?php

namespace Aiddroid\Generators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCurdControllerGenerator();
        $this->registerCurdViewGenerator();
    }

    /**
     * Register the make:controller:curd generator.
     */
    private function registerCurdControllerGenerator()
    {
        $this->app->singleton('command.aiddroid.curdcontroller', function ($app) {
            return $app['Aiddroid\Generators\Commands\MakeCurdControllerCommand'];
        });

        $this->commands('command.aiddroid.curdcontroller');
    }

    /**
     * Register the make:view:curd generator.
     */
    private function registerCurdViewGenerator()
    {
        $this->app->singleton('command.aiddroid.curdview', function ($app) {
            return $app['Aiddroid\Generators\Commands\MakeCurdViewCommand'];
        });

        $this->commands('command.aiddroid.curdview');
    }
}
