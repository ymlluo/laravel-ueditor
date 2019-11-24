<?php namespace ymlluo\Ueditor;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use ymlluo\Ueditor\Events\FileUploaded;
use ymlluo\Ueditor\Listeners\UploadResourceSave;
use ymlluo\Ueditor\Middleware\EditorCrossRequest;

class UeditorServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'ueditor');
        $this->loadTranslationsFrom(__DIR__.'/translations', 'ueditor');
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
        $router = app('router');
        $router->group(array_merge(['namespace' => __NAMESPACE__], config('ueditor.route.options', [])), function ($router) {
            $router->any(config('ueditor.route.url', '/serv/ueditor/server'), 'ServiceController@serve')->middleware(EditorCrossRequest::class);
        });
        if (config('ueditor.resource.enable')){
            if (version_compare(app()->version(),'5.3.0','>=')){
                Event::listen(FileUploaded::class,UploadResourceSave::class);
            }
            $router->group(array_merge(['namespace' => __NAMESPACE__], config('ueditor.route.options', [])), function ($router) {
                $router->get(config('ueditor.resource.route.index'), 'Controllers\ResourceManagerController@index')->name('resource.manager.index')->middleware(EditorCrossRequest::class);
                $router->get(config('ueditor.resource.route.edit'), 'Controllers\ResourceManagerController@edit')->name('resource.manager.edit')->middleware(EditorCrossRequest::class);
                $router->post(config('ueditor.resource.route.store'), 'Controllers\ResourceManagerController@store')->name('resource.manager.store')->middleware(EditorCrossRequest::class);
                $router->delete(config('ueditor.resource.route.destroy'), 'Controllers\ResourceManagerController@destroy')->name('resource.manager.destroy')->middleware(EditorCrossRequest::class);

            });
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/ueditor.php';
        $this->mergeConfigFrom($configPath, 'ueditor');
        $this->publishes([$configPath => config_path('ueditor.php')], 'config');
        $this->publishes([__DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'], 'migrations');
        // Register the service the package provides.
        $this->app->singleton('ueditor', function ($app) {
            return new Ueditor;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['ueditor'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/ueditor.php' => config_path('ueditor.php'),
        ], 'ueditor.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ymlluo'),
        ], 'ueditor.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ymlluo'),
        ], 'ueditor.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ymlluo'),
        ], 'ueditor.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
