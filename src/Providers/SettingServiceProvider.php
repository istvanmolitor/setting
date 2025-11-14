<?php

namespace Molitor\Setting\Providers;

use Illuminate\Support\ServiceProvider;
use Molitor\Setting\Repositories\SettingRepository;
use Molitor\Setting\Repositories\SettingRepositoryInterface;
use Molitor\Setting\Services\SettingHandlerService;

class SettingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'setting');
    }

    public function register()
    {
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);

        $this->app->singleton(SettingHandlerService::class, function () {
            return new SettingHandlerService();
        });
    }
}
