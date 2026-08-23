# Setting modul

Egyszerű kulcs-érték alapú alkalmazásbeállítás-tároló Laravel projektekhez, form builder alapú (`SettingForm`) beállítás-csoportokkal és admin API-val.

## Függőségek

- `istvanmolitor/user` (composer `require`) – a `permission:setting` middleware-hez.

## Telepítés

1) Telepítés Composerrel

Ha önálló csomagként használod:

```
composer require istvanmolitor/setting
```

Monorepo/fejlesztői környezetben (path repository-val) add hozzá a gyökér `composer.json`-hoz:

```json
{
    "require": {
        "istvanmolitor/setting": "*@dev"
    },
    "repositories": [
        {
            "type": "path",
            "url": "packages/setting"
        }
    ]
}
```

2) Autodiscovery

A csomag Laravel Package Discovery-val regisztrálja a `Molitor\Setting\Providers\SettingServiceProvider`-t, ami betölti a migrációkat, a `setting` névterű nézeteket és az `api` route-okat.

3) Migrációk futtatása

```bash
php artisan migrate
```

## Használat

### `setting()` helper

A csomag globális helpert biztosít egy beállítás lekérdezéséhez (`slug` = beállításcsoport, `name` = mező neve):

```php
$value = setting('shop', 'default_currency');
```

### `SettingForm` – saját beállítás-csoport létrehozása

Egy `SettingForm`-ot kiterjesztő osztály definiálja egy beállításcsoport mezőit (`SettingFieldType` enum: pl. text, select, boolean), validációs szabályait és jogosultságát:

```php
use Molitor\Setting\Services\SettingForm;
use Molitor\Setting\Enums\SettingFieldType;

class ShopSettingForm extends SettingForm
{
    public function getSlug(): string
    {
        return 'shop';
    }

    public function getLabel(): string
    {
        return 'Shop beállítások';
    }

    public function getFields(): array
    {
        return [
            'default_currency' => ['type' => SettingFieldType::Text, 'label' => 'Alapértelmezett deviza'],
        ];
    }
}
```

### Admin API (`/api/setting`, `auth:sanctum` + `permission:setting`)

- `GET api/setting` – beállítás-csoportok listája
- `GET api/setting/{slug}` – egy csoport aktuális értékei
- `POST api/setting/{slug}` – egy csoport értékeinek mentése

### Események

- `Molitor\Setting\Events\SettingBeforeSaveEvent`
- `Molitor\Setting\Events\SettingAfterSaveEvent`

## Repository

A provider a `Molitor\Setting\Repositories\SettingRepositoryInterface`-t köti a `SettingRepository` implementációhoz.

## Seeder regisztrálása

A jogosultságok kezdeti beállításához regisztráld a seedert a `database/seeders/DatabaseSeeder.php` fájlban:

```php
use Molitor\Setting\database\seeders\SettingSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
        ]);
    }
}
```

## Licenc

MIT
