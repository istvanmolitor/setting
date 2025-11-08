# Setting modul

Beállítások kezelése

## Telepítés

### Provider regisztrálása
config/app.php
```php
'providers' => ServiceProvider::defaultProviders()->merge([
    /*
    * Package Service Providers...
    */
    \Molitor\Setting\Providers\SettingServiceProvider::class,
])->toArray(),
```