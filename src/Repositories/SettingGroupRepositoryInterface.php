<?php


namespace Molitor\Setting\Repositories;

use Molitor\Setting\Models\SettingGroup;

interface SettingGroupRepositoryInterface
{
    public function exists(string $slug): bool;

    public function getBySlug(string $slug): SettingGroup|null;

    public function create(string $name, string $slug, string $icon): SettingGroup;

    public function getDefault(): SettingGroup|null;
}
