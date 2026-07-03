<?php

use Molitor\Setting\Services\SettingHandler;

if (! function_exists('setting')) {
    function setting(string $slug, string $name): mixed
    {
        return app(SettingHandler::class)->get($slug, $name);
    }
}
