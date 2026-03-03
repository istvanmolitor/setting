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

    abstract public function getFields(): array;

    public function getDefaultValues(): array
    {
        return [];
    }

    public function prepareValues(array $values): array
    {
        $defaultValues = $this->getDefaultValues();
        $preparedValues = [];
        foreach ($this->getFields() as $field) {
            $preparedValues[$field] = $values[$field] ?? $defaultValues[$field] ?? null;
        }
        return $preparedValues;
    }

    public function saveValues(array $values): void
    {
        $oldValues = $this->getValues();

        $slug = $this->getSlug();
        $preparedValues = $this->prepareValues($values);

        $this->beforeSave($oldValues, $preparedValues);

        $repository = $this->getRepository();
        foreach ($preparedValues as $fieldName => $value) {
            $repository->set($slug . ':' . $fieldName, $value);
        }
    }

    public function getValues(): array
    {
        $slug = $this->getSlug();
        $defaultValues = $this->getDefaultValues();

        $data = [];
        $repository = $this->getRepository();
        foreach ($this->getFields() as $field) {
            $data[$field] = $repository->get($slug . ':' . $field, $defaultValues[$field] ?? null);
        }
        return $data;
    }

    public function getData(): array
    {
        return [];
    }

    public function beforeSave(array $oldValues, array $values): void
    {
    }

    public function afterSave(array $values): void
    {
    }

    public function fieldExists(string $name): bool
    {
        return array_key_exists($name, $this->getFields());
    }

    public function get(string $name): mixed
    {
        $default = $this->getDefaultValues()[$name] ?? null;
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

    public function toArray(): array
    {
        return [
            'slug' => $this->getSlug(),
            'label' => $this->getLabel(),
            'values' => $this->getValues(),
            'data' => $this->getData(),
        ];
    }
}
