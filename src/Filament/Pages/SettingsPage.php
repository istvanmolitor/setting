<?php

namespace Molitor\Setting\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Molitor\Setting\Models\Setting;
use Molitor\Setting\Repositories\SettingGroupRepositoryInterface;
use Molitor\Setting\Repositories\SettingRepositoryInterface;

class SettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'setting::filament.pages.settings';
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-cog';

    public ?array $formData = [];

    protected ?SettingGroupRepositoryInterface $settingGroupRepository = null;
    protected ?SettingRepositoryInterface $settingRepository = null;

    public string|null $activeSettingGroupSlug = null;

    protected function ensureRepositories(): void
    {
        $this->settingGroupRepository ??= app(SettingGroupRepositoryInterface::class);
        $this->settingRepository ??= app(SettingRepositoryInterface::class);
    }

    public function mount(): void
    {
        $this->ensureRepositories();
        $this->activeSettingGroupSlug = $this->settingGroupRepository?->getDefault()?->slug;
        $this->loadSettings();
    }

    public function loadSettings(): void
    {
        $this->ensureRepositories();
        $settingGroup = $this->settingGroupRepository?->getBySlug($this->activeSettingGroupSlug);
        $this->formData = $this->settingRepository?->getValuesBySettingGroup($settingGroup);
    }

    protected function getFormStatePath(): ?string
    {
        return 'formData';
    }

    protected function getFormSchema(): array
    {
        $this->ensureRepositories();

        $settingGroup = $this->settingGroupRepository?->getBySlug($this->activeSettingGroupSlug);

        if (! $settingGroup) {
            return [];
        }

        return $settingGroup->settings->map(function (Setting $setting) {
            return match ($setting->type) {
                'text' => TextInput::make($setting->name)->label($setting->label),
                'number' => TextInput::make($setting->name)->numeric()->label($setting->label),
                'checkbox' => Toggle::make($setting->name)->label($setting->label),
                'textarea' => Textarea::make($setting->name)->label($setting->label),
                'select' => Select::make($setting->name)
                    ->label($setting->label)
                    ->options([]),
                default => TextInput::make($setting->name)->label($setting->label),
            };
        })->toArray();
    }

    public function save(): void
    {
        $this->ensureRepositories();
        foreach ($this->formData ?? [] as $key => $value) {
            $this->settingRepository?->set($key, $value);
        }

        Notification::make()
            ->title('Beállítások mentve')
            ->success()
            ->send();
    }

    protected function getActions(): array
    {
        // A Mentés gomb az űrlap alatt jelenjen meg, ezért itt nem jelenítünk meg akciókat.
        return [];
    }
}
