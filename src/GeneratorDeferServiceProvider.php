<?php

namespace Interpro\AdminPanelGenerator;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class GeneratorDeferServiceProvider extends ServiceProvider {

    protected $defer = true;

    /**
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        $this->publishes([__DIR__.'/config/files.php' => config_path('interpro/generator/files.php')]);
        $this->publishes([__DIR__.'/config/pages/examplepage.php' => config_path('interpro/generator/pages/examplepage.php')]);


        if(!File::isDirectory(resource_path('views/generator')))
        {
            File::makeDirectory(resource_path('views/generator'));
        }

        if(!File::isDirectory(resource_path('views/generator/admin')))
        {
            File::makeDirectory(resource_path('views/generator/admin'));
        }

        if(!File::isDirectory(resource_path('views/generator/admin/pages')))
        {
            File::makeDirectory(resource_path('views/generator/admin/pages'));
        }

        if(!File::isDirectory(resource_path('views/generator/admin/items')))
        {
            File::makeDirectory(resource_path('views/generator/admin/items'));
        }
    }

    /**
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Interpro\AdminPanelGenerator\Contracts\Factory\GeneratorFactory',
            'Interpro\AdminPanelGenerator\Factory\JSONGeneratorFactory'
        );

        $this->app->singleton(
            'Interpro\AdminPanelGenerator\Contracts\Generator',
            function($app)
            {
                $factory = $app->make('Interpro\AdminPanelGenerator\Contracts\Factory\GeneratorFactory');
                return $factory->createGenerator();
            }
        );

        //Регистрация команд
        $this->app->singleton(
            'generate:page.command',
            'Interpro\AdminPanelGenerator\Commands\GeneratePage'
        );

        $this->commands(['generate:page.command']);
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'generate:widget.command', 'generate:page.command',
            'Interpro\AdminPanelGenerator\Contracts\Generator'
        ];
    }

}
