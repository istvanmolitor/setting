<?php

namespace Molitor\Setting\Repositories;

use Molitor\Setting\Models\SettingGroup;

class SettingGroupRepository implements SettingGroupRepositoryInterface
{
    private SettingGroup $settingGroup;

    public function __construct()
    {
        $this->settingGroup = new SettingGroup();
    }

    public function exists(string $slug): bool
    {
        return $this->settingGroup->where('slug', $slug)->exists();
    }

    public function getBySlug(string $slug): SettingGroup|null
    {
        return $this->settingGroup->where('slug', $slug)->first();
    }

    public function create(string $name, string $slug, string $icon): SettingGroup
    {
        return $this->settingGroup->create([
            'name' => $name,
            'slug' => $slug,
            'icon' => $icon,
        ]);
    }

    public function getDefault(): SettingGroup|null
    {
        return $this->settingGroup->orderBy('name')->first();
    }
}
