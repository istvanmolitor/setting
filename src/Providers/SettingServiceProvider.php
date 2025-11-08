<?php

namespace Molitor\Setting\Providers;

use Illuminate\Support\ServiceProvider;
use Molitor\Setting\Repositories\SettingGroupRepository;
use Molitor\Setting\Repositories\SettingGroupRepositoryInterface;
use Molitor\Setting\Repositories\SettingRepository;
use Molitor\Setting\Repositories\SettingRepositoryInterface;

class SettingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'setting');
    }

    public function register()
    {
        $this->app->bind(SettingGroupRepositoryInterface::class, SettingGroupRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
    }
}
