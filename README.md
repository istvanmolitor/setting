# Setting modul

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
