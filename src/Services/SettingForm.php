<?php

namespace Molitor\Setting\Services;

use Filament\Schemas\Schema;
use Molitor\Setting\Repositories\SettingRepositoryInterface;

abstract class SettingForm
{
    abstract public function getSlug(): string;

    abstract public function getLabel(): string;
    abstract public function getForm(): array;

    public function getIcon(): string {
        return 'heroicon-o-cog';
    }

    public function getTab(): array
    {
        return [
            'slug' => $this->getSlug(),
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
        ];
    }

    abstract public function getFormFields(): array;

    public function saveFormData(array $formData): void
    {
        $slug = $this->getSlug();

        /** @var SettingRepositoryInterface $settingRepository */
        $settingRepository = app(SettingRepositoryInterface::class);
        foreach ($this->getFormFields() as $field) {
            $settingRepository->set($slug . ':' . $field, $formData[$field] ?? null);
        }
    }

    public function getDefaults(): array
    {
        return [];
    }

    public function getFormData(): array
    {
        $slug = $this->getSlug();
        $defaults = $this->getDefaults();

        $data = [];
        /** @var SettingRepositoryInterface $settingRepository */
        $settingRepository = app(SettingRepositoryInterface::class);
        foreach ($this->getFormFields() as $field) {
            $data[$field] = $settingRepository->get($slug . ':' . $field, $defaults[$field] ?? null);
        }
        return $data;
    }
}
