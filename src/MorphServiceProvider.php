<?php

namespace Larakit;

use Larakit\Console\Commands\LarakitMorphCommand;

class MorphServiceProvider extends \Illuminate\Support\ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../publishes/' => base_path('/'),
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        foreach (rglob('*.php', 0, __DIR__ . '/../boot') as $file) {
            include_once $file;
        }


        //        \Route::middleware('api')
        //              ->prefix('api')
        //              ->namespace('Larakit\Controllers')
        //              ->group(function () {
        //                  foreach (rglob('*.php', 0, __DIR__ . '/../routes/') as $file) {
        //                      include_once $file;
        //                  };
        //              });
        $this->app->bind('larakit:morph', LarakitMorphCommand::class);
        $this->commands([
            'larakit:morph',
        ]);
    }
}
