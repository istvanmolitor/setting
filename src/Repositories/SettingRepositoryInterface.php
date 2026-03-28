<?php

namespace Molitor\Setting\Repositories;

interface SettingRepositoryInterface
{
    public function exists($name): bool;

    public function set($name, $value): self;

    public function get($name, $defaultValue = null): mixed;

    public function clear(string $name): self;

    public function getValues(array $values): array;

    public function setValues(array $values): void;
}
