<?php

namespace AwemaPL\Printer;

use AwemaPL\Printer\Sections\Nodeprinters\Models\Nodeprinter;
use AwemaPL\Printer\Sections\Nodeprinters\Policies\NodeprinterPolicy;
use AwemaPL\Printer\Sections\Printers\Policies\PrinterPolicy;
use AwemaPL\Printer\Sections\Nodeprinters\Repositories\Contracts\NodeprinterRepository;
use AwemaPL\Printer\Sections\Nodeprinters\Repositories\EloquentNodeprinterRepository;
use AwemaPL\Printer\Sections\Nodeprinters\Services\Nodeprinter as NodeprinterService;
use AwemaPL\Printer\Sections\Printers\Repositories\Contracts\PrinterRepository;
use AwemaPL\Printer\Sections\Printers\Repositories\EloquentPrinterRepository;
use AwemaPL\Printer\Sections\Settings\Repositories\Contracts\SettingRepository;
use AwemaPL\Printer\Sections\Settings\Repositories\EloquentSettingRepository;
use AwemaPL\BaseJS\AwemaProvider;
use AwemaPL\Printer\Listeners\EventSubscriber;
use AwemaPL\Printer\Sections\Installations\Http\Middleware\GlobalMiddleware;
use AwemaPL\Printer\Sections\Installations\Http\Middleware\GroupMiddleware;
use AwemaPL\Printer\Sections\Installations\Http\Middleware\Installation;
use AwemaPL\Printer\Sections\Installations\Http\Middleware\RouteMiddleware;
use AwemaPL\Printer\Contracts\Printer as PrinterContract;
use Illuminate\Support\Facades\Event;
use AwemaPL\Printer\Sections\Nodeprinters\Services\Contracts\Nodeprinter as NodeprinterContract;

class PrinterServiceProvider extends AwemaProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Nodeprinter::class => NodeprinterPolicy::class,
        \AwemaPL\Printer\Sections\Printers\Models\Printer::class, PrinterPolicy::class,
    ];

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'printer');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'printer');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->bootMiddleware();
        app('printer')->includeLangJs();
        app('printer')->menuMerge();
        app('printer')->mergePermissions();
        $this->registerPolicies();
        Event::subscribe(EventSubscriber::class);
        parent::boot();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/printer.php', 'printer');
        $this->mergeConfigFrom(__DIR__ . '/../config/printer-menu.php', 'printer-menu');
        $this->app->bind(PrinterContract::class, Printer::class);
        $this->app->singleton('printer', PrinterContract::class);
        $this->registerRepositories();
        $this->registerServices();
        parent::register();
    }


    public function getPackageName(): string
    {
        return 'printer';
    }

    public function getPath(): string
    {
        return __DIR__;
    }

    /**
     * Register and bind package repositories
     *
     * @return void
     */
    protected function registerRepositories()
    {
        $this->app->bind(SettingRepository::class, EloquentSettingRepository::class);
        $this->app->bind(PrinterRepository::class, EloquentPrinterRepository::class);
        $this->app->bind(NodeprinterRepository::class, EloquentNodeprinterRepository::class);
    }

    /**
     * Register and bind package services
     *
     * @return void
     */
    protected function registerServices()
    {
        $this->app->bind(NodeprinterContract::class, NodeprinterService::class);
    }


    /**
     * Boot middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootMiddleware()
    {
        $this->bootGlobalMiddleware();
        $this->bootRouteMiddleware();
        $this->bootGroupMiddleware();
    }

    /**
     * Boot route middleware
     */
    private function bootRouteMiddleware()
    {
        $router = app('router');
        $router->aliasMiddleware('printer', RouteMiddleware::class);
    }

    /**
     * Boot grEloquentAccountRepositoryoup middleware
     */
    private function bootGroupMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->appendMiddlewareToGroup('web', GroupMiddleware::class);
        $kernel->appendMiddlewareToGroup('web', Installation::class);
    }

    /**
     * Boot global middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootGlobalMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->pushMiddleware(GlobalMiddleware::class);
    }
}
