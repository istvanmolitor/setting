<?php


namespace Molitor\Setting\Repositories;


use Molitor\Setting\Models\Setting;
use Molitor\Setting\Models\SettingGroup;

interface SettingRepositoryInterface
{
    public function create(
        SettingGroup $settingGroup,
        string $name,
        string $defaultValue,
        string $label,
        string $type,
        string $description
    ): Setting;

    public function exists($name): bool;

    public function set($name, $value): self;

    public function get($name, $defaultValue = NULL): mixed;

    public function clear(string $name): self;

    public function getValues(array $values): array;

    public function setValues(array $values): void;

    public function getValuesBySettingGroup(SettingGroup $settingGroup): array;
}
