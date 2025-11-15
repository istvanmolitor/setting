<?php

namespace Molitor\Setting\Services;

use Illuminate\Support\Facades\Gate;
use Molitor\Setting\Repositories\SettingRepositoryInterface;

abstract class SettingForm
{
    protected function getRepository(): SettingRepositoryInterface
    {
        return app(SettingRepositoryInterface::class);
    }

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
        foreach ($this->getFormFields() as $field) {
            $this->getRepository()->set($slug . ':' . $field, $formData[$field] ?? null);
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
        $repository = $this->getRepository();
        foreach ($this->getFormFields() as $field) {
            $data[$field] = $repository->get($slug . ':' . $field, $defaults[$field] ?? null);
        }
        return $data;
    }

    public function beforeSave(array $previousFormData): void
    {
    }

    public function afterSave(array $formData): void
    {
    }

    public function get(string $name): mixed
    {
        $default = $this->getDefaults()[$name] ?? null;
        return $this->getRepository()->get($this->getSlug() . ':' . $name, $default);
    }

    public function set(string $name, mixed $value): void
    {
        $this->getRepository()->set($this->getSlug() . ':' . $name, $value);
    }

    public function canAccess(): bool
    {
        return Gate::allows('acl', 'setting');
    }
}
