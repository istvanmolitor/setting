<?php


namespace Molitor\Setting\Repositories;

use Molitor\Setting\Models\Setting;
use Molitor\Setting\Models\SettingGroup;

class SettingRepository implements SettingRepositoryInterface
{
    private Setting $setting;
    private array $data;

    public function __construct()
    {
        $this->setting = new Setting();
        $this->init();
    }

    protected function init()
    {
        $this->data = [];
        foreach ($this->setting->get() as $setting) {
            $this->data[$setting->name] = unserialize($setting->value);
        }
    }

    public function exists($name): bool
    {
        return array_key_exists($name, $this->data);
    }

    public function set($name, $value): self
    {
        if ($this->exists($name)) {
            $this->setting->where('name', $name)->update(
                [
                    'value' => serialize($value),
                ]
            );
        } else {
            $this->setting->create(
                [
                    'name' => $name,
                    'value' => serialize($value),
                ]
            );
        }
        $this->data[$name] = $value;
        return $this;
    }

    public function get($name, $defaultValue = NULL): mixed
    {
        return $this->exists($name) ? $this->data[$name] : $defaultValue;
    }

    public function clear(string $name): self
    {
        $this->setting->where('name', $name)->delete();
        return $this;
    }

    public function getValues(array $values): array
    {
        $resultValues = [];
        foreach ($values as $name => $defaultValue) {
            $resultValues[$name] = $this->get($name, $defaultValue);
        }
        return $resultValues;
    }

    public function setValues(array $values): void
    {
        foreach ($values as $name => $value) {
            $this->set($name, $value);
        }
    }

    public function create(SettingGroup $settingGroup, string $name, string $defaultValue, string $label, string $type, string $description): Setting
    {
        return $this->setting->create([
            'setting_group_id' => $settingGroup->id,
            'name' => $name,
            'default_value' => serialize($defaultValue),
            'label' => $label,
            'type' => $type,
            'description' => $description,
        ]);
    }

    public function getValuesBySettingGroup(SettingGroup $settingGroup): array
    {
        $resultValues = [];
        /** @var Setting $setting */
        foreach ($settingGroup->settings as $setting) {
            $resultValues[$setting->name] = $this->get($setting->name, $setting->default_value);
        }
        return $resultValues;
    }
}
