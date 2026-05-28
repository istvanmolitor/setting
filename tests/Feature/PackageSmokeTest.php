<?php

namespace Molitor\Setting\Tests\Feature;

use Molitor\Setting\Providers\SettingServiceProvider;
use Tests\TestCase;

class PackageSmokeTest extends TestCase
{
    public function test_service_provider_is_loaded(): void
    {
        $this->assertTrue(class_exists(SettingServiceProvider::class));
        $this->assertTrue($this->app->providerIsLoaded(SettingServiceProvider::class));
    }
}

