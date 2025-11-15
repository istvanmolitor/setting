<?php

namespace Molitor\Setting\Filament\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Gate;
use Molitor\Setting\Services\SettingHandlerService;

class SettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'setting::filament.pages.settings';
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-cog';

    public static function getNavigationLabel(): string
    {
        return 'Beállítások';
    }

    public static function canAccess(): bool
    {
        if(!Gate::allows('acl', 'setting')) {
            return false;
        }

        $settingHandler = app(SettingHandlerService::class);
        if($settingHandler->getDefaultSlug() === null) {;
            return false;
        }
        return true;
    }

    public function getTitle(): string|Htmlable
    {
        return 'Beállítások';
    }

    public ?array $formData = [];

    public string|null $settingSlug = null;

    public array $tabs = [];

    public function mount(): void
    {
        $settingHandler = app(SettingHandlerService::class);
        $defaultSlug = $settingHandler->getDefaultSlug();
        if($defaultSlug === null) {
            abort(403);
        }

        $this->tabs = $settingHandler->getTabs();
        $this->selectSettingTab($defaultSlug);
    }

    public function loadSettings(): void
    {
        /** @var SettingHandlerService $settingHandler */
        $settingHandler = app(SettingHandlerService::class);
        $this->formData = $settingHandler->getFormData($this->settingSlug);
        $this->form->fill($this->formData);
    }

    public function selectSettingTab(string $slug): void
    {
        $this->settingSlug = $slug;
        $this->loadSettings();
    }

    protected function getFormStatePath(): ?string
    {
        return 'formData';
    }

    protected function getFormSchema(): array
    {
        return app(SettingHandlerService::class)->getFormSchema($this->settingSlug);
    }

    public function save(): void
    {
        $this->form->validate();

        app(SettingHandlerService::class)->saveFormData($this->settingSlug, $this->formData);

        Notification::make()
            ->title('Beállítások mentve')
            ->success()
            ->send();
    }

    protected function getActions(): array
    {
        return [];
    }
}
